<x-app-layout>
    <div class="min-h-screen bg-[#121212] text-white py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div
                class="flex flex-col md:flex-row justify-between items-center mb-10 border-b border-orange-500/30 pb-6 gap-4">
                <div>
                    <h2 class="font-display text-3xl font-black text-orange-500 tracking-tight uppercase italic">
                        Dashboard <span class="text-white italic">Penjual</span>
                    </h2>
                    <p class="font-body text-gray-400 text-sm mt-1">
                        Warung: <span class="text-orange-400 font-bold">{{ auth()->user()->shop->nama_warung }}</span>
                    </p>
                </div>

                <a href="{{ route('menu.create') }}"
                    class="font-display bg-orange-600 hover:bg-orange-500 text-white font-bold py-3 px-6 rounded-2xl transition-all shadow-[0_4px_15px_rgba(234,88,12,0.3)] active:scale-95 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    TAMBAH MENU
                </a>
            </div>

            <div class="bg-[#1e1e1e] overflow-hidden shadow-2xl rounded-3xl border border-white/5">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-orange-500/10 border-b border-white/5">
                                <th
                                    class="px-6 py-4 text-left font-display text-orange-500 uppercase tracking-wider text-sm">
                                    Foto</th>
                                <th
                                    class="px-6 py-4 text-left font-display text-orange-500 uppercase tracking-wider text-sm">
                                    Nama Menu</th>
                                <th
                                    class="px-6 py-4 text-left font-display text-orange-500 uppercase tracking-wider text-sm">
                                    Harga</th>
                                <th
                                    class="px-6 py-4 text-left font-display text-orange-500 uppercase tracking-wider text-sm">
                                    Stok</th>
                                <th
                                    class="px-6 py-4 text-center font-display text-orange-500 uppercase tracking-wider text-sm">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5 font-body">
                            @foreach ($menus as $menu)
                                <tr class="hover:bg-white/[0.02] transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div
                                            class="relative h-12 w-12 rounded-xl overflow-hidden border border-orange-500/20 shadow-md">
                                            <img src="{{ asset('storage/' . $menu->foto_menu) }}"
                                                class="h-full w-full object-cover">
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 font-bold text-gray-200 uppercase tracking-tight">
                                        {{ $menu->nama_menu }}
                                    </td>
                                    <td class="px-6 py-4 text-orange-400 font-black">
                                        <span class="text-xs">Rp</span> {{ number_format($menu->harga, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span
                                            class="px-3 py-1 bg-[#121212] border border-orange-500/30 rounded-lg text-white font-bold text-sm">
                                            {{ $menu->stok }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center gap-3">
                                            <a href="{{ route('menu.edit', $menu->id) }}"
                                                class="p-2 bg-yellow-500/10 text-yellow-500 border border-yellow-500/20 rounded-xl hover:bg-yellow-500 hover:text-white transition shadow-sm">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                    </path>
                                                </svg>
                                            </a>

                                            <form action="{{ route('menu.destroy', $menu->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus menu ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 bg-red-500/10 text-red-500 border border-red-500/20 rounded-xl hover:bg-red-500 hover:text-white transition shadow-sm">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($menus->isEmpty())
                    <div class="text-center py-20">
                        <p class="font-body text-gray-500 italic text-lg">Kamu belum punya menu. Ayo mulai jualan!</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Konfirmasi Hapus (Gunakan class .btn-hapus di tombol)
    document.addEventListener('click', function (e) {
        if (e.target.closest('.btn-hapus')) {
            e.preventDefault();
            const form = e.target.closest('form');
            Swal.fire({
                title: 'Hapus Menu?',
                text: "Menu yang dihapus gak bisa dikembalikan lho!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ea580c',
                cancelButtonColor: '#3f3f46',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                background: '#1e1e1e',
                color: '#fff',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    });
    </script>
</x-app-layout>
