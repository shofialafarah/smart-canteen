<x-app-layout>
    <div class="min-h-screen bg-[#121212] text-white py-12 font-body">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-display text-4xl font-black text-white uppercase italic mb-8 tracking-tighter">
                Kelola <span class="text-orange-500">Profil Warung</span>
            </h2>

            <div class="bg-[#1e1e1e] rounded-3xl border border-white/5 p-8 shadow-2xl">
                <form action="{{ route('seller.shop.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="flex flex-col items-center mb-6">
                        <label class="font-display text-orange-500 text-xs uppercase tracking-widest mb-4 font-bold">Foto Warung Sekarang</label>
                        <div class="relative group">
                            <img src="{{ asset('storage/' . auth()->user()->shop->foto_warung) }}" 
                                 class="w-40 h-40 object-cover rounded-full border-4 border-orange-500/30 shadow-2xl transition group-hover:border-orange-500">
                        </div>
                    </div>

                    <div>
                        <label class="font-display text-orange-500 text-xs uppercase tracking-widest mb-2 block font-bold">Nama Warung</label>
                        <input type="text" name="nama_warung" value="{{ auth()->user()->shop->nama_warung }}"
                            class="w-full bg-[#121212] border-white/10 rounded-2xl px-6 py-4 text-white focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition shadow-inner">
                    </div>

                    <div>
                        <label class="font-display text-orange-500 text-xs uppercase tracking-widest mb-2 block font-bold">Ganti Foto Warung (Opsional)</label>
                        <input type="file" name="foto_warung" 
                            class="block w-full text-sm text-gray-400 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-sm file:font-black file:bg-orange-500/10 file:text-orange-500 hover:file:bg-orange-500/20 transition-all cursor-pointer">
                    </div>

                    <button type="submit" 
                        class="w-full bg-orange-600 hover:bg-orange-500 text-white font-display font-black py-5 rounded-2xl transition-all uppercase tracking-widest shadow-[0_8px_30px_rgb(234,88,12,0.4)] active:scale-[0.98] text-lg italic">
                        Update Profil Warung
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>