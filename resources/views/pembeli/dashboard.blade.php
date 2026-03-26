<x-app-layout>
    <div class="min-h-screen bg-[#121212] text-white py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-between items-center mb-10 border-b border-orange-500/30 pb-6">
                <div>
                    <h2 class="font-display text-3xl font-extrabold text-orange-500 tracking-tight">
                        Smart <span class="text-white">Canteen</span>
                    </h2>
                    <p class="font-body text-gray-400 text-sm">Selamat datang, {{ auth()->user()->name }}!</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('cart.index') }}"
                        class="bg-[#1e1e1e] border border-orange-500/50 px-6 py-3 rounded-2xl flex items-center hover:bg-orange-600 group transition">
                        <svg class="w-6 h-6 text-orange-500 group-hover:text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        <span class="ml-2 text-white font-bold">{{ count(session('cart', [])) }}</span>
                    </a>

                    <div
                        class="bg-[#1e1e1e] border border-orange-500/50 px-6 py-3 rounded-2xl shadow-[0_0_15px_rgba(249,115,22,0.1)]">
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Saldo Anda</p>
                        <p class="text-xl font-black text-orange-500">Rp
                            {{ number_format(auth()->user()->balance, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <h3 class="font-body text-xl font-bold mb-6 italic uppercase tracking-widest text-white/50">
                Pilih Warung Terlebih Dahulu:
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($shops as $shop)
                    <a href="{{ route('pembeli.shop.detail', $shop->id) }}"
                        class="bg-[#1e1e1e] group overflow-hidden rounded-3xl border border-white/5 hover:border-orange-500/50 transition-all duration-300 shadow-xl flex flex-col">

                        <div class="h-48 w-full overflow-hidden relative">
                            @if ($shop->foto_warung)
                                <img src="{{ asset('storage/' . $shop->foto_warung) }}" alt="{{ $shop->nama_warung }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div
                                    class="w-full h-full bg-gradient-to-br from-orange-500/20 to-black flex items-center justify-center">
                                    <i class="fa-solid fa-store text-4xl text-orange-500/40"></i>
                                </div>
                            @endif

                            {{-- Label Status Buka/Tutup --}}
                            <div class="absolute top-4 right-4 z-10">
                                @php
                                    // Ambil waktu sekarang WITA
                                    $now = \Carbon\Carbon::now('Asia/Makassar');
                                    $currentTime = $now->format('H:i');

                                    // PASTIKAN menggunakan $shop sesuai dengan @forelse
                                    $isOpen = $currentTime >= $shop->jam_buka && $currentTime <= $shop->jam_tutup;
                                @endphp

                                @if ($isOpen)
                                    <span
                                        class="bg-green-500/20 text-green-400 backdrop-blur-md border border-green-500/30 text-[10px] px-3 py-1 rounded-full font-bold uppercase tracking-wider shadow-lg">
                                        ● Buka
                                    </span>
                                @else
                                    <span
                                        class="bg-red-500/20 text-red-500 backdrop-blur-md border border-red-500/30 text-[10px] px-3 py-1 rounded-full font-bold uppercase tracking-wider shadow-lg">
                                        🌙 Tutup
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="p-6 flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div
                                    class="bg-orange-500/10 p-3 rounded-xl group-hover:bg-orange-500 transition-all duration-300">
                                    <svg class="w-6 h-6 text-orange-500 group-hover:text-white" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-7h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                        </path>
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <h3
                                        class="font-display text-xl font-bold text-white group-hover:text-orange-500 transition capitalize">
                                        {{ $shop->nama_warung }}
                                    </h3>
                                    <p class="text-[11px] text-gray-500 mt-0.5 italic">Ketuk untuk jajan di sini</p>
                                </div>
                            </div>

                            <div
                                class="translate-x-4 opacity-0 group-hover:opacity-100 group-hover:translate-x-0 transition-all">
                                <i class="fa-solid fa-arrow-right text-orange-500"></i>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full py-20 text-center border-2 border-dashed border-white/5 rounded-3xl">
                        <i class="fa-solid fa-utensils text-5xl text-white/5 mb-4"></i>
                        <p class="text-gray-500 italic">Belum ada warung yang tersedia di kantin.</p>
                    </div>
                @endforelse
            </div>

            <div class="h-32"></div>
        </div>
    </div>
</x-app-layout>
