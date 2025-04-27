<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Dashboard') }}
                </h2>
                <p class="text-gray-600 dark:text-gray-400">Hai, {{ Auth::user()->name }}!</p>
            </div>
            <div class="text-right">
                <div class="text-lg font-semibold text-gray-700 dark:text-gray-300">
                    {{ \Carbon\Carbon::now()->format('d F Y') }}
                </div>
                <div class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ \Carbon\Carbon::now()->format('H:i') }}
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <!-- Metrics Grid -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow text-center">
                <div class="text-lg text-gray-600 dark:text-gray-300">Jumlah Transaksi</div>
                <div class="text-3xl font-bold text-blue-600 mt-2">{{ $jumlahTransaksi }}</div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow text-center">
                <div class="text-lg text-gray-600 dark:text-gray-300">Total Pendapatan</div>
                <div class="text-3xl font-bold text-green-500 mt-2">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow text-center">
                <div class="text-lg text-gray-600 dark:text-gray-300">Total Stok Produk</div>
                <div class="text-3xl font-bold text-yellow-500 mt-2">{{ $totalStok }}</div>
            </div>
        </div>

        <!-- Chart Section (Outside the metrics grid) -->
         <!--
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">
                    Penjualan Mingguan
                    @isset($weeklySales['total_week'])
                        <span class="text-sm font-normal text-gray-600 dark:text-gray-400">
                            (Total: Rp {{ number_format($weeklySales['total_week'], 0, ',', '.') }})
                        </span>
                    @endisset
                </h3>
                <div class="w-full h-80">
                    <canvas id="weeklySalesChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('weeklySalesChart');
            
            // Check if canvas exists and data is available
            if (ctx && @json(isset($weeklySales))) {
                new Chart(ctx.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: @json($weeklySales['labels'] ?? []),
                        datasets: [{
                            label: 'Total Penjualan (Rp)',
                            data: @json($weeklySales['data'] ?? []),
                            backgroundColor: 'rgba(59, 130, 246, 0.7)',
                            borderColor: 'rgba(59, 130, 246, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return 'Rp ' + value.toLocaleString('id-ID');
                                    }
                                }
                            }
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return 'Rp ' + context.raw.toLocaleString('id-ID');
                                    }
                                }
                            }
                        }
                    }
                });
            } else {
                console.error('Chart initialization failed: Missing canvas or data');
            }
        });
    </script>
    @endpush -->
</x-app-layout>