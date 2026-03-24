<x-guest-layout>
    <div class="min-h-screen bg-[#121212] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 font-body">
        <div class="max-w-md w-full space-y-8 bg-[#1e1e1e] p-10 rounded-3xl border border-white/5 shadow-2xl">
            
            <div class="text-center">
                <h2 class="font-display text-4xl font-black text-white uppercase italic tracking-tighter">
                    Smart <span class="text-orange-500">Canteen</span>
                </h2>
                <p class="mt-2 text-sm text-gray-400 font-body italic">Silakan masuk untuk mulai jajan!</p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-6">
                @csrf

                <div class="space-y-5">
                    <div>
                        <label for="email" class="font-display text-orange-500 text-xs uppercase tracking-widest mb-2 block font-bold">NISN / Email</label>
                        <input id="email" 
                               class="block w-full bg-[#121212] border-white/10 rounded-2xl px-6 py-4 text-white font-body focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition shadow-inner placeholder-gray-600" 
                               type="text" 
                               name="email" 
                               :value="old('email')" 
                               placeholder="Contoh: 00123456 atau email@staff.com"
                               required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <label for="password" class="font-display text-orange-500 text-xs uppercase tracking-widest mb-2 block font-bold">Password</label>
                        <input id="password" 
                               class="block w-full bg-[#121212] border-white/10 rounded-2xl px-6 py-4 text-white font-body focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition shadow-inner placeholder-gray-600"
                               type="password"
                               name="password"
                               placeholder="••••••••"
                               required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer">
                        <input id="remember_me" type="checkbox" class="rounded bg-[#121212] border-white/10 text-orange-600 shadow-sm focus:ring-orange-500" name="remember">
                        <span class="ms-2 text-sm text-gray-400 font-body">{{ __('Ingat saya') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-gray-500 hover:text-orange-500 transition font-body underline decoration-orange-500/30" href="{{ route('password.request') }}">
                            {{ __('Lupa password?') }}
                        </a>
                    @endif
                </div>

                <div>
                    <button type="submit" class="w-full bg-orange-600 hover:bg-orange-500 text-white font-display font-black py-5 rounded-2xl transition-all uppercase tracking-widest shadow-[0_8px_30px_rgb(234,88,12,0.4)] active:scale-[0.98] text-lg italic">
                        Masuk Sekarang 🚀
                    </button>
                </div>

                <div class="text-center pt-2">
                    <p class="text-sm text-gray-500 font-body">
                        Mau jualan di sini? 
                        <a href="{{ route('register') }}" class="text-orange-500 font-bold hover:underline">Daftar Akun Penjual</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>