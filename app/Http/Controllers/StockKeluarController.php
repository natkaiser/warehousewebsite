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
            ->when($request->filled('search') && trim($request->search), function ($q) use ($request) {
                $search = trim($request->search);
                $q->where(function($query) use ($search) {
                    $query->whereHas('stock', function ($s) use ($search) {
                        $s->whereRaw('LOWER(nama_barang) LIKE LOWER(?)', ["%{$search}%"])
                          ->orWhereRaw('LOWER(kode_barang) LIKE LOWER(?)', ["%{$search}%"]);
                    })
                    ->orWhereHas('customer', function ($s) use ($search) {
                        $s->whereRaw('LOWER(nama) LIKE LOWER(?)', ["%{$search}%"]);
                    });
                });
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
            ->when($request->filled('search') && trim($request->search), function ($q) use ($request) {
                $search = trim($request->search);
                $q->where(function($query) use ($search) {
                    $query->whereHas('stock', function ($s) use ($search) {
                        $s->whereRaw('LOWER(nama_barang) LIKE LOWER(?)', ["%{$search}%"])
                          ->orWhereRaw('LOWER(kode_barang) LIKE LOWER(?)', ["%{$search}%"]);
                    })
                    ->orWhereHas('customer', function ($s) use ($search) {
                        $s->whereRaw('LOWER(nama) LIKE LOWER(?)', ["%{$search}%"]);
                    });
                });
            })
            ->latest()
            ->get();

        $pdf = Pdf::loadView('pdf.stock_keluar', ['history' => $history, 'search' => $request->search])
                   ->setPaper('a4', 'landscape');

        $filename = 'Stock_Keluar_' . date('Y-m-d_His') . '.pdf';
        return $pdf->download($filename);
    }
}
