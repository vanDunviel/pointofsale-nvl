<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Transaksi;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jumlahTransaksi = Transaksi::count();
        $totalPendapatan = Transaksi::sum('total_harga');
        $totalStok = Produk::sum('kuantitas');
        
        // Get weekly sales data
        // $weeklySales = $this->getWeeklySalesData();

        return view('dashboard', compact(
            'jumlahTransaksi', 
            'totalPendapatan', 
            'totalStok',
            'weeklySales'
        ));
    }

    // protected function getWeeklySalesData()
    // {
    //     $startDate = Carbon::now()->subDays(6)->startOfDay();
    //     $endDate = Carbon::now()->endOfDay();
        
    //     $dates = [];
    //     $salesData = [];
        
    //     // Initialize with all days of the week, including days with no sales
    //     for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
    //         $dates[] = $date->format('D, M j');
            
    //         // Ensure we always return a numeric value (0 if no sales)
    //         $dailySales = Transaksi::whereDate('created_at', $date)
    //                         ->sum('total_harga');
    //         $salesData[] = $dailySales ?: 0;
    //     }
        
    //     return [
    //         'labels' => $dates,
    //         'data' => $salesData,
    //         'total_week' => array_sum($salesData) ?: 0 // Ensure total is never null
    //     ];
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
