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

            <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                <button onclick="openTambahModal()"
                    class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-6 rounded-xl transition-all flex items-center gap-2 text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    TAMBAH USER
                </button>
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
                                                    class="absolute -bottom-1 -right-1 w-3 h-3 border-2 border-[#1e1e1e] rounded-full block 
    {{ ($user->status_akun ?? 'aktif') === 'aktif' ? 'bg-green-500 shadow-[0_0_8px_rgba(34,197,94,0.5)]' : 'bg-red-500 shadow-[0_0_8px_rgba(239,68,68,0.5)]' }}">
                                                </span>
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
                                                onclick="openEditModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}', '{{ $user->role }}', {{ $user->balance ?? 0 }}, '{{ $user->status_akun ?? 'aktif' }}')"
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

    {{-- ===================== MODAL TAMBAH ===================== --}}
    <div id="tambahModal" class="fixed inset-0 z-50 hidden items-center justify-center">
        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" onclick="closeTambahModal()"></div>

        {{-- Modal Box --}}
        <div class="relative bg-[#1e1e1e] border border-white/10 rounded-3xl shadow-2xl w-full max-w-md mx-4 p-8 z-10">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-black text-orange-500 uppercase italic">Tambah <span
                            class="text-white">User</span></h3>
                    <p class="text-gray-500 text-xs mt-0.5">Isi data user baru di bawah ini.</p>
                </div>
                <button onclick="closeTambahModal()"
                    class="w-8 h-8 flex items-center justify-center rounded-xl bg-white/5 hover:bg-white/10 text-gray-400 hover:text-white transition-all">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>

            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <div class="space-y-4">
                    {{-- Pilih Tipe Pembeli --}}
                    <div>
                        <label
                            class="block text-[10px] uppercase font-black italic text-orange-500 tracking-widest mb-1.5">Tipe
                            Pembeli</label>
                        <select id="tipe_pembeli" onchange="toggleIdentitasInput(this.value)"
                            class="w-full bg-[#2a2a2a] border border-white/10 rounded-xl text-sm px-4 py-2.5 text-white outline-none focus:border-orange-500 transition-colors">
                            <option value="siswa">🎓 Siswa (Pakai NISN)</option>
                            <option value="guru">👨‍🏫 Guru (Pakai Email)</option>
                        </select>
                    </div>

                    {{-- Container Identitas (NISN atau Email) --}}
                    <div id="identitas_container">
                        {{-- Input NISN (Default Muncul karena option pertama adalah Siswa) --}}
                        <div id="wrapper_nisn">
                            <label
                                class="block text-[10px] uppercase font-black italic text-orange-500 tracking-widest mb-1.5">NISN</label>
                            <input type="text" name="nisn" id="input_nisn"
                                class="w-full bg-[#2a2a2a] border border-white/10 rounded-xl text-sm px-4 py-2.5 text-white outline-none focus:border-orange-500 transition-colors"
                                placeholder="Masukkan 10 digit NISN...">
                        </div>

                        {{-- Input Email (Default Sembunyi) --}}
                        <div id="wrapper_email" class="hidden">
                            <label
                                class="block text-[10px] uppercase font-black italic text-orange-500 tracking-widest mb-1.5">Email
                                Guru</label>
                            <input type="email" name="email" id="input_email"
                                class="w-full bg-[#2a2a2a] border border-white/10 rounded-xl text-sm px-4 py-2.5 text-white outline-none focus:border-orange-500 transition-colors"
                                placeholder="emailguru@sekolah.sch.id">
                        </div>
                    </div>

                    {{-- Nama --}}
                    <div>
                        <label
                            class="block text-[10px] uppercase font-black italic text-orange-500 tracking-widest mb-1.5">Nama</label>
                        <input type="text" name="name" required
                            class="w-full bg-[#2a2a2a] border border-white/10 rounded-xl text-sm px-4 py-2.5 text-white outline-none focus:border-orange-500 transition-colors"
                            placeholder="Nama lengkap...">
                    </div>

                    {{-- Saldo awal (hanya untuk pembeli) --}}
                    <div id="tambahBalanceField">
                        <label
                            class="block text-[10px] uppercase font-black italic text-orange-500 tracking-widest mb-1.5">Saldo
                            Awal</label>
                        <div class="relative">
                            <span class="absolute left-4 top-2.5 text-gray-400 text-sm italic font-bold">Rp</span>
                            <input type="number" name="balance" value="0" min="0"
                                class="w-full bg-[#2a2a2a] border border-white/10 rounded-xl text-sm pl-10 pr-4 py-2.5 text-white outline-none focus:border-orange-500 transition-colors">
                        </div>
                        <p class="text-gray-600 text-[10px] mt-1 italic">* Password default: <span
                                class="text-orange-500">123123123</span></p>
                    </div>
                </div>

                {{-- Footer Buttons --}}
                <div class="flex gap-3 mt-7">
                    <button type="button" onclick="closeTambahModal()"
                        class="flex-1 py-2.5 rounded-xl bg-white/5 hover:bg-white/10 text-gray-400 hover:text-white text-xs font-black uppercase italic transition-all">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 py-2.5 rounded-xl bg-orange-500 hover:bg-orange-600 text-white text-xs font-black uppercase italic transition-all shadow-lg shadow-orange-500/20">
                        Tambah
                    </button>
                </div>
            </form>
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
                    {{-- Field Identitas Dinamis --}}
                    <div id="edit_identitas_container">
                        <label id="label_edit_identitas"
                            class="block text-[10px] uppercase font-black italic text-orange-500 tracking-widest mb-1.5">
                            Identitas
                        </label>
                        <input type="text" name="identitas_update" id="edit_identitas_value"
                            class="w-full bg-[#2a2a2a] border border-white/10 rounded-xl text-sm px-4 py-2.5 text-white outline-none focus:border-orange-500 transition-colors">
                        <input type="hidden" name="tipe_user_edit" id="tipe_user_edit">
                    </div>
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

                    {{-- Status Akun --}}
                    <div>
                        <label
                            class="block text-[10px] uppercase font-black italic text-orange-500 tracking-widest mb-1.5">
                            Status Akun
                        </label>
                        <select name="status_akun" id="edit_status_akun"
                            class="w-full bg-[#2a2a2a] border border-white/10 rounded-xl text-sm px-4 py-2.5 text-white outline-none focus:border-orange-500 transition-colors appearance-none cursor-pointer">
                            <option value="aktif">🟢 AKTIF</option>
                            <option value="nonaktif">🔴 NONAKTIF (BLOKIR)</option>
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

        // ---- Tambah Modal ----
        function openTambahModal() {
            const modal = document.getElementById('tambahModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            const bottomNav = document.getElementById('bottom-nav');
            if (bottomNav) bottomNav.classList.add('hidden');
        }

        function closeTambahModal() {
            const modal = document.getElementById('tambahModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');

            const bottomNav = document.getElementById('bottom-nav');
            if (bottomNav) bottomNav.classList.remove('hidden');
        }

        function toggleIdentitasInput(tipe) {
            const wrapperNisn = document.getElementById('wrapper_nisn');
            const wrapperEmail = document.getElementById('wrapper_email');
            const inputNisn = document.getElementById('input_nisn');
            const inputEmail = document.getElementById('input_email');

            if (tipe === 'siswa') {
                wrapperNisn.classList.remove('hidden');
                wrapperEmail.classList.add('hidden');
                inputEmail.value = ''; // Kosongkan email jika pilih siswa
                inputNisn.setAttribute('required', 'required');
                inputEmail.removeAttribute('required');
            } else {
                wrapperNisn.classList.add('hidden');
                wrapperEmail.classList.remove('hidden');
                inputNisn.value = ''; // Kosongkan NISN jika pilih guru
                inputEmail.setAttribute('required', 'required');
                inputNisn.removeAttribute('required');
            }
        }

        function toggleTambahBalanceField(role) {
            const field = document.getElementById('tambahBalanceField');
            field.style.display = role === 'pembeli' ? 'block' : 'none';
        }

        function openEditModal(id, name, email, nisn, balance, statusAkun) {
            // 1. Definisikan dulu elemennya biar JS nggak bingung
            const label = document.getElementById('label_edit_identitas');
            const input = document.getElementById('edit_identitas_value');
            const tipeHidden = document.getElementById('tipe_user_edit');

            // 2. Set Action Form (Pastikan route di web.php sudah sesuai)
            document.getElementById('editForm').action = `/admin/users/update/${id}`;

            // 3. Isi value dasar
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_balance').value = balance;
            document.getElementById('edit_status_akun').value = statusAkun;

            // 4. Logika Identitas (Siswa vs Guru/Penjual)
            if (nisn && nisn !== 'null' && nisn !== '') {
                // Jika User adalah Siswa
                label.innerText = "NISN (Siswa)";
                input.value = nisn;
                tipeHidden.value = 'siswa';
                // Sembunyikan input email biasa karena siswa pakai NISN
                document.getElementById('edit_email').parentElement.classList.add('hidden');
            } else {
                // Jika User adalah Guru/Penjual
                label.innerText = "Email (Guru/Penjual)";
                input.value = email;
                tipeHidden.value = 'guru';
                // Tampilkan input email jika dia bukan siswa
                document.getElementById('edit_email').parentElement.classList.remove('hidden');
                document.getElementById('edit_email').value = email;
            }

            // 5. Tampilkan Modal
            const modal = document.getElementById('editModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            const bottomNav = document.getElementById('bottom-nav');
            if (bottomNav) bottomNav.classList.add('hidden');
        }

        function closeEditModal() {
            const modal = document.getElementById('editModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');

            const bottomNav = document.getElementById('bottom-nav');
            if (bottomNav) bottomNav.classList.remove('hidden');
        }

        function toggleBalanceField(role) {
            const field = document.getElementById('balanceField');
            field.style.display = role === 'pembeli' ? 'block' : 'none';
        }

        // ✅ Listener dipasang setelah DOM siap, bukan langsung di script
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('edit_role').addEventListener('change', function() {
                toggleBalanceField(this.value);
            });
        });

        // Close modal on ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeEditModal();
                closeTambahModal();
            }
        });
    </script>
</x-app-layout>
