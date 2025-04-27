<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Keranjang Belanja') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <strong class="font-bold">Sukses! </strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Gagal! </strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-x-auto shadow sm:rounded-lg p-6">
    <div class="flex flex-col md:flex-row gap-6">
        
        <!-- Kiri: Produk List -->
        <div class="w-full md:w-2/3 grid grid-cols-2 md:grid-cols-3 gap-2 overflow-y-auto">
            @foreach ($produks as $produk)
            @php
                $isOutOfStock = $produk->kuantitas <= 0;
            @endphp
            <div class="aspect-square bg-gray-100 dark:bg-gray-900 p-2 rounded shadow flex flex-col items-center justify-between">
                <img 
                    src="{{ $produk->gambar_produk ? asset('storage/' . $produk->gambar_produk) : '/default.jpg' }}" 
                    alt="{{ $produk->nama_produk }}" 
                    class="w-2/3 h-2/3 object-contain rounded mb-1"
                    onerror="this.onerror=null;this.src='/default.jpg';"
                >
                <h3 class="text-center font-semibold text-gray-800 dark:text-gray-200 text-sm">
                    {{ Str::limit($produk->nama_produk, 15) }}
                </h3>
                <p class="text-gray-600 dark:text-gray-400 text-xs mb-0">
                    Rp {{ number_format($produk->harga, 0, ',', '.') }}
                </p>
                <form action="{{ route('keranjang.store') }}" method="POST" class="w-full">
                    @csrf
                    <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                    <input type="hidden" name="jumlah" value="1">
                    <div class="flex items-center w-full">
                        <div class="w-1/3 text-right mr-2 mt-1">
                            <p class="text-gray-600 dark:text-gray-400 text-xs">
                                Stok: {{ $produk->kuantitas }}
                            </p>
                        </div>
                        <div class="w-2/3 text-right">
                            <button 
                                type="submit" 
                                class="w-2/3 py-1 px-1 rounded text-xs font-semibold
                                    {{ $isOutOfStock ? 
                                    'bg-gray-400 dark:bg-gray-600 cursor-not-allowed' : 
                                    'bg-green-500 hover:bg-green-600 text-white' }}"
                                {{ $isOutOfStock ? 'disabled' : '' }}
                            >
                                + Tambah
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            @endforeach
        </div>

        <!-- Kanan: Ringkasan Pembayaran -->
        <div class="w-full md:w-2/3 flex flex-col gap-4">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Harga</th>
                            <th class="px-1 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jumlah</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        @forelse ($items as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $item->produk->nama_produk }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</td>
                                <td class="px-3 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">
                                    <form action="{{ route('keranjang.update', $item) }}" method="POST" class="flex items-center">
                                        @csrf
                                        @method('POST')
                                        <input type="number" 
                                            name="quantity" 
                                            value="{{ $item->jumlah }}" 
                                            min="1" 
                                            max="{{ $item->produk->kuantitas }}"
                                            class="w-16 text-center border-gray-300 rounded dark:bg-gray-800 dark:text-gray-100"
                                            onchange="this.form.submit()">
                                    </form>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap flex gap-2 justify-center">


                                    <!-- Hapus -->
                                    <button 
                                        type="button" 
                                        onclick="openDeleteModal({{ $item->id }})" 
                                        class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded text-sm"
                                    >
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    Keranjang kosong.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6 border-t pt-4">
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">Subtotal: Rp {{ number_format($total_belanja, 0, ',', '.') }}</p>

                <form action="{{ route('keranjang.checkout') }}" method="POST" class="mt-4">
                    @csrf
                    <label class="block mb-1 text-sm font-semibold text-gray-700 dark:text-gray-300">Jumlah Bayar</label>
                    <input type="text" name="pay_total" class="w-full rounded border-gray-300 mb-2 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 @error('pay_total') border-red-500 @enderror" 
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Masukkan jumlah bayar" required>

                    @error('pay_total')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror

                    <button type="submit" class="mt-3 w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded font-semibold">
                        Bayar
                    </button>
                </form>
            </div>

        </div> <!-- Tutup kanan -->
        
    </div> <!-- Tutup flex -->
</div> <!-- Tutup kotak -->

    <!-- Modal Delete -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 items-center justify-center hidden z-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg max-w-sm w-full p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Konfirmasi Hapus</h3>
            <p class="mb-6 text-gray-700 dark:text-gray-300">Apakah Anda yakin ingin menghapus item ini?</p>

            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeDeleteModal()"
                        class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 rounded bg-red-600 hover:bg-red-700 text-white font-semibold">
                        Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Script JavaScript --}}
    <script>
        function openDeleteModal(itemId) {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');
            form.action = `/keranjang/${itemId}`;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }
    </script>
</x-app-layout>
