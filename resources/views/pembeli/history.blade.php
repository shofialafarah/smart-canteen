<x-app-layout>
    <div class="min-h-screen bg-[#121212] text-white py-12">
        <div class="max-w-4xl mx-auto px-4">
            <h2 class="text-2xl font-bold text-orange-500 mb-8 flex items-center">
                <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
                Riwayat Jajan Kamu
            </h2>

            <div class="space-y-4">
                @forelse ($orders as $order)
                    <div class="bg-[#1e1e1e] rounded-3xl p-6 border border-white/5 shadow-xl">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-widest">Waktu Pesanan</p>
                                <p class="font-bold">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            </div>
                            
                            <div class="bg-orange-600/10 border border-orange-500/20 px-4 py-2 rounded-2xl">
                                <p class="text-[10px] text-orange-500 uppercase text-center font-bold">Kode Ambil</p>
                                <p class="text-2xl font-black text-white tracking-tighter">{{ $order->kode_ambil }}</p>
                            </div>

                            <div class="text-right">
                                <p class="text-xs text-gray-500 italic">Total Bayar</p>
                                <p class="text-xl font-black text-orange-500">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                            </div>
                            
                            <div>
                                <span class="px-4 py-1 rounded-full text-xs font-bold uppercase {{ $order->status_pembayaran == 'success' ? 'bg-green-500/20 text-green-500' : 'bg-yellow-500/20 text-yellow-500' }}">
                                    {{ $order->status_pembayaran }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-20">
                        <p class="text-gray-500">Belum ada riwayat pesanan nih. Yuk jajan dulu!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>