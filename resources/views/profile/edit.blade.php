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
                <h3 class="font-display text-lg font-bold text-orange-500 uppercase tracking-widest mb-6">Informasi Dasar</h3>
                
                <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                    @csrf
                    @method('patch')

                    <div>
                        <label class="text-xs text-gray-500 ml-1 uppercase font-bold tracking-wider">Nama Lengkap</label>
                        <input name="name" type="text" value="{{ old('name', $user->name) }}" class="block mt-1 w-full bg-[#121212] border-white/10 rounded-2xl text-white focus:border-orange-500 focus:ring-orange-500 px-4 py-3" required autofocus>
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <label class="text-xs text-gray-500 ml-1 uppercase font-bold tracking-wider italic">Identitas (NISN/Email)</label>
                        <input type="text" value="{{ $user->nisn ?? $user->email }}" class="block mt-1 w-full bg-white/5 border-white/5 rounded-2xl text-gray-500 px-4 py-3 cursor-not-allowed" disabled>
                        <p class="text-[10px] text-gray-600 mt-2 italic">*Identitas login tidak dapat diubah sendiri.</p>
                    </div>

                    <button type="submit" class="bg-orange-600 hover:bg-orange-500 text-white font-display font-black px-8 py-3 rounded-xl transition-all uppercase tracking-widest text-sm italic shadow-lg shadow-orange-900/20">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Nama
                    </button>
                </form>
            </div>

            <div class="bg-[#1e1e1e] p-8 rounded-3xl border border-white/5 shadow-2xl">
                <div class="flex items-center space-x-3 mb-6">
                    <h3 class="font-display text-lg font-bold text-orange-500 uppercase tracking-widest">Keamanan Akun</h3>
                </div>

                <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                    @csrf
                    @method('put')

                    <div>
                        <label class="text-xs text-gray-500 ml-1 uppercase font-bold tracking-wider">Password Saat Ini</label>
                        <input name="current_password" type="password" class="block mt-1 w-full bg-[#121212] border-white/10 rounded-2xl text-white focus:border-orange-500 focus:ring-orange-500 px-4 py-3" placeholder="Masukkan password lama">
                        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                    </div>

                    <div>
                        <label class="text-xs text-gray-500 ml-1 uppercase font-bold tracking-wider"><i class="fa-solid fa-lock text-orange-500 mr-1"></i> Password Baru</label>
                        <input name="password" type="password" class="block mt-1 w-full bg-[#121212] border-white/10 rounded-2xl text-white focus:border-orange-500 focus:ring-orange-500 px-4 py-3" placeholder="Minimal 8 karakter">
                        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                    </div>

                    <div>
                        <label class="text-xs text-gray-500 ml-1 uppercase font-bold tracking-wider">Ulangi Password Baru</label>
                        <input name="password_confirmation" type="password" class="block mt-1 w-full bg-[#121212] border-white/10 rounded-2xl text-white focus:border-orange-500 focus:ring-orange-500 px-4 py-3" placeholder="Ketik ulang password baru">
                    </div>

                    <button type="submit" class="bg-orange-600 hover:bg-orange-500 text-white font-display font-black px-8 py-3 rounded-xl transition-all uppercase tracking-widest text-sm italic shadow-lg shadow-orange-900/20">
                        <i class="fa-solid fa-shield-halved"></i> Perbarui Password
                    </button>
                </form>
            </div>
            
            <div class="h-24"></div>
        </div>
    </div>
</x-app-layout>