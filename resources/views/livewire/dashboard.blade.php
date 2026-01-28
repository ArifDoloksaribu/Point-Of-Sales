<div class="max-w-6xl mx-auto p-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Dashboard Toko</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <div class="bg-white p-6 rounded-xl shadow border-l-4 border-green-500 flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-bold uppercase">Omset Hari Ini</p>
                <h2 class="text-2xl font-bold text-gray-800 mt-1">Rp {{ number_format($todaySales, 0, ',', '.') }}</h2>
            </div>
            <div class="bg-green-100 p-3 rounded-full text-green-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.75v.757c0 .621.504 1.125 1.125 1.125v9.375m-8.334 0c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5c-.621 0-1.125-.504-1.125-1.125v-4.5c0-.621.504-1.125 1.125-1.125h4.5Z" />
                </svg>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow border-l-4 border-blue-500 flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-bold uppercase">Transaksi Hari Ini</p>
                <h2 class="text-2xl font-bold text-gray-800 mt-1">{{ $todayTransactions }} <span class="text-sm font-normal text-gray-400">Nota</span></h2>
            </div>
            <div class="bg-blue-100 p-3 rounded-full text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow border-l-4 border-purple-500 flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-bold uppercase">Total Produk</p>
                <h2 class="text-2xl font-bold text-gray-800 mt-1">{{ $totalProducts }} <span class="text-sm font-normal text-gray-400">Jenis</span></h2>
            </div>
            <div class="bg-purple-100 p-3 rounded-full text-purple-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0-3-3m3 3 3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                </svg>
            </div>
        </div>

        <div class="bg-blue-600 p-6 rounded-xl shadow text-white flex flex-col justify-center items-center gap-3">
            <h3 class="font-bold text-lg">Mulai Jualan?</h3>
            <a href="{{ route('pos') }}" class="bg-white text-blue-700 px-6 py-2 rounded-full font-bold hover:bg-gray-100 transition shadow-lg w-full text-center">
                Buka Kasir &rarr;
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
            <div class="p-4 border-b bg-red-50 flex justify-between items-center">
                <h3 class="font-bold text-red-700 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>
                    Stok Menipis (< 10)
                </h3>
                <a href="{{ route('product') }}" class="text-xs text-red-600 hover:underline">Kelola Stok &rarr;</a>
            </div>
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-500">
                    <tr>
                        <th class="p-3">Barang</th>
                        <th class="p-3 text-center">Sisa Stok</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($lowStockProducts as $product)
                        <tr>
                            <td class="p-3 font-medium text-gray-800">{{ $product->name }}</td>
                            <td class="p-3 text-center">
                                <span class="bg-red-100 text-red-800 text-xs font-bold px-2 py-1 rounded-full">
                                    {{ $product->stock }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="p-6 text-center text-gray-400">Aman! Tidak ada stok yang kritis.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl shadow p-6 text-white flex flex-col justify-center">
            <h2 class="text-2xl font-bold mb-2">Selamat Datang, Admin!</h2>
            <p class="text-gray-300 mb-6">Aplikasi Kasir ini siap membantu mencatat penjualan Anda. Jangan lupa cek stok secara berkala.</p>
            
            <div class="flex gap-4">
                <a href="{{ route('history') }}" class="flex-1 bg-gray-700 hover:bg-gray-600 py-3 rounded text-center text-sm font-bold border border-gray-600">
                    Laporan Transaksi
                </a>
                <a href="{{ route('product') }}" class="flex-1 bg-gray-700 hover:bg-gray-600 py-3 rounded text-center text-sm font-bold border border-gray-600">
                    Atur Produk
                </a>
            </div>
        </div>
    </div>
</div>