<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        table, th, td {
            border: 1px solid #ccc;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px 12px;
            text-align: left;
        }
        th {
            background-color: #f8fafc;
        }
    </style>
</head>

<body style="font-family: 'Poppins', sans-serif;" class="antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <main>
            <div class="py-12 max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Transaksi pada
                        {{ $transaksi->created_at }}
                    </h3>

                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th>Nama Produk</th>
                                <th>Harga Satuan</th>
                                <th>Jumlah</th>
                                <th>Harga Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($transaksi->items as $item)
                                <tr>
                                    <td>{{ $item->produk->nama_produk }}</td>
                                    <td>Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</td>
                                    <td>{{ $item->jumlah }}</td>
                                    <td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada data item.</td>
                                </tr>
                            @endforelse
                            
                            <!-- Garis pemisah -->
                            <tr>
                                <td colspan="4" style="height:10px; background-color:#f1f5f9;"></td>
                            </tr>

                            <tr>
                                <td colspan="3" class="font-bold">Total</td>
                                <td>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="font-bold">Total Bayar</td>
                                <td>Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="font-bold">Kembalian</td>
                                <td>Rp {{ number_format($transaksi->total_bayar - $transaksi->total_harga, 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </main>
    </div>
</body>

</html>
