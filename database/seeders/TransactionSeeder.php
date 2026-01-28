<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Ambil semua produk dan kasir yang ada
        $products = Product::all();
        $cashiers = User::all();

        // Jika data kosong, stop biar gak error
        if($products->isEmpty() || $cashiers->isEmpty()) return;

        // Buat 15 Transaksi Dummay
        for ($i = 0; $i < 15; $i++) {
            
            // 1. Pilih Kasir Acak & Tanggal Acak (bulan ini)
            $cashier = $cashiers->random();
            $date = Carbon::now()->subDays(rand(0, 30))->setTime(rand(8, 21), rand(0, 59));

            // 2. Buat Header Transaksi Dulu (Total 0 dulu)
            $transaction = Transaction::create([
                'invoice_number' => 'INV-' . $date->format('Ymd') . '-' . rand(1000, 9999),
                'user_id' => $cashier->id,
                'total_amount' => 0,
                'pay_amount' => 0,
                'change_amount' => 0,
                'created_at' => $date,
                'updated_at' => $date,
            ]);

            // 3. Isi Keranjang Belanja (Random 1 - 5 jenis barang)
            $totalBelanja = 0;
            $jumlahJenisBarang = rand(1, 5);
            
            // Ambil produk acak sejumlah $jumlahJenisBarang
            $randomProducts = $products->random($jumlahJenisBarang);

            foreach ($randomProducts as $product) {
                $qty = rand(1, 4); // Beli 1 sampai 4 pcs
                $price = $product->selling_price; // Harga saat transaksi
                $subtotal = $price * $qty;

                // Simpan ke Detail
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'price' => $price,
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);

                $totalBelanja += $subtotal;
            }

            // 4. Update Header Transaksi dengan Total Asli
            // Simulasi bayar: Total dibulatkan ke atas (misal 10rb, bayar 20rb atau 50rb)
            $bayar = ceil($totalBelanja / 50000) * 50000; 
            if($bayar < $totalBelanja) $bayar = $totalBelanja + rand(1000, 50000);

            $transaction->update([
                'total_amount' => $totalBelanja,
                'pay_amount' => $bayar,
                'change_amount' => $bayar - $totalBelanja,
            ]);
        }
    }
}