<div class="max-w-6xl mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Riwayat Transaksi</h1>
        <a href="{{ route('pos') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-bold shadow flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            Kembali ke Kasir
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-100 text-gray-600 uppercase text-sm font-bold">
                <tr>
                    <th class="p-4 border-b">No. Invoice</th>
                    <th class="p-4 border-b">Tanggal</th>
                    <th class="p-4 border-b">Kasir</th>
                    <th class="p-4 border-b text-right">Total</th>
                    <th class="p-4 border-b text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($transactions as $trx)
                    <tr class="hover:bg-blue-50 transition">
                        <td class="p-4 font-mono font-bold text-blue-600">{{ $trx->invoice_number }}</td>
                        <td class="p-4 text-gray-500 text-sm">
                            {{ $trx->created_at->format('d M Y') }}
                            <span class="text-xs text-gray-400 block">{{ $trx->created_at->format('H:i') }}</span>
                        </td>
                        <td class="p-4">
                            <span class="bg-gray-200 text-gray-700 px-2 py-1 rounded text-xs font-bold">
                                {{ $trx->user->name ?? 'Sistem' }}
                            </span>
                        </td>
                        <td class="p-4 text-right font-bold text-gray-800">
                            Rp {{ number_format($trx->total_amount, 0, ',', '.') }}
                        </td>
                        <td class="p-4 text-center">
                            <button wire:click="showDetail({{ $trx->id }})" class="text-blue-600 hover:text-blue-800 font-bold text-sm underline cursor-pointer">
                                Lihat Detail
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-gray-400">Belum ada transaksi.</td>
                    </tr>
                @endforelse
                </tbody>
        </table>
        
        <div class="p-4 bg-gray-50 border-t">
            {{ $transactions->links() }}
        </div>
    </div>

    @if($selectedTransaction)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden">
            <div class="bg-blue-600 p-4 text-white flex justify-between items-center">
                <h3 class="font-bold text-lg">Detail Transaksi</h3>
                <button wire:click="closeDetail" class="text-white hover:text-gray-200 text-2xl font-bold">&times;</button>
            </div>
            <div class="p-6 bg-gray-50 max-h-[70vh] overflow-y-auto">
                <div class="text-center mb-4">
                    <h2 class="font-bold text-xl uppercase">Toko Serba Ada</h2>
                    <p class="text-xs text-gray-500">{{ $selectedTransaction->created_at->format('d/m/Y H:i') }}</p>
                    <p class="font-mono text-sm mt-2 font-bold">{{ $selectedTransaction->invoice_number }}</p>
                </div>
                <hr class="border-dashed border-gray-400 my-2">
                <div class="space-y-2 text-sm">
                    @foreach($selectedTransaction->details as $detail)
                    <div class="flex justify-between">
                        <div>
                            <div class="font-bold">{{ $detail->product->name ?? 'Barang Dihapus' }}</div>
                            <div class="text-xs text-gray-500">{{ $detail->quantity }} x {{ number_format($detail->price, 0, ',', '.') }}</div>
                        </div>
                        <div class="font-bold">{{ number_format($detail->quantity * $detail->price, 0, ',', '.') }}</div>
                    </div>
                    @endforeach
                </div>
                <hr class="border-dashed border-gray-400 my-4">
                <div class="flex justify-between font-bold text-lg">
                    <span>TOTAL</span>
                    <span>Rp {{ number_format($selectedTransaction->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>
            <div class="p-4 bg-white border-t flex gap-2">
                <button onclick="window.print()" class="flex-1 bg-gray-800 text-white py-2 rounded font-bold">Cetak</button>
                <button wire:click="closeDetail" class="flex-1 bg-gray-200 text-gray-800 py-2 rounded font-bold">Tutup</button>
            </div>
        </div>
    </div>
    @endif
</div>