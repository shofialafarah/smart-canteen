<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wdth,wght@12..96,75..100,200..800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
    @include('layouts.partials.bottom-nav')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Alert untuk Success Message
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'BERHASIL!',
            text: "{{ session('success') }}",
            background: '#1e1e1e',
            color: '#fff',
            confirmButtonColor: '#ea580c', // Warna orange-600
            iconColor: '#ea580c'
        });
    @endif

    // Konfirmasi Hapus (Gunakan class .btn-hapus di tombol)
    document.addEventListener('click', function (e) {
        if (e.target.closest('.btn-hapus')) {
            e.preventDefault();
            const form = e.target.closest('form');
            Swal.fire({
                title: 'Hapus Menu?',
                text: "Menu yang dihapus gak bisa dikembalikan lho!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ea580c',
                cancelButtonColor: '#3f3f46',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                background: '#1e1e1e',
                color: '#fff',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    });
</script>
<script>
    function confirmLogout() {
        // Ambil nama user (dipotong biar gak kepanjangan)
        const fullName = "{{ auth()->user()->name }}";
        const firstName = fullName.split(' ')[0]; // Ambil kata pertama saja (misal: "Shofia")
        
        // Ambil role user
        const role = "{{ auth()->user()->role }}";
        
        // Tentukan pesan berdasarkan role
        let messageText = "Jangan lupa balik lagi buat jajan ya!"; // Default Pembeli
        
        if (role === 'penjual') {
            messageText = "Pastikan semua pesanan sudah diproses ya!";
        } else if (role === 'admin') {
            messageText = "Keluar dari panel kendali sistem?";
        }

        Swal.fire({
            title: `Mau keluar, ${firstName}?`, // Pakai template literal
            text: messageText,
            icon: 'warning',
            showCancelButton: true,
            background: '#1e1e1e', 
            color: '#ffffff',
            confirmButtonColor: '#f97316', 
            cancelButtonColor: '#3f3f46',
            confirmButtonText: 'Ya, Keluar!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            borderRadius: '20px'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        })
    }
</script>
</body>

</html>
