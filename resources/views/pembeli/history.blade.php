@use('SimpleSoftwareIO\QrCode\Facades\QrCode')
<x-app-layout>
    <div class="min-h-screen bg-[#121212] text-white py-12">
        <div class="max-w-4xl mx-auto px-4">
            <h2 class="text-2xl font-bold text-orange-500 mb-8 flex items-center">
                <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                    </path>
                </svg>
                Riwayat Jajan Kamu
            </h2>

            <div class="space-y-4">
                @forelse ($orders as $order)
                    <div class="bg-[#1e1e1e] rounded-3xl p-6 border border-white/5 shadow-xl mb-4">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-center">

                            <div>
                                <p class="text-[10px] text-gray-500 uppercase tracking-widest mb-1">Waktu & Metode</p>
                                <p class="font-bold text-sm text-white">{{ $order->created_at->format('d M Y, H:i') }}
                                </p>
                                <span
                                    class="inline-block mt-2 px-3 py-1 rounded-lg text-[10px] font-black uppercase {{ $order->metode_pembayaran == 'cashless' ? 'bg-blue-500/20 text-blue-400' : 'bg-green-500/20 text-green-400' }}">
                                    <i class="fas fa-wallet mr-1"></i>
                                    {{ $order->metode_pembayaran == 'cashless' ? 'E-Wallet' : 'Bayar Tunai' }}
                                </span>
                            </div>

                            <div
                                class="bg-orange-600/10 border border-orange-500/20 px-4 py-3 rounded-2xl text-center flex flex-col items-center justify-center">
                                <p class="text-[10px] text-orange-500 uppercase font-bold mb-1">Kode Ambil</p>

                                @if ($order->status_pesanan == 'siap_diambil')
                                    <div class="bg-white p-1 rounded-lg mb-2 cursor-pointer hover:scale-105 transition-transform"
                                        onclick="showQR('{{ $order->kode_ambil }}')"
                                        id="qr-container-{{ $order->kode_ambil }}">
                                        {!! QrCode::size(80)->generate($order->kode_ambil) !!}
                                    </div>
                                    <p class="text-xs font-black text-white tracking-widest">{{ $order->kode_ambil }}
                                    </p>
                                @else
                                    <p class="text-2xl font-black text-white tracking-widest">{{ $order->kode_ambil }}
                                    </p>
                                    <p class="text-[8px] text-gray-500 mt-1 italic">QR muncul jika sudah siap</p>
                                @endif
                            </div>

                            <div class="text-center md:text-left">
                                <p class="text-[10px] text-gray-500 uppercase tracking-widest mb-1">Total & Status Bayar
                                </p>
                                <p class="text-xl font-black text-orange-500">Rp
                                    {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                                <p
                                    class="text-[10px] font-bold {{ $order->status_pembayaran == 'paid' ? 'text-green-500' : 'text-red-500' }}">
                                    {{ $order->status_pembayaran == 'paid' ? '● LUNAS' : '● BELUM BAYAR' }}
                                </p>
                            </div>

                            <div class="text-right">
                                <p
                                    class="text-[10px] text-gray-500 uppercase tracking-widest mb-2 text-center md:text-right">
                                    Status Pesanan</p>
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-gray-500/20 text-gray-400',
                                        'diproses' => 'bg-blue-500/20 text-blue-400',
                                        'siap_diambil' => 'bg-yellow-500/20 text-yellow-400',
                                        'selesai' => 'bg-green-500/20 text-green-500',
                                    ];
                                    $statusText = [
                                        'pending' => 'Menunggu',
                                        'diproses' => 'Dimasak',
                                        'siap_diambil' => 'Siap!',
                                        'selesai' => 'Sudah Diambil',
                                    ];
                                @endphp
                                <div
                                    class="px-4 py-2 rounded-xl text-xs font-black uppercase text-center {{ $statusClasses[$order->status_pesanan] ?? 'bg-white/5' }}">
                                    {{ $statusText[$order->status_pesanan] ?? $order->status_pesanan }}
                                </div>
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="text-center py-20">
                        <p class="text-gray-500">Belum ada riwayat pesanan nih. Yuk jajan dulu!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <script>
        function showQR(kode) {
            // Mengambil elemen SVG QR Code
            const qrSvg = document.querySelector(`#qr-container-${kode} svg`).outerHTML;

            Swal.fire({
                title: 'Kode Ambil: ' + kode,
                html: `
            <div class="flex flex-col items-center justify-center p-4">
                <div id="expanded-qr" class="bg-white p-4 rounded-2xl mb-6">
                    ${qrSvg.replace('width="80"', 'width="250"').replace('height="80"', 'height="250"')}
                </div>
                <div class="flex gap-2 w-full">
                    <button onclick="downloadQR('${kode}')" class="flex-1 bg-orange-600 hover:bg-orange-700 text-white py-3 rounded-xl font-bold transition">
                        <i class="fas fa-download mr-2"></i> Simpan Gambar
                    </button>
                    <button onclick="shareQR('${kode}')" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-bold transition">
                        <i class="fas fa-share-alt mr-2"></i> Share
                    </button>
                </div>
            </div>
        `,
                showConfirmButton: false,
                background: '#1e1e1e',
                color: '#fff',
                showCloseButton: true
            });
        }

        function downloadQR(kode) {
            const svg = document.querySelector(`#qr-container-${kode} svg`);
            const svgData = new XMLSerializer().serializeToString(svg);
            const canvas = document.createElement("canvas");
            const ctx = canvas.getContext("2d");
            const img = new Image();

            img.onload = function() {
                canvas.width = 500;
                canvas.height = 500;
                ctx.fillStyle = "white";
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                ctx.drawImage(img, 50, 50, 400, 400);

                const pngFile = canvas.toDataURL("image/png");
                const downloadLink = document.createElement("a");
                downloadLink.download = `QR_Canteen_${kode}.png`;
                downloadLink.href = pngFile;
                downloadLink.click();
            };

            img.src = "data:image/svg+xml;base64," + btoa(svgData);
        }

        function shareQR(kode) {
            // Fungsi share sederhana menggunakan Web Share API jika didukung browser
            if (navigator.share) {
                navigator.share({
                    title: 'Kode Pengambilan Pesanan',
                    text: `Ini kode ambil pesanan aku: ${kode}`,
                    url: window.location.href
                }).catch(console.error);
            } else {
                Swal.fire({
                    icon: 'info',
                    title: 'Copy Kode',
                    text: 'Kode kamu: ' + kode + '. Fitur share langsung tidak didukung di browser ini.',
                    background: '#1e1e1e',
                    color: '#fff'
                });
            }
        }
    </script>
</x-app-layout>
