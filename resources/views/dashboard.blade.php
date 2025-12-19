<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Daftar Produk</h3>
                        @if(auth()->check() && auth()->user()->email === 'admin@gmail.com')
                            <a href="{{ route('products.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                + Tambah Produk
                            </a>
                        @endif
                    </div>
                    @if (Session::has('message'))
                        @php
                            $message = Session::get('message');
                            $type = Session::get('type') ?? 'added';
                            $colors = [
                                'added' => 'bg-green-100 border-green-400 text-green-700',
                                'edited' => 'bg-yellow-100 border-yellow-400 text-yellow-700',
                                'deleted' => 'bg-red-100 border-red-400 text-red-700',
                            ];
                            $colorClass = $colors[$type] ?? $colors['added'];
                        @endphp
                        <div class="mb-4 p-4 {{ $colorClass }} border rounded">
                            {{ $message }}
                        </div>
                    @endif
                    <table class="min-w-full border-collapse border border-gray-300 dark:border-gray-600">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">No</th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Nama Produk</th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Deskripsi</th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Harga</th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Stok</th>
                                @if(auth()->check() && auth()->user()->email === 'admin@gmail.com')
                                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $key => $product)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">{{ $key + 1 }}</td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">{{ $product->nama_produk }}</td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">{{ $product->deskripsi ?? '-' }}</td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">Rp. {{ number_format($product->harga, 0, ',', '.') }}</td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">{{ $product->stok }}</td>
                                    @if(auth()->check() && auth()->user()->email === 'admin@gmail.com')
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            <a href="{{ route('products.edit', $product->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded text-sm mr-2">Edit</a>
                                            <button onclick="openDeleteModal({{ $product->id }}, '{{ $product->nama_produk }}')" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-sm">Hapus</button>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-center text-gray-500">
                                        Tidak ada produk
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 max-w-sm w-full mx-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Hapus Produk</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-6">
                Apakah Anda yakin ingin menghapus produk <span id="productName" class="font-semibold text-red-600">nama produk</span>? Aksi ini tidak dapat dibatalkan.
            </p>
            <div class="flex justify-end gap-4">
                <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white rounded hover:bg-gray-400 dark:hover:bg-gray-700">
                    Batal
                </button>
                <button onclick="confirmDelete()" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-700">
                    Hapus
                </button>
            </div>
        </div>
    </div>

    <script>
        let deleteProductId = null;

        function openDeleteModal(productId, productName) {
            deleteProductId = productId;
            document.getElementById('productName').textContent = productName;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            deleteProductId = null;
            document.getElementById('deleteModal').classList.add('hidden');
        }

        function confirmDelete() {
            if (deleteProductId) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/products/${deleteProductId}`;
                form.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Close modal when clicking outside of it
        document.getElementById('deleteModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeDeleteModal();
            }
        });
    </script>
</x-app-layout>
