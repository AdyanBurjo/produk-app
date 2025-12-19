<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('products.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="nama_produk" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Produk</label>
                            <input type="text" name="nama_produk" id="nama_produk" value="{{ old('nama_produk') }}" class="mt-1 p-2 w-full border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700 dark:text-white @error('nama_produk') border-red-500 @enderror" required>
                            @error('nama_produk')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" rows="4" class="mt-1 p-2 w-full border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700 dark:text-white @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="harga" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Harga</label>
                            <input type="number" name="harga" id="harga" value="{{ old('harga') }}" class="mt-1 p-2 w-full border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700 dark:text-white @error('harga') border-red-500 @enderror" required>
                            @error('harga')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="stok" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Stok</label>
                            <input type="number" name="stok" id="stok" value="{{ old('stok') }}" class="mt-1 p-2 w-full border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700 dark:text-white @error('stok') border-red-500 @enderror" required>
                            @error('stok')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex justify-between">
                            <a href="{{ route('dashboard') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Kembali
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
