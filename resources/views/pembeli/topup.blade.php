<x-app-layout>
    <div class="min-h-screen bg-[#121212] text-white py-12 px-6 pb-32">
        <div class="max-w-md mx-auto">

            {{-- Header --}}
            <div class="mb-8 border-b border-orange-500/30 pb-6">
                <h2 class="text-3xl font-black text-orange-500 uppercase italic">Isi <span class="text-white">Saldo</span>
                </h2>
                <p class="text-gray-500 text-xs">Permintaan kamu akan dikonfirmasi oleh Admin.</p>
            </div>

            {{-- Form Card --}}
            <div class="bg-[#1e1e1e] rounded-[2.5rem] border border-white/5 p-8 shadow-2xl">
                <form action="{{ route('pembeli.topup.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label
                            class="block text-[10px] uppercase font-black italic text-orange-500 tracking-widest mb-3">Nominal
                            Top Up (Rp)</label>
                        <div class="relative group">
                            <span
                                class="absolute left-5 top-1/2 -translate-y-1/2 text-gray-500 font-bold italic group-focus-within:text-orange-500 transition-colors">Rp</span>

                            {{-- Input buat TAMPILAN (pakai titik) --}}
                            <input type="text" id="display_nominal" placeholder="Masukkan nominal..." required
                                class="w-full bg-[#2a2a2a] border border-white/10 rounded-2xl py-4 pl-14 pr-5 text-white focus:border-orange-500 outline-none transition-all font-black italic">

                            {{-- Input asli buat BACKEND (angka murni) --}}
                            <input type="hidden" name="nominal" id="real_nominal">
                        </div>

                        <script>
                            const displayInput = document.getElementById('display_nominal');
                            const realInput = document.getElementById('real_nominal');

                            displayInput.addEventListener('input', function(e) {
                                // Ambil angka saja
                                let value = this.value.replace(/[^0-9]/g, '');

                                // Simpan angka murni ke hidden input buat backend
                                realInput.value = value;

                                // Ubah tampilan ke format ribuan (titik)
                                if (value) {
                                    this.value = formatRupiah(value);
                                } else {
                                    this.value = '';
                                }
                            });

                            function formatRupiah(angka) {
                                return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                            }
                        </script>
                    </div>

                    <button type="submit"
                        class="w-full bg-orange-500 hover:bg-orange-600 py-4 rounded-2xl text-white font-black uppercase italic tracking-widest transition-all shadow-lg shadow-orange-500/20 active:scale-95">
                        Kirim Permintaan
                    </button>
                </form>
            </div>

            {{-- Info Box --}}
            <div class="mt-6 p-5 bg-orange-500/5 border border-orange-500/20 rounded-2xl flex gap-4 items-center">
                <i class="fa-solid fa-circle-info text-orange-500"></i>
                <p class="text-[10px] text-gray-400 leading-relaxed italic">
                    Setelah mengirim permintaan, silakan temui <span class="text-orange-500 font-bold">Admin
                        Sekolah</span> di kantin untuk menyerahkan uang tunai dan melakukan konfirmasi.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
