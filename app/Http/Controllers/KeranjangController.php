<?php

namespace App\Http\Controllers;

use App\Models\ItemKeranjang;
use App\Models\ItemTransaksi;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produks=Produk::all();
        $items = ItemKeranjang::with('produk')->get()->map(function ($item) {
            $item->total_harga = $item->produk->harga * $item->jumlah;
            return $item;
        });

        $total_belanja = $items->sum('total_harga');

        return view('keranjang.index', [
            'produks' => $produks,
            'items' => $items,
            'total_belanja' => $total_belanja,
        ]);
    }

    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'pay_total' => 'required|numeric|min:0',
        ]);

        $items = ItemKeranjang::with('produk')->get()->map(function ($item) {
            $item->total_harga = $item->produk->harga * $item->jumlah;
            return $item;
        });

        if ($items->isEmpty()) {
            return redirect()->route('keranjang.index')->with('error', 'Keranjang masih kosong.');
        }

        if ($validated['pay_total'] < $items->sum('total_harga')) {
            return redirect()->back()->with('error', 'Jumlah pembayaran belum cukup.');
        }

        $transaksi = Transaksi::create([
            'total_harga' => $items->sum('total_harga'),
            'total_bayar' => $validated['pay_total'],
        ]);

        foreach ($items as $item) {
            ItemTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'produk_id' => $item->produk_id,
                'jumlah' => $item->jumlah,
                'total_harga' => $item->total_harga,
            ]);

            $item->produk()->update([
                'kuantitas' => $item->produk->kuantitas - $item->jumlah,
            ]);
        }

        ItemKeranjang::truncate();

        return redirect()->route('transaksi.show', $transaksi)->with('success', 'Transaksi berhasil dilakukan.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $produks = Produk::all(['id', 'nama_produk', 'kuantitas'])->map(function ($produk) {
            $totalInKeranjang = ItemKeranjang::where('produk_id', $produk->id)->sum('jumlah');

            $produk->tersedia = $produk->kuantitas - $totalInKeranjang;

            return $produk;
        });

        return view('keranjang.create', compact('produks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'produk_id' => ['required', 'exists:produks,id'],
            'jumlah' => ['required', 'integer', 'min:1', function ($attribute, $value, $fail) use ($request) {
                $produk = Produk::find($request->produk_id);
                $itemKeranjang = ItemKeranjang::where('produk_id', $request->produk_id)->first();
                $currentJumlah = $itemKeranjang ? $itemKeranjang->jumlah : 0;

                if ($value + $currentJumlah > $produk->kuantitas) {
                    return $fail('Jumlah produk melebihi stok yang tersedia.');
                }
            }],
        ], [
            'nama_produk.required' => 'Nama produk harus diisi.',
            'jumlah.required' => 'Jumlah produk harus diisi.',
            'jumlah.min' => 'Jumlah produk tidak boleh kurang dari 1.',
        ]);

        $item = ItemKeranjang::where('produk_id', $validated['produk_id'])->first();
        if ($item) {
            $item->jumlah += $validated['jumlah'];
            $item->save();
            return redirect()->route('keranjang.index')->with('success', 'Produk berhasil ditambahkan.');
        }

        ItemKeranjang::create($validated);
        return redirect()->route('keranjang.index')->with('success', 'Produk berhasil dimasukkan.');
    }

    /**
 * Update the specified resource in storage.
 */
public function update(Request $request, ItemKeranjang $item)
{
    $request->validate([
        'quantity' => 'required|integer|min:1'
    ]);

    $produk = $item->produk;
    
    // Calculate total of this product already in cart (including other cart items)
    $currentInCart = ItemKeranjang::where('produk_id', $produk->id)
                     ->where('id', '!=', $item->id)
                     ->sum('jumlah');

    $newQuantity = $request->quantity;

    // Check if quantity exceeds available stock
    if ($newQuantity > ($produk->kuantitas - $currentInCart)) {
        return back()->with('error', 'Stok tidak mencukupi. Stok tersedia: '.($produk->kuantitas - $currentInCart));
    }

    // If quantity is 0, remove item
    if ($newQuantity < 1) {
        $item->delete();
        return back()->with('success', 'Item dihapus dari keranjang');
    }

    // Update quantity
    $item->jumlah = $newQuantity;
    $item->save();

    return back()->with('success', 'Jumlah produk diperbarui');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemKeranjang $item)
    {
        $item->delete();
        return redirect()->route('keranjang.index')->with('success', 'Item keranjang berhasil dihapus.');
    }
}
