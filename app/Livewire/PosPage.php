<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class PosPage extends Component
{
    use WithPagination;

    // State / Properti
    public $cart = [];
    public $total = 0;
    public $payAmount = 0;
    public $change = 0;
    public $search = '';

    // Reset pagination saat user mengetik search
    public function updatingSearch()
    {
        $this->resetPage();
    }

    // 1. LISTENER SCANNER (Menerima input dari Kamera/Barcode)
    #[On('scan-code')]
    public function handleScan($code)
    {
        // Cari produk berdasarkan SKU
        $product = Product::where('sku', $code)->first();

        if ($product) {
            // Jika ketemu, masukkan ke keranjang
            $this->addToCart($product->id);
            // Kirim notifikasi sukses (opsional)
        } else {
            // Kirim notifikasi error
            session()->flash('error', 'Produk tidak ditemukan: ' . $code);
        }
    }

    // 2. LOGIKA KERANJANG BELANJA
    public function addToCart($productId)
    {
        $product = Product::find($productId);

        // Validasi stok (opsional, tapi disarankan)
        if ($product->stock <= 0) {
            session()->flash('error', 'Stok habis!');
            return;
        }
        
        if (isset($this->cart[$productId])) {
            // Jika barang sudah ada, tambah qty
            $this->cart[$productId]['qty']++;
        } else {
            // Jika barang baru, buat item baru di array
            $this->cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->selling_price, // PENTING: Ambil selling_price
                'qty' => 1
            ];
        }
        
        // Hitung ulang total belanja
        $this->calculateTotal();
    }

    // Menghapus item dari keranjang (Tombol X)
    public function removeFromCart($productId)
    {
        unset($this->cart[$productId]);
        $this->calculateTotal();
    }

    // Kalkulasi Total & Kembalian
    public function calculateTotal()
    {
        $this->total = 0;
        foreach ($this->cart as $item) {
            $this->total += $item['price'] * $item['qty'];
        }
        
        // Hitung kembalian jika user sudah input uang bayar
        // Casting ke int/float untuk menghindari error string
        $bayar = (float) $this->payAmount;
        $this->change = $bayar - $this->total;
    }

    // Setiap kali user mengetik uang bayar, update kembalian
    public function updatedPayAmount()
    {
        $this->calculateTotal();
    }

    // 3. LOGIKA CHECKOUT (SIMPAN KE DATABASE)
    public function checkout()
    {
        // Validasi Dasar
        if (empty($this->cart)) {
            session()->flash('error', 'Keranjang masih kosong!');
            return;
        }

        if ($this->payAmount < $this->total) {
            session()->flash('error', 'Uang pembayaran kurang!');
            return;
        }

        // DATABASE TRANSACTION (ACID)
        // Gunanya: Memastikan Header, Detail, dan Potong Stok berhasil semua.
        // Jika satu gagal, semua dibatalkan.
        DB::transaction(function () {
            
            // A. Buat Header Transaksi
            $transaction = Transaction::create([
                'invoice_number' => 'INV-' . time(), // Contoh generate nomor invoice unik
                'user_id' => 1, // Sementara hardcode user ID 1 (nanti diganti Auth::id())
                'total_amount' => $this->total,
                'pay_amount' => $this->payAmount,
                'change_amount' => $this->change,
                'created_at' => now(),
            ]);

            // B. Loop Keranjang untuk Buat Detail & Kurangi Stok
            foreach ($this->cart as $item) {
                // 1. Simpan ke tabel transaction_details
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['qty'],
                    'price' => $item['price'], // Harga saat transaksi terjadi
                ]);

                // 2. Kurangi Stok di tabel products
                Product::where('id', $item['id'])->decrement('stock', $item['qty']);
            }

        });

        // C. Reset Aplikasi setelah sukses
        $this->cart = [];
        $this->total = 0;
        $this->payAmount = 0;
        $this->change = 0;
        
        session()->flash('success', 'Transaksi Berhasil Disimpan!');
    }

    public function render()
    {
        // Query untuk Grid Produk dengan Pagination
        $products = Product::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('sku', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(12);

        return view('livewire.pos-page', [
            'products' => $products
        ]);
    }

    public function handleEnter(){
        $product = Product::where('sku', $this->search)->first();

        if($product){
            $this->addToCart($product->id);
            $this->search = '';
        }
    }
}