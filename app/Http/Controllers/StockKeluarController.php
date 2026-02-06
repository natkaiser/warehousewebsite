<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Customer;
use App\Models\StockKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockKeluarController extends Controller
{
    public function index(Request $request)
    {
        $stocks = Stock::orderBy('nama_barang')->get();
        $customers = Customer::orderBy('nama')->get();

        $history = StockKeluar::with(['stock', 'customer'])
            ->when($request->search, function ($q) use ($request) {
                $q->whereHas('stock', function ($s) use ($request) {
                    $s->where('nama_barang', 'like', "%{$request->search}%")
                      ->orWhere('kode_barang', 'like', "%{$request->search}%");
                })
                ->orWhereHas('customer', function ($c) use ($request) {
                    $c->where('nama', 'like', "%{$request->search}%");
                });
            })
            ->latest()
            ->get();

        return view('stockkeluar', compact('stocks', 'customers', 'history'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'stock_id' => 'required|exists:stocks,id',
            'customer_id' => 'required|exists:customers,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {

            $stock = Stock::lockForUpdate()->findOrFail($request->stock_id);

            // ❌ STOP JIKA STOK HABIS / KURANG
            if ($stock->stok <= 0) {
                abort(400, 'Stok habis');
            }

            if ($request->jumlah > $stock->stok) {
                abort(400, 'Jumlah melebihi stok tersedia');
            }

            // 1️⃣ SIMPAN BARANG KELUAR
            StockKeluar::create($request->all());

            // 2️⃣ KURANGI STOK
            $stock->stok -= $request->jumlah;
            $stock->save();
        });

        return redirect()->back()->with('success', 'Barang keluar berhasil & stok berkurang');
    }
}
