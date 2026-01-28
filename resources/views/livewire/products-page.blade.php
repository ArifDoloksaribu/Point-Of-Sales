<div class="max-w-6xl mx-auto p-6">
    
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Manajemen Produk</h1>
        
        @if($mode == 'view')
            <div class="flex gap-2">
                <a href="{{ route('pos') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-bold">
                    &larr; Ke Kasir
                </a>
                <button wire:click="tambahbarang" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-bold shadow">
                    + Tambah Produk
                </button>
            </div>
        @endif
    </div>

    @if (session()->has('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4 border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    @if($mode == 'view')
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
            <div class="p-4 border-b bg-gray-50">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari Nama atau SKU Barang..." class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs font-bold">
                    <tr>
                        <th class="p-4 border-b">Foto</th>
                        <th class="p-4 border-b">SKU / Barcode</th>
                        <th class="p-4 border-b">Nama Produk</th>
                        <th class="p-4 border-b">Stok</th>
                        <th class="p-4 border-b text-right">Harga Modal</th>
                        <th class="p-4 border-b text-right">Harga Jual</th>
                        <th class="p-4 border-b text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($products as $product)
                        <tr class="hover:bg-blue-50">
                            <td class="p-4">
                                @if($product->image)
                                    <img src="{{ asset('storage/'.$product->image) }}" class="w-10 h-10 object-cover rounded bg-gray-200">
                                @else
                                    <div class="w-10 h-10 bg-gray-200 rounded flex items-center justify-center text-gray-500 text-xs">No</div>
                                @endif
                            </td>
                            <td class="p-4 font-mono font-bold">{{ $product->sku }}</td>
                            <td class="p-4 font-bold text-gray-700">{{ $product->name }}</td>
                            <td class="p-4">
                                <span class="{{ $product->stock < 10 ? 'text-red-600 font-bold' : 'text-green-600' }}">
                                    {{ $product->stock }}
                                </span>
                            </td>
                            <td class="p-4 text-right text-gray-500">Rp {{ number_format($product->cost_price, 0, ',', '.') }}</td>
                            <td class="p-4 text-right font-bold text-blue-600">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                            <td class="p-4 text-center">
                                <button wire:click="hapus({{ $product->id }})" wire:confirm="Yakin hapus produk ini?" class="text-red-500 hover:text-red-700 hover:underline">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="p-8 text-center text-gray-400">Data produk kosong.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="p-4 bg-gray-50 border-t">{{ $products->links() }}</div>
        </div>

    @elseif($mode == 'create')
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 max-w-2xl mx-auto p-6">
            <h2 class="text-xl font-bold mb-4 border-b pb-2">Form Tambah Produk</h2>
            
            <form wire:submit.prevent="simpan">
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-1">SKU / Barcode</label>
                    <input type="text" wire:model="sku" class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-500" placeholder="Scan barcode disini..." autofocus>
                    @error('sku') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-1">Nama Produk</label>
                    <input type="text" wire:model="name" class="w-full border p-2 rounded" placeholder="Contoh: Indomie Goreng">
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 font-bold mb-1">Harga Modal</label>
                        <input type="number" wire:model="cost_price" class="w-full border p-2 rounded" placeholder="0">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-1">Harga Jual</label>
                        <input type="number" wire:model="selling_price" class="w-full border p-2 rounded font-bold text-blue-600" placeholder="0">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 font-bold mb-1">Stok Awal</label>
                        <input type="number" wire:model="stock" class="w-full border p-2 rounded" placeholder="100">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-1">Foto Produk (Opsional)</label>
                        <input type="file" wire:model="image" class="w-full text-sm text-gray-500 border rounded cursor-pointer bg-gray-50 focus:outline-none">
                        <div wire:loading wire:target="image" class="text-xs text-blue-500 mt-1">Mengupload...</div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" wire:click="batal" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded font-bold">
                        Batal
                    </button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded font-bold shadow">
                        Simpan Produk
                    </button>
                </div>

            </form>
        </div>
    @endif

</div>