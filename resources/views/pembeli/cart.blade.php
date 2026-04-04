<x-app-layout>
    <div class="min-h-screen bg-[#121212] text-white py-12">
        <div class="max-w-4xl mx-auto px-4">
            <h2 class="text-2xl font-bold text-orange-500 mb-8 flex items-center">
                <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </svg>
                Keranjang Belanja
            </h2>

            <div class="bg-[#1e1e1e] rounded-3xl p-6 border border-white/5 shadow-2xl">
                @php $total = 0 @endphp
                @if (session('cart'))
                    @foreach (session('cart') as $id => $details)
                        @php $total += $details['price'] * $details['quantity'] @endphp
                        <div
                            class="flex flex-col md:flex-row items-center justify-between border-b border-white/5 py-6 last:border-0 gap-4">
                            <div class="flex items-center space-x-4 w-full">
                                <img src="{{ Storage::disk('supabase')->url($details['photo']) }}"
                                    class="w-20 h-20 rounded-2xl object-cover border border-orange-500/20 shadow-lg">
                                <div class="flex-1">
                                    <h4 class="font-bold text-lg text-white">{{ $details['name'] }}</h4>
                                    <p class="text-xs text-gray-500 mb-2">{{ $details['shop'] }}</p>
                                    <div class="flex items-center space-x-2">
                                        <button
                                            onclick="updateCart('{{ $id }}', {{ $details['quantity'] - 1 }})"
                                            class="bg-[#2a2a2a] hover:bg-orange-600 text-white w-8 h-8 rounded-lg transition flex items-center justify-center border border-white/5 {{ $details['quantity'] <= 1 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                            {{ $details['quantity'] <= 1 ? 'disabled' : '' }}>
                                            -
                                        </button>

                                        <span
                                            class="text-orange-500 font-bold w-8 text-center">{{ $details['quantity'] }}</span>

                                        <button
                                            onclick="updateCart('{{ $id }}', {{ $details['quantity'] + 1 }})"
                                            class="bg-[#2a2a2a] hover:bg-orange-600 text-white w-8 h-8 rounded-lg transition flex items-center justify-center border border-white/5">
                                            +
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between w-full md:w-auto md:space-x-8">
                                <div class="text-right">
                                    <p class="text-xs text-gray-500">Subtotal</p>
                                    <p class="font-black text-xl text-white">Rp
                                        {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}</p>
                                </div>

                                <button onclick="removeFromCart('{{ $id }}')"
                                    class="bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white p-2.5 rounded-xl transition-all border border-red-500/20">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-center text-gray-500 py-10">Keranjang masih kosong nih.</p>
                @endif

                <div class="mt-8 border-t border-orange-500/30 pt-6">
                    <div class="flex justify-between items-center mb-6">
                        <span class="text-gray-400 font-medium text-lg">Total Pembayaran:</span>
                        <span class="text-3xl font-black text-orange-500">Rp
                            {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <div class="mb-8">
                        <label class="text-gray-400 font-medium text-sm uppercase tracking-widest mb-4 block">
                            Pilih Metode Pembayaran:
                        </label>

                        <div class="grid grid-cols-2 gap-4">
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="metode_pembayaran" value="cash" class="peer hidden"
                                    onclick="document.getElementById('metode_pembayaran_input').value = 'cash'" checked>
                                <div
                                    class="bg-[#2a2a2a] border-2 border-transparent peer-checked:border-orange-500 peer-checked:bg-orange-500/10 p-4 rounded-2xl transition-all flex flex-col items-center gap-2 group-hover:bg-[#333]">
                                    <svg class="w-6 h-6 text-gray-400 peer-checked:text-orange-500" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                    </svg>
                                    <span class="font-bold text-sm uppercase italic">Bayar Tunai</span>
                                </div>
                            </label>

                            <label class="relative cursor-pointer group">
                                <input type="radio" name="metode_pembayaran" value="cashless" class="peer hidden"
                                    onclick="document.getElementById('metode_pembayaran_input').value = 'cashless'">
                                <div
                                    class="bg-[#2a2a2a] border-2 border-transparent peer-checked:border-orange-500 peer-checked:bg-orange-500/10 p-4 rounded-2xl transition-all flex flex-col items-center gap-2 group-hover:bg-[#333]">
                                    <svg class="w-6 h-6 text-gray-400 peer-checked:text-orange-500" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                    <span class="font-bold text-sm uppercase italic">E-Wallet</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <form id="checkout-form" action="{{ route('order.store') }}" method="POST">
                        @csrf
                        {{-- Input hidden ini akan diisi otomatis oleh JavaScript saat memilih radio button --}}
                        <input type="hidden" name="metode_pembayaran" id="metode_pembayaran_input" value="cash">

                        <button type="button" onclick="confirmPayment()"
                            class="w-full bg-orange-600 hover:bg-orange-500 text-white font-black py-4 rounded-2xl transition-all shadow-lg shadow-orange-900/20 text-lg uppercase tracking-widest italic">
                            Konfirmasi Pesanan
                        </button>
                    </form>
                </div>
            </div>

            <div class="mt-6 text-center">
                <a href="{{ route('pembeli.dashboard') }}"
                    class="text-gray-500 hover:text-white transition text-sm font-medium">
                    ← Kembali jajan lagi
                </a>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function confirmPayment() {
            // Cari radio yang dipilih
            const selectedRadio = document.querySelector('input[name="metode_pembayaran"]:checked');

            if (!selectedRadio) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops!',
                    text: 'Pilih metode pembayaran dulu ya.',
                    background: '#1e1e1e',
                    color: '#fff'
                });
                return;
            }

            const selectedMethod = selectedRadio.value;

            // Set nilai ke input hidden di dalam form sebelum submit
            document.getElementById('metode_pembayaran_input').value = selectedMethod;

            let textMessage = selectedMethod === 'cashless' ?
                "Saldo kamu akan terpotong untuk pesanan ini." :
                "Kamu akan membayar tunai saat mengambil pesanan.";

            Swal.fire({
                title: 'Konfirmasi Pesanan',
                text: textMessage,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#ea580c',
                cancelButtonColor: '#303030',
                confirmButtonText: 'Ya, Pesan Sekarang!',
                cancelButtonText: 'Batal',
                background: '#1e1e1e',
                color: '#fff'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Pastikan ID form benar-benar 'checkout-form'
                    document.getElementById('checkout-form').submit();
                }
            });
        }
    </script>
    <script type="text/javascript">
        function updateCart(id, qty) {
            if (qty < 1) return;

            $.ajax({
                url: '{{ route('cart.update') }}',
                method: "PATCH",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    quantity: qty
                },
                success: function(response) {
                    // Notifikasi toast kecil di pojok
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500,
                        timerProgressBar: true
                    });

                    Toast.fire({
                        icon: 'success',
                        title: 'Jumlah diperbarui'
                    }).then(() => {
                        window.location.reload();
                    });
                }
            });
        }

        function removeFromCart(id) {
            Swal.fire({
                title: 'Hapus Menu?',
                text: "Menu ini akan dikeluarkan dari keranjang belanja kamu.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ea580c', // Warna oranye
                cancelButtonColor: '#303030',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                background: '#1e1e1e', // Tema Dark
                color: '#fff'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('cart.remove') }}',
                        method: "DELETE",
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: id
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Terhapus!',
                                icon: 'success',
                                background: '#1e1e1e',
                                color: '#fff',
                                showConfirmButton: false,
                                timer: 1000
                            }).then(() => {
                                window.location.reload();
                            });
                        }
                    });
                }
            });
        }
    </script>
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Waduh!',
                text: @json(session('error')),
                background: '#1e1e1e',
                color: '#fff',
                confirmButtonColor: '#f97316'
            });
        </script>
    @endif

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: @json(session('error')),
                background: '#1e1e1e',
                color: '#fff',
                showConfirmButton: false,
                timer: 1500
            });
        </script>
    @endif
</x-app-layout>
