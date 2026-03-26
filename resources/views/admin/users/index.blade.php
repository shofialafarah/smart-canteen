<x-app-layout>
    {{-- SweetAlert2 --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="min-h-screen bg-[#121212] text-white py-12 px-6 pb-32">
        <div class="max-w-6xl mx-auto">

            {{-- Header --}}
            <div
                class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4 border-b border-orange-500/30 pb-6">
                <div>
                    <h2 class="text-3xl font-black text-orange-500 uppercase italic">Kelola <span
                            class="text-white">User</span></h2>
                    <p class="text-gray-500 text-xs">Daftar Siswa, Guru, dan Penjual di Smart Canteen.</p>
                </div>
                <form action="{{ route('admin.users') }}" method="GET" class="relative w-full md:w-64">
                    <input type="text" name="search" placeholder="Cari nama/email..."
                        value="{{ request('search') }}"
                        class="w-full bg-[#1e1e1e] border border-white/10 rounded-2xl text-sm px-4 py-2 focus:border-orange-500 text-white outline-none">
                    <button type="submit"
                        class="absolute right-0 top-0 h-full px-3 flex items-center justify-center text-gray-500 hover:text-orange-500 transition-colors">
                        <i class="fa-solid fa-magnifying-glass text-[10px]"></i>
                    </button>
                </form>
            </div>

            {{-- Table --}}
            <div class="bg-[#1e1e1e] rounded-3xl border border-white/5 overflow-hidden shadow-2xl">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead
                            class="bg-orange-600/10 text-orange-500 uppercase text-[10px] font-black italic tracking-widest">
                            <tr>
                                <th class="px-8 py-5 w-[45%]">Informasi User</th>
                                <th class="px-8 py-5 w-[15%]">Role</th>
                                <th class="px-8 py-5 w-[25%]">Saldo</th>
                                <th class="px-8 py-5 w-[15%] text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5 text-sm uppercase italic font-bold">
                            @forelse($users as $user)
                                <tr class="hover:bg-white/[0.02] transition-all group">

                                    {{-- Info User --}}
                                    <td class="px-8 py-5">
                                        <div class="flex items-center gap-4">
                                            <div class="relative shrink-0">
                                                @if ($user->foto_profil)
                                                    <img src="{{ asset('storage/' . $user->foto_profil) }}"
                                                        class="w-12 h-12 rounded-2xl object-cover border border-white/10">
                                                @else
                                                    <div
                                                        class="w-12 h-12 rounded-2xl bg-gradient-to-br from-[#2a2a2a] to-[#1a1a1a] border border-white/10 flex items-center justify-center text-orange-500 shadow-inner">
                                                        <i class="fa-solid fa-user text-lg"></i>
                                                    </div>
                                                @endif
                                                <span
                                                    class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-500 border-2 border-[#1e1e1e] rounded-full block"></span>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-white tracking-wide truncate">{{ $user->name }}</p>
                                                <p
                                                    class="text-[10px] text-gray-500 lowercase font-medium not-italic truncate">
                                                    {{ $user->email }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Role --}}
                                    <td class="px-8 py-5">
                                        <span
                                            class="inline-block px-3 py-1 rounded-lg text-[10px] tracking-tighter whitespace-nowrap
                                            {{ $user->role == 'penjual'
                                                ? 'bg-blue-500/10 text-blue-400 border border-blue-500/20'
                                                : 'bg-orange-500/10 text-orange-500 border border-orange-500/20' }}">
                                            {{ $user->role }}
                                        </span>
                                    </td>

                                    {{-- Saldo --}}
                                    <td class="px-8 py-5">
                                        @if ($user->role === 'pembeli')
                                            <span class="text-white tracking-widest text-xs font-black">
                                                Rp {{ number_format($user->balance, 0, ',', '.') }}
                                            </span>
                                        @else
                                            <span class="text-gray-600 text-lg font-light">—</span>
                                        @endif
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="px-8 py-5 text-center">
                                        <div class="flex justify-center gap-3">
                                            {{-- Edit Button --}}
                                            <button
                                                onclick="openEditModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}', '{{ $user->role }}', {{ $user->balance ?? 0 }})"
                                                class="w-9 h-9 flex items-center justify-center bg-white/5 hover:bg-orange-500 text-gray-400 hover:text-white rounded-xl transition-all duration-300 shadow-lg cursor-pointer">
                                                <i class="fa-solid fa-pen-to-square text-xs"></i>
                                            </button>

                                            {{-- Delete Button --}}
                                            <button
                                                onclick="confirmDelete({{ $user->id }}, '{{ addslashes($user->name) }}')"
                                                class="w-9 h-9 flex items-center justify-center bg-white/5 hover:bg-red-600 text-gray-400 hover:text-white rounded-xl transition-all duration-300 shadow-lg cursor-pointer">
                                                <i class="fa-solid fa-trash text-xs"></i>
                                            </button>

                                            {{-- Hidden Delete Form --}}
                                            <form id="delete-form-{{ $user->id }}"
                                                action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                                class="hidden">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-16 text-center text-gray-600 italic text-sm">
                                        Tidak ada user ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t border-white/5 bg-black/20">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- ===================== MODAL EDIT ===================== --}}
    <div id="editModal" class="fixed inset-0 z-50 hidden items-center justify-center">
        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" onclick="closeEditModal()"></div>

        {{-- Modal Box --}}
        <div class="relative bg-[#1e1e1e] border border-white/10 rounded-3xl shadow-2xl w-full max-w-md mx-4 p-8 z-10">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-black text-orange-500 uppercase italic">Edit <span
                            class="text-white">User</span></h3>
                    <p class="text-gray-500 text-xs mt-0.5">Ubah data user di bawah ini.</p>
                </div>
                <button onclick="closeEditModal()"
                    class="w-8 h-8 flex items-center justify-center rounded-xl bg-white/5 hover:bg-white/10 text-gray-400 hover:text-white transition-all">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>

            <form id="editForm" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    {{-- Nama --}}
                    <div>
                        <label
                            class="block text-[10px] uppercase font-black italic text-orange-500 tracking-widest mb-1.5">Nama</label>
                        <input type="text" name="name" id="edit_name"
                            class="w-full bg-[#2a2a2a] border border-white/10 rounded-xl text-sm px-4 py-2.5 text-white outline-none focus:border-orange-500 transition-colors">
                    </div>

                    {{-- Email --}}
                    <div>
                        <label
                            class="block text-[10px] uppercase font-black italic text-orange-500 tracking-widest mb-1.5">Email</label>
                        <input type="email" name="email" id="edit_email"
                            class="w-full bg-[#2a2a2a] border border-white/10 rounded-xl text-sm px-4 py-2.5 text-white outline-none focus:border-orange-500 transition-colors">
                    </div>

                    {{-- Role --}}
                    <div>
                        <label
                            class="block text-[10px] uppercase font-black italic text-orange-500 tracking-widest mb-1.5">Role</label>
                        <select name="role" id="edit_role"
                            class="w-full bg-[#2a2a2a] border border-white/10 rounded-xl text-sm px-4 py-2.5 text-white outline-none focus:border-orange-500 transition-colors appearance-none cursor-pointer">
                            <option value="pembeli">Pembeli</option>
                            <option value="penjual">Penjual</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                    {{-- Saldo (hanya tampil jika pembeli) --}}
                    <div id="balanceField">
                        <label
                            class="block text-[10px] uppercase font-black italic text-orange-500 tracking-widest mb-1.5">Saldo</label>
                        <div class="relative">
                            <span class="absolute left-4 top-2.5 text-gray-400 text-sm italic font-bold">Rp</span>
                            <input type="number" name="balance" id="edit_balance"
                                class="w-full bg-[#2a2a2a] border border-white/10 rounded-xl text-sm pl-10 pr-4 py-2.5 text-white outline-none focus:border-orange-500 transition-colors">
                        </div>
                    </div>
                </div>

                {{-- Footer Buttons --}}
                <div class="flex gap-3 mt-7">
                    <button type="button" onclick="closeEditModal()"
                        class="flex-1 py-2.5 rounded-xl bg-white/5 hover:bg-white/10 text-gray-400 hover:text-white text-xs font-black uppercase italic transition-all">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 py-2.5 rounded-xl bg-orange-500 hover:bg-orange-600 text-white text-xs font-black uppercase italic transition-all shadow-lg shadow-orange-500/20">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ===================== SCRIPTS ===================== --}}
    <script>
        // ---- Delete with SweetAlert2 ----
        function confirmDelete(userId, userName) {
            Swal.fire({
                title: 'Hapus User?',
                html: `Yakin mau hapus <b>${userName}</b>?<br><span style="font-size:12px;color:#9ca3af;">Aksi ini tidak bisa dibatalkan.</span>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                background: '#1e1e1e',
                color: '#ffffff',
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#374151',
                customClass: {
                    popup: 'rounded-3xl border border-white/10',
                    title: 'text-white font-black uppercase italic text-lg',
                    confirmButton: 'rounded-xl font-black uppercase italic text-xs px-5 py-2.5',
                    cancelButton: 'rounded-xl font-black uppercase italic text-xs px-5 py-2.5',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + userId).submit();
                }
            });
        }

        // ---- Edit Modal ----
        // ---- Edit Modal ----
        function openEditModal(id, name, email, role, balance) {
            // 1. Isi data ke form
            document.getElementById('editForm').action = `/admin/users/${id}`;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_role').value = role;
            document.getElementById('edit_balance').value = balance;

            toggleBalanceField(role);

            // 2. Tampilkan Modal
            const modal = document.getElementById('editModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            // 3. SEMBUNYIKAN BOTTOM NAV
            const bottomNav = document.getElementById('bottom-nav');
            if (bottomNav) {
                bottomNav.classList.add('hidden');
            }
        }

        function closeEditModal() {
            const modal = document.getElementById('editModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');

            // TAMPILKAN KEMBALI BOTTOM NAV
            const bottomNav = document.getElementById('bottom-nav');
            if (bottomNav) {
                bottomNav.classList.remove('hidden');
            }
        }

        function toggleBalanceField(role) {
            const field = document.getElementById('balanceField');
            field.style.display = role === 'pembeli' ? 'block' : 'none';
        }

        document.getElementById('edit_role').addEventListener('change', function() {
            toggleBalanceField(this.value);
        });

        // Close modal on ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeEditModal();
        });
    </script>
</x-app-layout>
