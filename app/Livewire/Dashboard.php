<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaction;
use App\Models\Product;
use Carbon\Carbon;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class Dashboard extends Component
{
    public function render()
    {
        // 1. Hitung Omset Hari Ini
        $todaySales = Transaction::whereDate('created_at', Carbon::today())->sum('total_amount');

        // 2. Hitung Jumlah Transaksi Hari Ini
        $todayTransactions = Transaction::whereDate('created_at', Carbon::today())->count();

        // 3. Hitung Total Produk
        $totalProducts = Product::count();

        // 4. Cek Barang Stok Menipis (Kurang dari 10)
        $lowStockProducts = Product::where('stock', '<', 10)->get();

        return view('livewire.dashboard', [
            'todaySales' => $todaySales,
            'todayTransactions' => $todayTransactions,
            'totalProducts' => $totalProducts,
            'lowStockProducts' => $lowStockProducts
        ]);
    }
}