<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\PosPage;
use App\Livewire\Dashboard;
use App\Livewire\ProductsPage;
use App\Livewire\TransactionPage;

Route::get('/pos', PosPage::class)->name('pos');
Route::get('/riwayat', TransactionPage::class)->name('history');
Route::get('/produk', ProductsPage::class)->name('product');
Route::get('/', Dashboard::class)->name('dashboard');