<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Transaction;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class TransactionPage extends Component
{
    use WithPagination;

    public $selectedTransaction = null;

    public function showDetail($id){
        // Ambil transaksi beserta detail barang & info produknya
        $this->selectedTransaction = Transaction::with('details.product', 'user')->find($id);
    }

    public function closeDetail(){
        $this->selectedTransaction = null;
    }

    public function render()
    {
        // Ambil data transaksi, urutkan dari yang terbaru
        $transactions = Transaction::with('user') // Load data kasir juga
            ->latest()
            ->paginate(10);

        return view('livewire.transaction-page', [
            'transactions' => $transactions
        ]);
    }
}