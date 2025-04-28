<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Produk') }}
        </h2>
    </x-slot>
    <div class="py-12 max-w-lg mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <form action="{{ route('produk.update', $produk) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="nama_produk" class="block text-gray-700 dark:text-gray-300 font-semibold mb-1">Nama
                        Produk</label>
                    <input type="text" name="nama_produk" id="nama_produk" required autofocus
                        value="{{ old('nama_produk', $produk->nama_produk) }}"
                        class="w-full rounded gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 @error('nama_produk') border-red-500 @enderror">
                    @error('nama_produk')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="kategori_id"
                        class="block text-gray-700 dark:text-gray-300 font-semibold mb-1">Kategori</label>
                    <select name="kategori_id" id="kategori_id" required
                        class="w-full rounded gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 @error('kategori_id') border-red-500 @enderror">
                        <option value="">Pilih Kategori</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}"
                                {{ old('kategori_id', $produk->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="harga"
                        class="block text-gray-700 dark:text-gray-300 font-semibold mb-1">Harga</label>
                    <input type="text" name="harga" id="harga" required
                        value="{{ old('harga', $produk->harga) }}"
                        placeholder="Masukkan harga (contoh: 15000 atau 15000.50)"
                        class="w-full rounded gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 @error('harga') border-red-500 @enderror"
                        oninput="this.value = this.value.replace(/[^0-9.]/g, '')" />
                    @error('harga')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="kuantitas"
                        class="block text-gray-700 dark:text-gray-300 font-semibold mb-1">Stok</label>
                    <input type="text" name="kuantitas" id="kuantitas" required
                        value="{{ old('kuantitas', $produk->kuantitas) }}" placeholder="Masukkan jumlah stok"
                        class="w-full rounded gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 @error('kuantitas') border-red-500 @enderror"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')" />
                    @error('kuantitas')
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
