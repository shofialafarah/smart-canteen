<x-app-layout>
    <div class="min-h-screen bg-[#121212] text-white py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-10 flex flex-col md:flex-row md:justify-between md:items-end gap-6 border-b border-orange-500/20 pb-8">
                <div>
                    <a href="{{ route('pembeli.dashboard') }}"
                        class="text-orange-500 hover:text-orange-400 text-sm font-bold flex items-center mb-4 transition">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Kembali ke Daftar Warung
                    </a>
                    <h2 class="font-display text-4xl font-black text-white uppercase tracking-tighter italic">
                        Menu <span class="text-orange-500">{{ $shop->nama_warung }}</span>
                    </h2>
                </div>

                <div class="w-full md:max-w-md">
                    <div class="relative">
                        <input type="text" id="searchInput"
                            class="w-full bg-[#1e1e1e] border border-orange-500/30 rounded-2xl px-6 py-4 text-white focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition shadow-lg"
                            placeholder="Cari menu favoritmu...">
                        <div class="absolute right-5 top-4 text-orange-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div id="menuGrid" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @forelse($menus as $menu)
                    <div class="menu-card bg-[#1e1e1e] group overflow-hidden rounded-3xl border border-white/5 hover:border-orange-500/50 transition-all duration-300 shadow-xl flex flex-col">
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ asset('storage/' . $menu->foto_menu) }}"
                                class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500"
                                alt="{{ $menu->nama_menu }}">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#1e1e1e] to-transparent opacity-60"></div>
                        </div>

                        <div class="p-5 flex-1 flex flex-col">
                            <div class="flex justify-between items-start mb-1">
                                <h3 class="menu-name font-body text-lg font-bold text-white group-hover:text-orange-500 transition">
                                    {{ $menu->nama_menu }}
                                </h3>
                                <span class="text-[10px] bg-orange-500/10 text-orange-500 border border-orange-500/20 px-2 py-1 rounded-full uppercase font-bold">
                                    {{ $menu->stok }} Stok
                                </span>
                            </div>

                            <p class="font-body text-xl font-black text-white mt-2">
                                <span class="text-orange-500 text-sm">Rp</span>
                                {{ number_format($menu->harga, 0, ',', '.') }}
                            </p>

                            <div class="mt-6">
                                @php
                                    $now = \Carbon\Carbon::now('Asia/Makassar');
                                    $currentTime = $now->format('H:i');
                                    $isOpen = $currentTime >= $shop->jam_buka && $currentTime <= $shop->jam_tutup;
                                @endphp

                                @if($isOpen)
                                    <form action="{{ route('cart.add', $menu->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" 
                                            class="w-full bg-orange-500 hover:bg-orange-600 text-white py-3 rounded-xl font-black uppercase italic text-xs transition-all transform active:scale-95 shadow-lg shadow-orange-500/20">
                                            <i class="fa-solid fa-cart-plus mr-2"></i> Tambah Ke Keranjang
                                        </button>
                                    </form>
                                @else
                                    <button type="button" onclick="alertTutup()" 
                                        class="w-full bg-gray-800 text-gray-500 py-3 rounded-xl font-black uppercase italic text-xs cursor-not-allowed border border-white/5">
                                        <i class="fa-solid fa-moon mr-2"></i> Warung Tutup
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-20 text-gray-500 font-medium border-2 border-dashed border-white/5 rounded-3xl">
                        Warung ini belum memiliki menu.
                    </div>
                @endforelse
            </div>

            <div id="noResults" class="hidden col-span-full text-center py-20">
                <p class="text-gray-500 font-medium italic">Yah, menu yang kamu cari tidak ada...</p>
            </div>
        </div>
    </div>

    {{-- Script Search --}}
    <script>
        document.getElementById('searchInput').addEventListener('input', function() {
            let filter = this.value.toLowerCase();
            let cards = document.querySelectorAll('.menu-card');
            let found = false;

            cards.forEach(card => {
                let name = card.querySelector('.menu-name').textContent.toLowerCase();
                if (name.includes(filter)) {
                    card.style.display = "";
                    found = true;
                } else {
                    card.style.display = "none";
                }
            });

            let noResults = document.getElementById('noResults');
            if (found) {
                noResults.classList.add('hidden');
            } else {
                noResults.classList.remove('hidden');
            }
        });

        function alertTutup() {
            Swal.fire({
                icon: 'info',
                title: 'Warung Sedang Tutup',
                text: 'Maaf, warung ini sudah tutup. Silakan pesan kembali saat jam operasional ya!',
                background: '#1e1e1e',
                color: '#fff',
                confirmButtonColor: '#f97316'
            });
        }
    </script>
</x-app-layout>