<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Menu Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('menu.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <x-input-label for="nama_menu" :value="__('Nama Makanan/Minuman')" />
                    <x-text-input id="nama_menu" class="block mt-1 w-full" type="text" name="nama_menu" required />
                </div>
                
                <div class="mb-4">
                        <x-input-label for="harga" :value="__('Harga (Rp)')" />
                        <x-text-input id="harga" class="block mt-1 w-full" type="number" name="harga" required />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="stok" :value="__('Stok Awal')" />
                        <x-text-input id="stok" class="block mt-1 w-full" type="number" name="stok" required />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="foto_menu" :value="__('Foto Produk')" />
                        <input type="file" name="foto_menu" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    </div>

                    <x-primary-button>
                        {{ __('Simpan Menu') }}
                    </x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>