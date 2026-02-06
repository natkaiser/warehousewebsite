<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::latest()->get();
        return view('stock', compact('stocks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|unique:stocks,kode_barang',
            'nama_barang' => 'required',
            'spesifikasi' => 'nullable',
            'satuan' => 'required',
        ]);

        Stock::create([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'spesifikasi' => $request->spesifikasi,
            'stok' => 0,
            'satuan' => $request->satuan,
        ]);

        return redirect()->back()->with('success', 'Barang berhasil ditambahkan');
    }

    public function update(Request $request, Stock $stock)
    {
        $request->validate([
            'kode_barang' => 'required|unique:stocks,kode_barang,' . $stock->id,
            'nama_barang' => 'required',
            'spesifikasi' => 'nullable',
            'satuan' => 'required',
        ]);

        $stock->update([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'spesifikasi' => $request->spesifikasi,
            'satuan' => $request->satuan,
        ]);

        return redirect()->back()->with('success', 'Barang berhasil diupdate');
    }

    public function destroy(Stock $stock)
    {
        $stock->delete();
        return redirect()->back()->with('success', 'Barang berhasil dihapus');
    }
}
