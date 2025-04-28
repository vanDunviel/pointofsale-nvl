<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Riwayat Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <strong class="font-bold">Sukses! </strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <strong class="font-bold">Gagal! </strong>
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">       
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th
                                    class="px-6 py-3 bg-gray-50 dark:bg-gray-900 text-left text-s leading-4 font-blod text-blue-800 dark:text-gray-300 uppercase tracking-wider">
                                        Tanggal Transaksi
                                    </th>
                                    <th
                                    class="px-6 py-3 bg-gray-50 dark:bg-gray-900 text-left text-s leading-4 font-blod text-blue-800 dark:text-gray-300 uppercase tracking-wider">
                                        Item Belanja
                                    </th>
                                    <th
                                    class="px-6 py-3 bg-gray-50 dark:bg-gray-900 text-left text-s leading-4 font-blod text-blue-800 dark:text-gray-300 uppercase tracking-wider">
                                        Detail
                                    </th>
                                    <th
                                    class="px-6 py-3 bg-gray-50 dark:bg-gray-900 text-left text-s leading-4 font-blod text-blue-800 dark:text-gray-300 uppercase tracking-wider">
                                        Total Harga
                                    </th>
                                    <th
                                    class="px-6 py-3 bg-gray-50 dark:bg-gray-900 text-left text-s leading-4 font-blod text-blue-800 dark:text-gray-300 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($transaksis as $transaksi)
                                    <tr>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                            {{ $transaksi->created_at }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-left text-gray-500 dark:text-gray-300">
                                            {{ $transaksi->total_item }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                            @foreach ($transaksi->items as $item)
                                                <div>{{ $item->produk->nama_produk }} (x{{ $item->jumlah }})</div>
                                            @endforeach
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                            Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300 flex items-center space-x-3">

                                            <a href="{{ route('transaksi.show', $transaksi) }}"
                                                class="text-white-700 hover:text-white-900 mr-2" title="Lihat">
                                                <!-- Eye icon -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline"
                                                    fill="none" viewBox="0 0 24 24" stroke="blue"
                                                    stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>

                                            <form action="{{ route('transaksi.destroy', $transaksi) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="openDeleteModal({{ $transaksi->id }})"
                                                class="px-1 py-1 rounded-sm bg-red-500 text-white hover:bg-red-900" title="Hapus">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                        stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M19 7L5 7M6 7l1 12a2 2 0 002 2h6a2 2 0 002-2l1-12M10 11v6M14 11v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300"
                                            colspan="2">
                                            Belum ada data transaksi.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Delete -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 items-center justify-center hidden z-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg max-w-sm w-full p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Konfirmasi Hapus</h3>
            <p class="mb-6 text-gray-700 dark:text-gray-300">Apakah Anda yakin ingin menghapus transaksi ini?</p>

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
        function openDeleteModal(transaksiId) {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');
            form.action = `/transaksi/${transaksiId}`;
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
