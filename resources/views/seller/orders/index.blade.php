<x-app-layout>
    <div class="min-h-screen bg-[#121212] text-white py-12 pb-24">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-10 border-b border-orange-500/30 pb-6">
                <h2 class="font-display text-3xl font-black text-orange-500 tracking-tight uppercase italic">
                    Daftar <span class="text-white italic">Pesanan Masuk</span>
                </h2>
                <p class="font-body text-gray-400 text-sm mt-1">Pantau pesanan siswa yang masuk ke warungmu.</p>
            </div>

            <div class="space-y-6">
                @forelse ($orders as $order)
                    <div class="bg-[#1e1e1e] rounded-3xl border border-white/5 p-6 shadow-xl">
                        <div class="flex flex-col md:flex-row justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div
                                    class="h-12 w-12 bg-orange-500/20 rounded-full flex items-center justify-center text-orange-500 font-black">
                                    {{ substr($order->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <h3 class="font-display font-bold text-lg uppercase">{{ $order->user->name }}</h3>
                                    <p class="text-xs text-gray-500 font-body">{{ $order->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex flex-col items-end gap-3">
                                <div class="flex items-center gap-2">
                                    @if ($order->metode_pembayaran == 'cashless')
                                        <span
                                            class="bg-blue-500/10 text-blue-400 text-[10px] font-black px-3 py-1 rounded-lg uppercase tracking-tighter border border-blue-500/20">
                                            💳 E-Wallet (Lunas)
                                        </span>
                                    @else
                                        <span
                                            class="bg-yellow-500/10 text-yellow-400 text-[10px] font-black px-3 py-1 rounded-lg uppercase tracking-tighter border border-yellow-500/20">
                                            💵 Bayar Tunai
                                        </span>
                                    @endif
                                </div>

                                @if ($order->status_pesanan == 'pending')
                                    <form action="{{ route('seller.orders.update', $order->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit"
                                            class="bg-orange-600 hover:bg-orange-500 text-white text-[11px] font-black px-6 py-2.5 rounded-xl transition-all uppercase italic shadow-[0_4px_15px_rgba(234,88,12,0.3)] hover:scale-105 active:scale-95">
                                            Terima Pesanan
                                        </button>
                                    </form>
                                @elseif($order->status_pesanan == 'diproses')
                                    <form action="{{ route('seller.orders.update', $order->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit"
                                            class="bg-blue-600 hover:bg-blue-500 text-white text-[11px] font-black px-6 py-2.5 rounded-xl transition-all uppercase italic shadow-[0_4px_15px_rgba(37,99,235,0.3)]">
                                            Siap Diambil
                                        </button>
                                    </form>
                                @elseif($order->status_pesanan == 'siap_diambil')
                                    <form action="{{ route('seller.orders.update', $order->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit"
                                            class="bg-green-600 hover:bg-green-500 text-white text-[11px] font-black px-6 py-2.5 rounded-xl transition-all uppercase italic shadow-[0_4px_15px_rgba(22,163,74,0.3)]">
                                            Selesaikan (Scan)
                                        </button>
                                    </form>
                                @else
                                    <span
                                        class="text-gray-500 font-black italic text-xs uppercase tracking-widest bg-white/5 px-4 py-2 rounded-lg border border-white/5">
                                        ✓ Sudah Diambil
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="mt-6 pt-6 border-t border-white/5">
                            <ul class="space-y-3">
                                @foreach ($order->details as $detail)
                                    <li class="flex justify-between items-center font-body text-sm">
                                        <span class="text-gray-300">
                                            {{ $detail->menu->nama_menu }}
                                            <b class="text-orange-500 ml-2 text-xs">x{{ $detail->quantity }}</b>
                                        </span>
                                        <span class="font-bold">Rp
                                            {{ number_format($detail->menu->harga, 0, ',', '.') }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="mt-4 text-right">
                                <p class="text-xs text-gray-500">Total Pembayaran:</p>
                                <p class="text-xl font-black text-orange-500 italic">
                                    Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                </p>
                                <p class="text-[10px] text-gray-600 uppercase tracking-widest mt-1">
                                    KODE: {{ $order->kode_ambil }}
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-20 bg-[#1e1e1e] rounded-3xl border border-dashed border-white/10">
                        <p class="font-body text-gray-500 italic">Belum ada pesanan nih, sabar ya!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <div id="reader" class="mx-auto mb-8 rounded-3xl overflow-hidden border-2 border-orange-500/20 shadow-2xl"
        style="width: 100%; max-width: 500px;"></div>

    <script src="https://unpkg.com/html5-qrcode"></script>

    <script>
        // Fungsi yang jalan kalau scan berhasil
        function onScanSuccess(decodedText, decodedResult) {
            html5QrcodeScanner.clear(); // Matikan kamera biar gak silau

            Swal.fire({
                title: 'QR Berhasil!',
                text: 'Memproses kode: ' + decodedText,
                icon: 'success',
                background: '#1e1e1e',
                color: '#fff',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                // Arahkan ke controller untuk update status
                window.location.href = "/seller/orders/update-by-qr/" + decodedText;
            });
        }

        // Konfigurasi dan Jalankan Scanner
        // Sesuai screenshot kamu, pastikan id-nya tetap "reader"
        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", {
                fps: 10,
                qrbox: {
                    width: 250,
                    height: 250
                }
            },
            false
        );

        html5QrcodeScanner.render(onScanSuccess);
    </script>
</x-app-layout>
