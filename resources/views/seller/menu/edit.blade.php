<x-app-layout>
    <div class="min-h-screen bg-[#121212] text-white py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                <a href="{{ route('seller.dashboard') }}"
                    class="text-orange-500 hover:text-orange-400 text-sm font-bold flex items-center mb-4 transition font-body">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Batal & Kembali
                </a>
                <h2 class="font-display text-4xl font-black text-white uppercase italic tracking-tighter">
                    Edit <span class="text-orange-500">Jajanan</span>
                </h2>
            </div>

            <div class="bg-[#1e1e1e] shadow-2xl rounded-3xl border border-white/5 p-8">
                <form action="{{ route('menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf
                    @method('PUT') <div>
                        <label
                            class="font-display text-orange-500 text-xs uppercase tracking-widest mb-2 block font-bold">Nama
                            Makanan/Minuman</label>
                        <input type="text" name="nama_menu" value="{{ $menu->nama_menu }}"
                            class="w-full bg-[#121212] border-white/10 rounded-2xl px-6 py-4 text-white font-body focus:border-orange-500 transition"
                            required />
                    </div>

                    <div class="mb-6">
                        <label
                            class="font-display text-orange-500 text-xs uppercase tracking-widest mb-2 block font-bold">Kategori
                            Jajanan</label>
                        <select name="category_id"
                            class="w-full bg-[#121212] border-white/10 rounded-2xl px-6 py-4 text-white font-body focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition shadow-inner"
                            required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $menu->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label
                                class="font-display text-orange-500 text-xs uppercase tracking-widest mb-2 block font-bold">Harga
                                (Rp)</label>
                            <input type="number" name="harga" value="{{ $menu->harga }}"
                                class="w-full bg-[#121212] border-white/10 rounded-2xl px-6 py-4 text-white font-body focus:border-orange-500 transition"
                                required />
                        </div>

                        <div>
                            <label
                                class="font-display text-orange-500 text-xs uppercase tracking-widest mb-2 block font-bold">Stok
                                Tersedia</label>
                            <input type="number" name="stok" value="{{ $menu->stok }}"
                                class="w-full bg-[#121212] border-white/10 rounded-2xl px-6 py-4 text-white font-body focus:border-orange-500 transition"
                                required />
                        </div>
                    </div>

                    <div>
                        <label
                            class="font-display text-orange-500 text-xs uppercase tracking-widest mb-2 block font-bold">Foto
                            Produk (Kosongkan jika tidak diganti)</label>
                        <div class="flex items-center gap-4 mb-4">
                            <img src="{{ asset('storage/' . $menu->foto_menu) }}"
                                class="w-20 h-20 rounded-xl object-cover border border-white/10">
                            <p class="text-xs text-gray-500">Foto saat ini</p>
                        </div>
                        <input type="file" name="foto_menu"
                            class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-600 file:text-white hover:file:bg-orange-500 cursor-pointer" />
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                            class="w-full bg-orange-600 hover:bg-orange-500 text-white font-display font-black py-5 rounded-2xl transition-all uppercase tracking-widest shadow-[0_8px_30px_rgb(234,88,12,0.4)] text-lg italic">
                            💾 Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
