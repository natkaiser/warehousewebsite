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
    private function generateNoFormTahunan(): string
    {
        $tahunSekarang = now()->year;
        $nomorUrut = StockMasuk::whereYear('tanggal', $tahunSekarang)->count() + 1;

        return sprintf('GIN/%d/%04d', $tahunSekarang, $nomorUrut);
    }

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

        return redirect()->back()->with('success', 'Stock in recorded successfully and inventory updated.');
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

        $supplierForm = trim((string) $request->supplier);
        if ($supplierForm === '') {
            if ($history->count() > 0) {
                $daftarSupplier = $history->pluck('supplier.nama')->filter()->unique()->values();
                $supplierForm = $daftarSupplier->count() === 1 ? (string) $daftarSupplier->first() : 'Multiple Supplier';
            } else {
                $supplierForm = '-';
            }
        }

        $tanggalForm = $request->filled('tanggal')
            ? \Carbon\Carbon::parse($request->tanggal)->format('d-m-Y')
            : now()->format('d-m-Y');

        $pdf = Pdf::loadView('pdf.stock_masuk', [
            'isForm' => true,
            'history' => $history,
            'noForm' => $this->generateNoFormTahunan(),
            'tanggalForm' => $tanggalForm,
            'supplierForm' => $supplierForm,
        ])->setPaper('a4', 'portrait');

        $filename = 'Stock_Masuk_' . date('Y-m-d_His') . '.pdf';
        return $pdf->download($filename);
    }

    public function formPenerimaanBarang()
    {
        $pdf = Pdf::loadView('pdf.stock_masuk', [
            'isForm' => true,
            'noForm' => $this->generateNoFormTahunan(),
            'tanggalForm' => now()->format('d-m-Y'),
            'supplierForm' => '-',
        ])
                   ->setPaper('a4', 'portrait');

        $filename = 'Form_Penerimaan_Barang_' . date('Y-m-d_His') . '.pdf';
        return $pdf->download($filename);
    }
}
