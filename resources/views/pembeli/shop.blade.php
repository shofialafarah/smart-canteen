<x-app-layout>
    <div class="min-h-screen bg-[#121212] text-white py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-between items-center mb-10 border-b border-orange-500/30 pb-6">
                <div>
                    <h2 class="text-3xl font-extrabold text-orange-500 tracking-tight">
                        Smart <span class="text-white">Canteen</span>
                    </h2>
                    <p class="text-gray-400 text-sm">Selamat datang, {{ auth()->user()->name }}!</p>
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

            @if (session('success'))
                <div class="mb-6 p-4 bg-orange-500/20 border border-orange-500 text-orange-500 rounded-2xl">
                    {{ session('success') }}
                </div>
            @endif
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @forelse($menus as $menu)
                    <div
                        class="bg-[#1e1e1e] group overflow-hidden rounded-3xl border border-white/5 hover:border-orange-500/50 transition-all duration-300 shadow-xl">
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ asset('storage/' . $menu->foto_menu) }}"
                                class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500"
                                alt="{{ $menu->nama_menu }}">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#1e1e1e] to-transparent opacity-60">
                            </div>
                        </div>

                        <div class="p-5">
                            <div class="flex justify-between items-start mb-1">
                                <h3 class="text-lg font-bold text-white group-hover:text-orange-500 transition">
                                    {{ $menu->nama_menu }}</h3>
                                <span
                                    class="text-[10px] bg-orange-500/10 text-orange-500 border border-orange-500/20 px-2 py-1 rounded-full uppercase font-bold">
                                    {{ $menu->stok }} Stok
                                </span>
                            </div>
                            <p class="text-xs text-gray-500 mb-4 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-7h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                                {{ $menu->shop->nama_warung }}
                            </p>

                            <div class="flex items-center justify-between mt-2">
                                <span class="text-xl font-black text-white">
                                    <span class="text-orange-500 text-sm">Rp</span>
                                    {{ number_format($menu->harga, 0, ',', '.') }}
                                </span>

                                <a href="{{ route('cart.add', $menu->id) }}"
                                    class="bg-orange-600 hover:bg-orange-500 text-white p-2.5 rounded-xl transition-all shadow-[0_4px_15px_rgba(234,88,12,0.3)] active:scale-95">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-20">
                        <div class="bg-[#1e1e1e] inline-block p-6 rounded-full mb-4">
                            <svg class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                        <p class="text-gray-500 font-medium">Belum ada menu yang tersedia hari ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Waduh...',
                text: "{{ session('error') }}",
                background: '#1e1e1e',
                color: '#fff',
                confirmButtonColor: '#ea580c'
            });
        </script>
    @endif
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                background: '#1e1e1e',
                color: '#fff',
                confirmButtonColor: '#ea580c'
            });
        </script>
    @endif
</x-app-layout>
