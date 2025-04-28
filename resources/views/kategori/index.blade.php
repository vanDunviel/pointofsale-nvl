<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Kategori') }}
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

                    <a href="{{ route('kategori.create') }}"
                        class="inline-block bg-blue-700 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded mb-4">
                        Tambah Kategori
                    </a>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th
                                        class="px-6 py-3 bg-gray-50 dark:bg-gray-900 text-left text-s leading-4 font-blod text-blue-800 dark:text-gray-300 uppercase tracking-wider">
                                        Nama Kategori
                                    </th>
                                    <th
                                        class="px-6 py-3 bg-gray-50 dark:bg-gray-900 text-left text-s leading-4 font-bold text-blue-800 dark:text-gray-300 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($kategoris as $kategori)
                                    <tr>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                            {{ $kategori->nama_kategori }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300 flex items-center space-x-3">

                                            <!-- Icon Edit (Pencil icon) -->
                                            <a href="{{ route('kategori.edit', $kategori) }}"
                                            class="px-1 py-1 rounded-sm bg-indigo-500 text-white hover:bg-indigo-900" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M16.862 3.487a2.121 2.121 0 012.999 2.998L7.5 18.847 3 19.5l.653-4.5 12.209-12.513z" />
                                                </svg>
                                            </a>

                                            <!-- Icon Hapus (Trash icon) -->
                                            <form action="{{ route('kategori.destroy', $kategori) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="openDeleteModal({{ $kategori->id }})"
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
                                            Belum ada data kategori.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $kategoris->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Delete -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 items-center justify-center hidden z-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg max-w-sm w-full p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Konfirmasi Hapus</h3>
            <p class="mb-6 text-gray-700 dark:text-gray-300">Apakah Anda yakin ingin menghapus kategori ini?</p>

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
        function openDeleteModal(kategoriId) {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');
            form.action = `/kategori/${kategoriId}`;
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
