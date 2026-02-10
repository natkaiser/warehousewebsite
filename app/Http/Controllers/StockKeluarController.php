<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Stock;
use App\Models\StockKeluar;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class StockKeluarController extends Controller
{
    public function index(Request $request)
    {
        $masterBarang = Stock::where('stok', '>', 0)->get();
        $customers = Customer::all();

        $history = StockKeluar::with(['stock', 'customer'])
            ->when($request->filled('nama_barang') && trim($request->nama_barang), function ($q) use ($request) {
                $nama_barang = trim($request->nama_barang);
                $q->whereHas('stock', function ($s) use ($nama_barang) {
                    $s->whereRaw('LOWER(nama_barang) LIKE LOWER(?)', ["%{$nama_barang}%"])
                      ->orWhereRaw('LOWER(kode_barang) LIKE LOWER(?)', ["%{$nama_barang}%"]);
                });
            })
            ->when($request->filled('nama_customer') && trim($request->nama_customer), function ($q) use ($request) {
                $nama_customer = trim($request->nama_customer);
                $q->whereHas('customer', function ($s) use ($nama_customer) {
                    $s->whereRaw('LOWER(nama) LIKE LOWER(?)', ["%{$nama_customer}%"]);
                });
            })
            ->when($request->filled('tanggal'), function ($q) use ($request) {
                $q->where('tanggal', $request->tanggal);
            })
            ->latest()
            ->get();

        return view('stockkeluar', compact('history', 'masterBarang', 'customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'stock_id' => 'required|exists:stocks,id',
            'customer_id' => 'required|exists:customers,id',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ]);

        $stock = Stock::findOrFail($request->stock_id);

        if ($stock->stok < $request->jumlah) {
            return back()->withErrors(['jumlah' => 'Stok tidak mencukupi.']);
        }

        StockKeluar::create([
            'tanggal' => $request->tanggal,
            'stock_id' => $request->stock_id,
            'customer_id' => $request->customer_id,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
        ]);

        $stock->decrement('stok', $request->jumlah);

        return back()->with('success', 'Barang keluar berhasil ditambahkan.');
    }

    public function exportPdf(Request $request)
    {
        $history = StockKeluar::with(['stock', 'customer'])
            ->when($request->filled('nama_barang') && trim($request->nama_barang), function ($q) use ($request) {
                $nama_barang = trim($request->nama_barang);
                $q->whereHas('stock', function ($s) use ($nama_barang) {
                    $s->whereRaw('LOWER(nama_barang) LIKE LOWER(?)', ["%{$nama_barang}%"])
                      ->orWhereRaw('LOWER(kode_barang) LIKE LOWER(?)', ["%{$nama_barang}%"]);
                });
            })
            ->when($request->filled('nama_customer') && trim($request->nama_customer), function ($q) use ($request) {
                $nama_customer = trim($request->nama_customer);
                $q->whereHas('customer', function ($s) use ($nama_customer) {
                    $s->whereRaw('LOWER(nama) LIKE LOWER(?)', ["%{$nama_customer}%"]);
                });
            })
            ->when($request->filled('tanggal'), function ($q) use ($request) {
                $q->where('tanggal', $request->tanggal);
            })
            ->latest()
            ->get();

        $pdf = Pdf::loadView('pdf.stock_keluar', ['history' => $history, 'nama_barang' => $request->nama_barang, 'nama_customer' => $request->nama_customer, 'tanggal' => $request->tanggal])
                   ->setPaper('a4', 'landscape');

        $filename = 'Stock_Keluar_' . date('Y-m-d_His') . '.pdf';
        return $pdf->download($filename);
    }
}
