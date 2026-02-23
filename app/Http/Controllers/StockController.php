<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Exports\StocksExport;
use App\Exports\StocksPDF;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $query = Stock::latest();

        if ($request->filled('kode_barang') && trim($request->kode_barang)) {
            $kode_barang = trim($request->kode_barang);
            $query->whereRaw('LOWER(kode_barang) LIKE LOWER(?)', ["%{$kode_barang}%"]);
        }

        if ($request->filled('nama_barang') && trim($request->nama_barang)) {
            $nama_barang = trim($request->nama_barang);
            $query->whereRaw('LOWER(nama_barang) LIKE LOWER(?)', ["%{$nama_barang}%"]);
        }

        if ($request->filled('rak') && trim($request->rak)) {
            $rak = trim($request->rak);
            $query->whereRaw('LOWER(rak) LIKE LOWER(?)', ["%{$rak}%"]);
        }

        if ($request->filled('spesifikasi') && trim($request->spesifikasi)) {
            $spesifikasi = trim($request->spesifikasi);
            $query->whereRaw('LOWER(spesifikasi) LIKE LOWER(?)', ["%{$spesifikasi}%"]);
        }

        $stocks = $query->paginate(10);
        $search = $request->nama_barang;
        return view('stock', compact('stocks', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|unique:stocks,kode_barang',
            'nama_barang' => 'required',
            'rak' => 'nullable|string|max:100',
            'spesifikasi' => 'nullable',
            'satuan' => 'required',
        ]);

        Stock::create([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'rak' => $request->rak,
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
            'rak' => 'nullable|string|max:100',
            'spesifikasi' => 'nullable',
            'satuan' => 'required',
        ]);

        $stock->update([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'rak' => $request->rak,
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
        $filename = 'Stock_Barang_' . date('d-m-Y_H-i-s') . '.pdf';

        $query = Stock::latest();

        if ($request->filled('kode_barang') && trim($request->kode_barang)) {
            $kode_barang = trim($request->kode_barang);
            $query->whereRaw('LOWER(kode_barang) LIKE LOWER(?)', ["%{$kode_barang}%"]);
        }

        if ($request->filled('nama_barang') && trim($request->nama_barang)) {
            $nama_barang = trim($request->nama_barang);
            $query->whereRaw('LOWER(nama_barang) LIKE LOWER(?)', ["%{$nama_barang}%"]);
        }

        if ($request->filled('rak') && trim($request->rak)) {
            $rak = trim($request->rak);
            $query->whereRaw('LOWER(rak) LIKE LOWER(?)', ["%{$rak}%"]);
        }

        if ($request->filled('spesifikasi') && trim($request->spesifikasi)) {
            $spesifikasi = trim($request->spesifikasi);
            $query->whereRaw('LOWER(spesifikasi) LIKE LOWER(?)', ["%{$spesifikasi}%"]);
        }

        $stocks = $query->get();

        $pdfData = new StocksPDF($stocks);
        $data = $pdfData->generate();

        $pdf = Pdf::loadView('pdf.stock-pdf', $data)
                  ->setPaper('a4', 'landscape');

        return $pdf->download($filename);
    }
}
