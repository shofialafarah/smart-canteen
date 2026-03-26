<x-app-layout>
    <div class="min-h-screen bg-[#121212] text-white py-12 px-6">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-black text-orange-500 uppercase italic mb-8">Admin <span class="text-white">Panel</span></h2>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
                <div class="bg-[#1e1e1e] p-6 rounded-3xl border border-white/5 shadow-xl">
                    <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest">Total Dana Siswa</p>
                    <h3 class="text-2xl font-black text-white mt-2 italic">Rp {{ number_format($totalSaldo, 0, ',', '.') }}</h3>
                </div>

                <a href="{{ route('admin.topup.index') }}" class="bg-[#1e1e1e] p-6 rounded-3xl border border-orange-500/20 shadow-xl hover:border-orange-500 transition-all">
                    <p class="text-[10px] text-orange-500 uppercase font-black tracking-widest">Top Up Pending</p>
                    <h3 class="text-3xl font-black text-white mt-2 italic">{{ $pendingTopUpCount }}</h3>
                </a>

                <div class="bg-[#1e1e1e] p-6 rounded-3xl border border-white/5 shadow-xl">
                    <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest">Warung Aktif</p>
                    <h3 class="text-3xl font-black text-white mt-2 italic">{{ $totalWarung }}</h3>
                </div>

                <div class="bg-[#1e1e1e] p-6 rounded-3xl border border-white/5 shadow-xl">
                    <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest">Order Hari Ini</p>
                    <h3 class="text-3xl font-black text-white mt-2 italic">{{ $orderHariIni }}</h3>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gradient-to-r from-orange-600 to-orange-800 p-8 rounded-3xl shadow-2xl flex justify-between items-center group cursor-pointer">
                    <div>
                        <h4 class="text-xl font-black uppercase italic">Verifikasi Warung</h4>
                        <p class="text-orange-200 text-sm">Ada warung baru yang mendaftar?</p>
                    </div>
                    <i class="fa-solid fa-store text-4xl text-white/20 group-hover:text-white/50 transition-all"></i>
                </div>
                
                <a href="{{ route('admin.users') }}" class="bg-[#1e1e1e] p-8 rounded-3xl border border-white/5 shadow-2xl flex justify-between items-center group">
                    <div>
                        <h4 class="text-xl font-black uppercase italic text-orange-500">Kelola Pengguna</h4>
                        <p class="text-gray-500 text-sm">Atur data Siswa, Guru, dan Penjual.</p>
                    </div>
                    <i class="fa-solid fa-users text-4xl text-white/10 group-hover:text-orange-500 transition-all"></i>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>