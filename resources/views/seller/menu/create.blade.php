<x-app-layout>
    <div class="min-h-screen bg-[#121212] text-white py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-8">
                <a href="{{ route('dashboard') }}" class="text-orange-500 hover:text-orange-400 text-sm font-bold flex items-center mb-4 transition font-body">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Kembali ke Dashboard
                </a>
                <h2 class="font-display text-4xl font-black text-white uppercase italic tracking-tighter">
                    Tambah <span class="text-orange-500">Menu Baru</span>
                </h2>
                <p class="font-body text-gray-400 mt-2">Isi detail jajanan yang ingin kamu tawarkan hari ini.</p>
            </div>

            <div class="bg-[#1e1e1e] overflow-hidden shadow-2xl rounded-3xl border border-white/5 p-8">
                <form action="{{ route('menu.store') }}" method="post" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div>
                        <label class="font-display text-orange-500 text-xs uppercase tracking-widest mb-2 block font-bold">Nama Makanan/Minuman</label>
                        <input type="text" name="nama_menu" placeholder="Contoh: Pop Ice Coklat Melt" 
                            class="w-full bg-[#121212] border-white/10 rounded-2xl px-6 py-4 text-white font-body focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition shadow-inner" required />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="font-display text-orange-500 text-xs uppercase tracking-widest mb-2 block font-bold">Harga (Rp)</label>
                            <div class="relative">
                                <span class="absolute left-5 top-4 text-gray-500 font-body">Rp</span>
                                <input type="number" name="harga" placeholder="5000"
                                    class="w-full bg-[#121212] border-white/10 rounded-2xl pl-12 pr-6 py-4 text-white font-body focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition shadow-inner" required />
                            </div>
                        </div>

                        <div>
                            <label class="font-display text-orange-500 text-xs uppercase tracking-widest mb-2 block font-bold">Stok Awal</label>
                            <input type="number" name="stok" placeholder="20"
                                class="w-full bg-[#121212] border-white/10 rounded-2xl px-6 py-4 text-white font-body focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition shadow-inner" required />
                        </div>
                    </div>

                    <div>
                        <label class="font-display text-orange-500 text-xs uppercase tracking-widest mb-2 block font-bold">Foto Produk</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-white/10 border-dashed rounded-2xl hover:border-orange-500/50 transition-colors group">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-500 group-hover:text-orange-500 transition" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-400 font-body">
                                    <label for="foto_menu" class="relative cursor-pointer bg-transparent rounded-md font-bold text-orange-500 hover:text-orange-400 focus-within:outline-none">
                                        <span>Upload file foto</span>
                                        <input id="foto_menu" name="foto_menu" type="file" class="sr-only" required>
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500 font-body">PNG, JPG up to 2MB</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" 
                            class="w-full bg-orange-600 hover:bg-orange-500 text-white font-display font-black py-5 rounded-2xl transition-all uppercase tracking-widest shadow-[0_8px_30px_rgb(234,88,12,0.4)] active:scale-[0.98] text-lg italic">
                            🚀 Simpan & Publish Menu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>