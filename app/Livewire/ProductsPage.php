<?php

namespace App\Livewire;

use Livewire\WithPagination;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use App\Models\Product;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class ProductsPage extends Component{
    use WithPagination, WithFileUploads;

    public $mode = 'view';
    
    public $sku, $name, $cost_price, $selling_price, $stock, $image;

    public $search = '';

    // form untuk menambahkan barang
    public function tambahbarang(){
        $this->reset(['sku', 'name', 'cost_price', 'selling_price', 'stock', 'image']);
        $this->mode = 'create';
    }

    public function batal(){
        $this->mode = 'view';
    }

    // menyimpan produk yang ditambahkan
    public function simpan(){
        $this->validate([
            'sku' => 'required|unique:products,sku',
            'name' => 'required',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ]);
        $imagePath = null;
        if($this->image){
            $imagePath = $this->image->store('products', 'public');
        }

        // Simpan ke Database
        Product::create([
            'sku' => $this->sku,
            'name' => $this->name,
            'cost_price' => $this->cost_price,
            'selling_price' => $this->selling_price,
            'stock' => $this->stock,
            'image' => $imagePath,
        ]);

        session()->flash('success', 'Produk berhasil ditambahkan!');
        $this->mode = 'view';
    }

    // hapus produk yang sudah tidak dipakai
    public function hapus($id){
        Product::find($id)->delete();
        session()->flash('success', 'Produk berhasil dihapus!');
    }

    public function render(){
        $products = Product::query()
            ->when($this->search, function($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                  ->orWhere('sku', 'like', '%'.$this->search.'%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.products-page', [
            'products' => $products
        ]);
    }
}