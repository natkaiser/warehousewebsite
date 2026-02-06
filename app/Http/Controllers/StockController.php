<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Exports\StocksExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        
        $query = Stock::latest();
        
        if ($search) {
            $query->where('nama_barang', 'like', '%' . $search . '%')
                  ->orWhere('kode_barang', 'like', '%' . $search . '%')
                  ->orWhere('spesifikasi', 'like', '%' . $search . '%');
        }
        
        $stocks = $query->get();
        return view('stock', compact('stocks', 'search'));
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

    public function export(Request $request)
    {
        $search = $request->input('search', '');
        $filename = 'Stock_Barang_' . date('d-m-Y_H-i-s') . '.xlsx';

        $query = Stock::latest();
        
        if ($search) {
            $query->where('nama_barang', 'like', '%' . $search . '%')
                  ->orWhere('kode_barang', 'like', '%' . $search . '%')
                  ->orWhere('spesifikasi', 'like', '%' . $search . '%');
        }

        $stocks = $query->get();

        return Excel::download(new StocksExport($stocks), $filename);
    }
}
