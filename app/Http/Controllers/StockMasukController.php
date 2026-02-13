<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Supplier;
use App\Models\StockMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class StockMasukController extends Controller
{
    public function index(Request $request)
    {
        $stocks = Stock::orderBy('nama_barang')->get();
        $suppliers = Supplier::orderBy('nama')->get();

        $history = StockMasuk::with(['stock', 'supplier'])
            ->when($request->filled('nama_barang') && trim($request->nama_barang), function ($q) use ($request) {
                $nama_barang = trim($request->nama_barang);
                $q->whereHas('stock', function ($s) use ($nama_barang) {
                    $s->whereRaw('LOWER(nama_barang) LIKE LOWER(?)', ["%{$nama_barang}%"])
                      ->orWhereRaw('LOWER(kode_barang) LIKE LOWER(?)', ["%{$nama_barang}%"]);
                });
            })
            ->when($request->filled('supplier') && trim($request->supplier), function ($q) use ($request) {
                $supplier = trim($request->supplier);
                $q->whereHas('supplier', function ($s) use ($supplier) {
                    $s->whereRaw('LOWER(nama) LIKE LOWER(?)', ["%{$supplier}%"]);
                });
            })
            ->when($request->filled('tanggal'), function ($q) use ($request) {
                $q->where('tanggal', $request->tanggal);
            })
            ->latest()
            ->paginate(10);

        return view('stockmasuk', compact('stocks', 'suppliers', 'history'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'stock_id' => 'required|exists:stocks,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'jumlah' => 'required|integer|min:1',
            'kualitas' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request) {

            // 1️⃣ simpan history barang masuk
            StockMasuk::create($request->all());

            // 2️⃣ TAMBAH STOCK
            $stock = Stock::findOrFail($request->stock_id);
            $stock->stok += $request->jumlah;
            $stock->save();
        });

        return redirect()->back()->with('success', 'Barang masuk berhasil disimpan & stok bertambah');
    }

    public function exportPdf(Request $request)
    {
        $history = StockMasuk::with(['stock', 'supplier'])
            ->when($request->filled('nama_barang') && trim($request->nama_barang), function ($q) use ($request) {
                $nama_barang = trim($request->nama_barang);
                $q->whereHas('stock', function ($s) use ($nama_barang) {
                    $s->whereRaw('LOWER(nama_barang) LIKE LOWER(?)', ["%{$nama_barang}%"])
                      ->orWhereRaw('LOWER(kode_barang) LIKE LOWER(?)', ["%{$nama_barang}%"]);
                });
            })
            ->when($request->filled('supplier') && trim($request->supplier), function ($q) use ($request) {
                $supplier = trim($request->supplier);
                $q->whereHas('supplier', function ($s) use ($supplier) {
                    $s->whereRaw('LOWER(nama) LIKE LOWER(?)', ["%{$supplier}%"]);
                });
            })
            ->when($request->filled('tanggal'), function ($q) use ($request) {
                $q->where('tanggal', $request->tanggal);
            })
            ->latest()
            ->get();

        $pdf = Pdf::loadView('pdf.stock_masuk', [
            'history' => $history,
            'nama_barang' => $request->nama_barang,
            'supplier' => $request->supplier,
            'tanggal' => $request->tanggal
        ])->setPaper('a4', 'landscape');

        $filename = 'Stock_Masuk_' . date('Y-m-d_His') . '.pdf';
        return $pdf->download($filename);
    }

    public function formPenerimaanBarang()
    {
        $pdf = Pdf::loadView('pdf.stock_masuk', ['isForm' => true])
                   ->setPaper('a4', 'portrait');

        $filename = 'Form_Penerimaan_Barang_' . date('Y-m-d_His') . '.pdf';
        return $pdf->download($filename);
    }
}
