<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Kategori') }}
        </h2>
    </x-slot>
    <div class="py-12 max-w-lg mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <form action="{{ route('kategori.update', $kategori) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="nama_kategori" class="block text-gray-700 dark:text-gray-300 font-semibold mb-1">Nama
                        Kategori</label>
                    <input type="text" name="nama_kategori" id="nama_kategori" required autofocus
                        value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                        class="w-full rounded gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 @error('nama_kategori') border-red-500 @enderror">
                    @error('nama_kategori')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('kategori.index') }}"
                        class="px-4 py-2 rounded bg-red-500 hover:bg-red-900 text-white font-semibold">Batal</a>
                    <button type="submit"
                        class="px-4 py-2 rounded bg-blue-600 hover:bg-blue-900 text-white font-semibold">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
