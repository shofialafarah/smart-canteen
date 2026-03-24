<x-app-layout>
    <div class="min-h-screen bg-[#121212] text-white py-12 pb-24">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-10 border-b border-orange-500/30 pb-6">
                <h2 class="font-display text-3xl font-black text-orange-500 tracking-tight uppercase italic">
                    Daftar <span class="text-white italic">Pesanan Masuk</span>
                </h2>
                <p class="font-body text-gray-400 text-sm mt-1">Pantau pesanan siswa yang masuk ke warungmu.</p>
            </div>

            <div class="space-y-6">
                @forelse ($orders as $order)
                    <div class="bg-[#1e1e1e] rounded-3xl border border-white/5 p-6 shadow-xl">
                        <div class="flex flex-col md:flex-row justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div
                                    class="h-12 w-12 bg-orange-500/20 rounded-full flex items-center justify-center text-orange-500 font-black">
                                    {{ substr($order->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <h3 class="font-display font-bold text-lg uppercase">{{ $order->user->name }}</h3>
                                    <p class="text-xs text-gray-500 font-body">{{ $order->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                @if ($order->status_pembayaran == 'Selesai')
                                    {{-- Jika sudah selesai, tampilkan label saja --}}
                                    <span
                                        class="bg-green-500/10 text-green-500 text-[10px] font-black px-4 py-2 rounded-xl uppercase italic border border-green-500/20">
                                        ✓ TERAMBIL
                                    </span>
                                @else
                                    {{-- Jika belum, tampilkan tombol selesaikan --}}
                                    <form action="{{ route('penjual.orders.update', $order->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status_pembayaran" value="Selesai">
                                        <button type="submit"
                                            class="bg-orange-600 hover:bg-orange-500 text-white text-[10px] font-black px-4 py-2 rounded-xl transition uppercase italic shadow-[0_4px_10px_rgba(234,88,12,0.2)]">
                                            SELESAIKAN
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>

                        <div class="mt-6 pt-6 border-t border-white/5">
                            <ul class="space-y-3">
                                @foreach ($order->details as $detail)
                                    <li class="flex justify-between items-center font-body text-sm">
                                        <span class="text-gray-300">
                                            {{ $detail->menu->nama_menu }}
                                            <b class="text-orange-500 ml-2 text-xs">x{{ $detail->quantity }}</b>
                                        </span>
                                        <span class="font-bold">Rp
                                            {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="mt-4 text-right">
                                <p class="text-xs text-gray-500">Total Pembayaran:</p>
                                <p class="text-xl font-black text-orange-500 italic">
                                    Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                </p>
                                <p class="text-[10px] text-gray-600 uppercase tracking-widest mt-1">
                                    KODE: {{ $order->kode_ambil }}
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-20 bg-[#1e1e1e] rounded-3xl border border-dashed border-white/10">
                        <p class="font-body text-gray-500 italic">Belum ada pesanan nih, sabar ya!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
