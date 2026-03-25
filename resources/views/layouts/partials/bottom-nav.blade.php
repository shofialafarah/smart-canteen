<div class="fixed bottom-4 left-1/2 -translate-x-1/2 w-[90%] max-w-md z-50">
    <div
        class="bg-[#1e1e1e]/80 backdrop-blur-xl border border-white/10 rounded-3xl p-3 shadow-2xl flex justify-around items-center">

        @if (auth()->user()->role === 'pembeli')
            <a href="{{ route('pembeli.dashboard') }}" class="flex flex-col items-center group">
                <div
                    class="p-2 rounded-2xl {{ request()->routeIs('pembeli.dashboard') ? 'bg-orange-500 text-white' : 'text-gray-500 group-hover:text-orange-400' }} transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                </div>
                <span
                    class="text-[10px] mt-1 font-bold uppercase {{ request()->routeIs('pembeli.dashboard') ? 'text-orange-500' : 'text-gray-500' }}">Kantin</span>
            </a>

            <a href="{{ route('pembeli.history') }}" class="flex flex-col items-center group">
                <div
                    class="p-2 rounded-2xl {{ request()->routeIs('pembeli.history') ? 'bg-orange-500 text-white' : 'text-gray-500 group-hover:text-orange-400' }} transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <span
                    class="text-[10px] mt-1 font-bold uppercase {{ request()->routeIs('pembeli.history') ? 'text-orange-500' : 'text-gray-500' }}">Riwayat</span>
            </a>
        @endif

        @if (auth()->user()->role === 'penjual')
            <a href="{{ route('dashboard') }}" class="flex flex-col items-center group">
                <div
                    class="p-2 rounded-2xl {{ request()->routeIs('dashboard') ? 'bg-orange-500 text-white' : 'text-gray-500 group-hover:text-orange-400' }} transition-all">
                    <i class="fa-solid fa-store text-xl w-6 h-6 flex items-center justify-center"></i>
                </div>
                <span
                    class="text-[10px] mt-1 font-bold uppercase {{ request()->routeIs('dashboard') ? 'text-orange-500' : 'text-gray-500' }}">Warung</span>
            </a>

            <a href="{{ route('seller.orders.index') }}" class="flex flex-col items-center group">
                <div
                    class="p-2 rounded-2xl {{ request()->routeIs('seller.orders.index') ? 'bg-orange-500 text-white' : 'text-gray-500 group-hover:text-orange-400' }} transition-all">
                    <i class="fa-solid fa-clipboard-list text-xl w-6 h-6 flex items-center justify-center"></i>
                </div>
                <span
                    class="text-[10px] mt-1 font-bold uppercase {{ request()->routeIs('seller.orders.index') ? 'text-orange-500' : 'text-gray-500' }}">Pesanan</span>
            </a>
        @endif

        @if (auth()->user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center group">
                <div
                    class="p-2 rounded-2xl {{ request()->routeIs('admin.dashboard') ? 'bg-orange-500 text-white' : 'text-gray-500 group-hover:text-orange-400' }} transition-all">
                    <i class="fa-solid fa-chart-pie text-xl w-6 h-6 flex items-center justify-center"></i>
                </div>
                <span
                    class="text-[10px] mt-1 font-bold uppercase {{ request()->routeIs('admin.dashboard') ? 'text-orange-500' : 'text-gray-500' }}">Panel</span>
            </a>

            <a href="{{ route('admin.users') }}" class="flex flex-col items-center group">
                <div
                    class="p-2 rounded-2xl {{ request()->routeIs('admin.users') ? 'bg-orange-500 text-white' : 'text-gray-500 group-hover:text-orange-400' }} transition-all">
                    <i class="fa-solid fa-user-gear text-xl w-6 h-6 flex items-center justify-center"></i>
                </div>
                <span
                    class="text-[10px] mt-1 font-bold uppercase {{ request()->routeIs('admin.users') ? 'text-orange-500' : 'text-gray-500' }}">User</span>
            </a>
        @endif

        <a href="{{ route('profile.edit') }}" class="flex flex-col items-center group">
            <div
                class="p-2 rounded-2xl {{ request()->routeIs('profile.edit') ? 'bg-orange-500 text-white' : 'text-gray-500 group-hover:text-orange-400' }} transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <span
                class="text-[10px] mt-1 font-bold uppercase {{ request()->routeIs('profile.edit') ? 'text-orange-500' : 'text-gray-500' }}">Profil</span>
        </a>

        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="flex flex-col items-center group">
            @csrf
            <button type="button" onclick="confirmLogout()"
                class="p-2 rounded-2xl text-gray-500 hover:text-red-500 transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                    </path>
                </svg>
            </button>
            <span class="text-[10px] mt-1 font-bold uppercase text-gray-500">Keluar</span>
        </form>
    </div>

    <div class="text-center mt-3">
        <p class="text-[9px] text-white/20 uppercase tracking-[0.2em] font-medium">
            Developed by <span class="text-orange-500/50"> <a
                    href="https://portfolio-laravel-shofialafarah.vercel.app/">Shofia Nabila Elfa Rahma</a></span>
            &copy; 2026
        </p>
    </div>
</div>
