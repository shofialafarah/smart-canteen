<x-app-layout>
    <div class="min-h-screen bg-[#121212] text-white py-12 px-4 sm:px-6 lg:px-8 font-body">
        <div class="max-w-2xl mx-auto space-y-8">

            <div class="border-b border-orange-500/30 pb-6">
                <h2 class="font-display text-3xl font-black text-white italic uppercase tracking-tight">
                    Pengaturan <span class="text-orange-500">Profil</span>
                </h2>
                <p class="text-gray-400 text-sm mt-1">Kelola informasi akun dan keamanan kamu.</p>
            </div>

            <div class="bg-[#1e1e1e] p-8 rounded-3xl border border-white/5 shadow-2xl">
                <h3 class="font-display text-lg font-bold text-orange-500 uppercase tracking-widest mb-6">Informasi Dasar
                </h3>

                <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf
                    @method('patch')

                    <div class="flex flex-col items-center mb-8 bg-black/20 p-6 rounded-3xl border border-white/5">
                        <div class="relative group">
                            @if ($user->foto_profil)
                                <img src="{{ asset('storage/' . $user->foto_profil) }}" id="preview-photo"
                                    class="w-32 h-32 rounded-3xl object-cover border-2 border-orange-500 shadow-xl shadow-orange-900/20">
                            @else
                                <div id="placeholder-photo"
                                    class="w-32 h-32 rounded-3xl bg-[#121212] border-2 border-dashed border-white/10 flex items-center justify-center text-orange-500 shadow-inner">
                                    <i class="fa-solid fa-user text-4xl"></i>
                                </div>
                                <img id="preview-photo"
                                    class="hidden w-32 h-32 rounded-3xl object-cover border-2 border-orange-500 shadow-xl shadow-orange-900/20">
                            @endif

                            <label for="foto_profil"
                                class="absolute -bottom-2 -right-2 bg-orange-600 hover:bg-orange-500 w-10 h-10 rounded-xl flex items-center justify-center cursor-pointer transition-all border-4 border-[#1e1e1e] shadow-lg">
                                <i class="fa-solid fa-camera text-sm"></i>
                                <input type="file" name="foto_profil" id="foto_profil" class="hidden"
                                    accept="image/*" onchange="previewImage(this)">
                            </label>
                        </div>
                        <p class="text-[10px] text-gray-500 mt-4 uppercase font-bold tracking-widest italic">Ketuk icon
                            kamera untuk ganti foto</p>
                    </div>

                    <script>
                        function previewImage(input) {
                            const preview = document.getElementById('preview-photo');
                            const placeholder = document.getElementById('placeholder-photo');
                            if (input.files && input.files[0]) {
                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    preview.src = e.target.result;
                                    preview.classList.remove('hidden');
                                    if (placeholder) placeholder.classList.add('hidden');
                                }
                                reader.readAsDataURL(input.files[0]);
                            }
                        }
                    </script>

                    <div>
                        <label class="text-xs text-gray-500 ml-1 uppercase font-bold tracking-wider">Nama
                            Lengkap</label>
                        <input name="name" type="text" value="{{ old('name', $user->name) }}"
                            class="block mt-1 w-full bg-[#121212] border-white/10 rounded-2xl text-white focus:border-orange-500 focus:ring-orange-500 px-4 py-3"
                            required autofocus>
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <label class="text-xs text-gray-500 ml-1 uppercase font-bold tracking-wider italic">Identitas
                            (NISN/Email)</label>
                        <input type="text" value="{{ $user->nisn ?? $user->email }}"
                            class="block mt-1 w-full bg-white/5 border-white/5 rounded-2xl text-gray-500 px-4 py-3 cursor-not-allowed"
                            disabled>
                        <p class="text-[10px] text-gray-600 mt-2 italic">*Identitas login tidak dapat diubah sendiri.
                        </p>
                    </div>

                    <button type="submit"
                        class="bg-orange-600 hover:bg-orange-500 text-white font-display font-black px-8 py-3 rounded-xl transition-all uppercase tracking-widest text-sm italic shadow-lg shadow-orange-900/20">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Nama
                    </button>
                </form>
            </div>

            @if (auth()->user()->role === 'penjual')
                <div class="bg-[#1e1e1e] p-8 rounded-3xl border border-white/5 shadow-2xl mt-8">
                    <h3 class="font-display text-lg font-bold text-orange-500 uppercase tracking-widest mb-6">Informasi
                        Warung</h3>

                    <form method="post" action="{{ route('seller.shop.update') }}" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf
                        @method('patch')

                        <div>
                            <label class="text-xs text-gray-500 ml-1 uppercase font-bold tracking-wider">Nama
                                Warung</label>
                            <input name="nama_warung" type="text"
                                value="{{ old('nama_warung', auth()->user()->shop->nama_warung ?? '') }}"
                                class="block mt-1 w-full bg-[#121212] border-white/10 rounded-2xl text-white focus:border-orange-500 focus:ring-orange-500 px-4 py-3"
                                required>
                        </div>

                        <div>
                            <label class="text-xs text-gray-500 ml-1 uppercase font-bold tracking-wider">Foto
                                Warung</label>
                            @if (auth()->user()->shop && auth()->user()->shop->foto_warung)
                                <img src="{{ asset('storage/' . auth()->user()->shop->foto_warung) }}"
                                    class="w-20 h-20 object-cover rounded-xl mb-3 border border-orange-500/50">
                            @endif
                            <input name="foto_warung" type="file"
                                class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-600 file:text-white hover:file:bg-orange-500 cursor:pointer">
                            <p class="text-[10px] text-gray-600 mt-2">*Kosongkan jika tidak ingin mengubah foto.</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs text-gray-500 ml-1 uppercase font-bold tracking-wider">Jam
                                    Buka</label>
                                <input name="jam_buka" type="time"
                                    value="{{ old('jam_buka', auth()->user()->shop->jam_buka ?? '07:00') }}"
                                    class="block mt-1 w-full bg-[#121212] border-white/10 rounded-2xl text-white focus:border-orange-500 px-4 py-3">
                            </div>
                            <div>
                                <label class="text-xs text-gray-500 ml-1 uppercase font-bold tracking-wider">Jam
                                    Tutup</label>
                                <input name="jam_tutup" type="time"
                                    value="{{ old('jam_tutup', auth()->user()->shop->jam_tutup ?? '16:00') }}"
                                    class="block mt-1 w-full bg-[#121212] border-white/10 rounded-2xl text-white focus:border-orange-500 px-4 py-3">
                            </div>
                        </div>

                        <button type="submit"
                            class="bg-orange-600 hover:bg-orange-500 text-white font-display font-black px-8 py-3 rounded-xl transition-all uppercase tracking-widest text-sm italic shadow-lg shadow-orange-900/20">
                            <i class="fa-solid fa-store"></i> Simpan Data Warung
                        </button>
                    </form>
                </div>
            @endif

            <div class="bg-[#1e1e1e] p-8 rounded-3xl border border-white/5 shadow-2xl">
                <div class="flex items-center space-x-3 mb-6">
                    <h3 class="font-display text-lg font-bold text-orange-500 uppercase tracking-widest">Keamanan Akun
                    </h3>
                </div>

                <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                    @csrf
                    @method('put')

                    <div>
                        <label class="text-xs text-gray-500 ml-1 uppercase font-bold tracking-wider">Password Saat
                            Ini</label>
                        <input name="current_password" type="password"
                            class="block mt-1 w-full bg-[#121212] border-white/10 rounded-2xl text-white focus:border-orange-500 focus:ring-orange-500 px-4 py-3"
                            placeholder="Masukkan password lama">
                        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                    </div>

                    <div>
                        <label class="text-xs text-gray-500 ml-1 uppercase font-bold tracking-wider"><i
                                class="fa-solid fa-lock text-orange-500 mr-1"></i> Password Baru</label>
                        <input name="password" type="password"
                            class="block mt-1 w-full bg-[#121212] border-white/10 rounded-2xl text-white focus:border-orange-500 focus:ring-orange-500 px-4 py-3"
                            placeholder="Minimal 8 karakter">
                        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                    </div>

                    <div>
                        <label class="text-xs text-gray-500 ml-1 uppercase font-bold tracking-wider">Ulangi Password
                            Baru</label>
                        <input name="password_confirmation" type="password"
                            class="block mt-1 w-full bg-[#121212] border-white/10 rounded-2xl text-white focus:border-orange-500 focus:ring-orange-500 px-4 py-3"
                            placeholder="Ketik ulang password baru">
                    </div>

                    <button type="submit"
                        class="bg-orange-600 hover:bg-orange-500 text-white font-display font-black px-8 py-3 rounded-xl transition-all uppercase tracking-widest text-sm italic shadow-lg shadow-orange-900/20">
                        <i class="fa-solid fa-shield-halved"></i> Perbarui Password
                    </button>
                </form>
            </div>

            <div class="h-24"></div>
        </div>
    </div>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'BERHASIL!',
                text: "{{ session('success') }}",
                background: '#1e1e1e',
                color: '#fff',
                confirmButtonColor: '#ea580c',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'WADUH!',
                text: 'Ada yang salah nih, cek inputan kamu lagi ya.',
                background: '#1e1e1e',
                color: '#fff',
                confirmButtonColor: '#ea580c'
            });
        </script>
    @endif
</x-app-layout>
