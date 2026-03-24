<x-guest-layout>
    <div class="min-h-screen bg-[#121212] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 font-body">
        <div class="max-w-md w-full space-y-8 bg-[#1e1e1e] p-10 rounded-3xl border border-white/5 shadow-2xl">
            
            <div class="text-center">
                <h2 class="font-display text-4xl font-black text-white uppercase italic tracking-tighter">
                    Daftar <span class="text-orange-500">Penjual</span>
                </h2>
                <p class="mt-2 text-sm text-gray-400 font-body">Mulai jualan jajananmu di Smart Canteen hari ini!</p>
            </div>

            <form class="mt-8 space-y-6" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                @csrf

                <div class="space-y-4">
                    <div class="border-b border-white/5 pb-4 mb-4">
                        <span class="font-display text-xs text-orange-500 uppercase tracking-widest font-bold">Informasi Pemilik</span>
                    </div>

                    <div>
                        <x-text-input id="name" placeholder="Nama Lengkap" class="block mt-1 w-full bg-[#121212] border-white/10 rounded-xl text-white focus:border-orange-500 focus:ring-orange-500 px-4 py-3" type="text" name="name" :value="old('name')" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-text-input id="email" placeholder="Email Aktif" class="block mt-1 w-full bg-[#121212] border-white/10 rounded-xl text-white focus:border-orange-500 focus:ring-orange-500 px-4 py-3" type="email" name="email" :value="old('email')" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <x-text-input id="password" placeholder="Password" class="block mt-1 w-full bg-[#121212] border-white/10 rounded-xl text-white focus:border-orange-500 focus:ring-orange-500 px-4 py-3" type="password" name="password" required />
                        <x-text-input id="password_confirmation" placeholder="Ulangi Password" class="block mt-1 w-full bg-[#121212] border-white/10 rounded-xl text-white focus:border-orange-500 focus:ring-orange-500 px-4 py-3" type="password" name="password_confirmation" required />
                    </div>

                    <div class="border-b border-white/5 pb-4 pt-4 mb-4">
                        <span class="font-display text-xs text-orange-500 uppercase tracking-widest font-bold">Identitas Warung</span>
                    </div>

                    <div>
                        <x-text-input id="nama_warung" placeholder="Nama Warung (Contoh: Berkah Snack)" class="block mt-1 w-full bg-[#121212] border-white/10 rounded-xl text-white focus:border-orange-500 focus:ring-orange-500 px-4 py-3" type="text" name="nama_warung" required />
                    </div>

                    <div>
                        <label class="text-xs text-gray-500 ml-1">Foto Sampul Warung</label>
                        <input id="foto_warung" name="foto_warung" type="file" class="block mt-1 w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-orange-500/10 file:text-orange-500 hover:file:bg-orange-500/20 transition-all cursor-pointer" required>
                    </div>
                </div>

                <input type="hidden" name="role" value="penjual">

                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-4 px-4 border border-transparent text-lg font-display font-black rounded-2xl text-white bg-orange-600 hover:bg-orange-500 focus:outline-none transition-all shadow-[0_10px_30px_rgba(234,88,12,0.3)] uppercase italic tracking-widest">
                        🚀 Daftar Sekarang
                    </button>
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-orange-500 transition font-body">
                        Sudah punya akun? <span class="font-bold underline">Login di sini</span>
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>