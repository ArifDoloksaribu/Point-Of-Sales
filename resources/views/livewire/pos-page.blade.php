<div class="flex h-screen overflow-hidden">
    
    <div class="w-2/3 flex flex-col bg-gray-50 border-r">
        
        <div class="p-4 bg-white shadow-sm z-10">
            <div class="flex justify-between items-center mb-4 px-1">
                <h2 class="font-bold text-lg text-gray-800">Aplikasi Kasir</h2>
                <a href="{{route('history')}}" class="text-sm text-blue-600 hover:underline font-bold">Riwayat Transaksi &rarr;</a>
            </div>
            <div class="relative">
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="search"
                    wire:keydown.enter="handleEnter"
                    placeholder="Scan barcode atau cari nama barang..." 
                    class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    autofocus>
                <div class="absolute left-3 top-3.5 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto p-4">
            <div wire:loading wire:target="search" class="w-full text-center py-4 text-blue-600 font-bold">
            </div>

            <div class="grid grid-cols-3 xl:grid-cols-4 gap-4">
                @forelse($products as $product)
                    <div 
                        wire:click="addToCart({{ $product->id }})"
                        class="bg-white rounded-xl shadow-sm hover:shadow-md cursor-pointer border border-gray-200 transition-all active:scale-95 flex flex-col overflow-hidden group"
                    >
                        <div class="h-28 bg-gray-100 flex items-center justify-center text-gray-400 group-hover:bg-blue-50 transition">
                             @if($product->image)
                                <img src="{{ asset('storage/'.$product->image) }}" class="h-full w-full object-cover">
                             @else
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                </svg>
                             @endif
                        </div>

                        <div class="p-3">
                            <h3 class="font-bold text-gray-800 text-sm line-clamp-2 h-10">{{ $product->name }}</h3>
                            <p class="text-xs text-gray-500 mt-1">{{ $product->sku }}</p>
                            <div class="flex justify-between items-center mt-2">
                                <span class="text-blue-600 font-bold">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</span>
                                <span class="text-xs bg-gray-100 px-2 py-1 rounded text-gray-600">Stok: {{ $product->stock }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-4 text-center py-10 text-gray-400">
                        Produk tidak ditemukan.
                    </div>
                @endforelse
            </div>
            
            <div class="mt-6">
                {{ $products->links() }}
            </div>
        </div>
    </div>

    <div class="w-1/3 bg-white flex flex-col h-full shadow-xl border-l z-20">
        
        <div class="p-4 bg-gray-800 text-white flex justify-between items-center shadow">
            <h2 class="font-bold text-lg flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                </svg>
                Keranjang
            </h2>
            <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">{{ count($cart) }} Item</span>
        </div>

        <div class="flex-1 overflow-y-auto p-2 space-y-2 bg-gray-50">
            @if(empty($cart))
                <div class="flex flex-col items-center justify-center h-full text-gray-400 opacity-50">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 mb-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                    </svg>
                    <p>Keranjang Kosong</p>
                </div>
            @else
                @foreach($cart as $key => $item)
                    <div class="bg-white p-3 rounded shadow-sm border border-gray-100 flex justify-between items-center">
                        <div class="flex-1">
                            <h4 class="font-bold text-gray-800 text-sm">{{ $item['name'] }}</h4>
                            <div class="text-xs text-gray-500">
                                Rp {{ number_format($item['price'], 0, ',', '.') }} x {{ $item['qty'] }}
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="font-bold text-gray-700">Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}</span>
                            <button wire:click="removeFromCart({{ $key }})" class="text-red-400 hover:text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="bg-white p-4 border-t shadow-[0_-5px_15px_rgba(0,0,0,0.05)] z-30">
            @if (session()->has('error'))
                <div class="bg-red-100 text-red-700 p-2 text-sm rounded mb-2 text-center">
                    {{ session('error') }}
                </div>
            @endif
             @if (session()->has('success'))
                <div class="bg-green-100 text-green-700 p-2 text-sm rounded mb-2 text-center">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-between items-center mb-2">
                <span class="text-gray-600">Total</span>
                <span class="text-2xl font-bold text-gray-800">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>

            <div class="mb-4">
                <label class="text-xs text-gray-500 font-bold uppercase">Uang Tunai (Bayar)</label>
                <input 
                    type="number" 
                    wire:model.live="payAmount" 
                    class="w-full text-right p-2 border rounded font-mono text-lg focus:ring-2 focus:ring-green-500"
                    placeholder="0"
                >
            </div>

            <div class="flex justify-between items-center mb-4 text-sm {{ $change < 0 ? 'text-red-500' : 'text-green-600' }}">
                <span class="font-bold">Kembalian</span>
                <span class="font-bold text-lg">Rp {{ number_format($change, 0, ',', '.') }}</span>
            </div>

            <button 
                wire:click="checkout"
                wire:loading.attr="disabled"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg shadow transition disabled:opacity-50"
            >
                <span wire:loading.remove>PROSES BAYAR</span>
                <span wire:loading>Memproses...</span>
            </button>
        </div>
    </div>
</div>