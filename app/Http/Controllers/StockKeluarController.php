<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Stock;
use App\Models\StockKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Barryvdh\DomPDF\Facade\Pdf;

class StockKeluarController extends Controller
{
    private function generateNoFormTahunan(): string
    {
        $tahunSekarang = now()->year;
        $nomorUrut = StockKeluar::whereYear('tanggal', $tahunSekarang)->count() + 1;

        return sprintf('GEX/%d/%04d', $tahunSekarang, $nomorUrut);
    }

    public function index(Request $request)
    {
        $masterBarang = Stock::orderBy('nama_barang')->get();
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
            ->paginate(10);

        $nama_barang = $request->filled('nama_barang') ? trim($request->nama_barang) : null;
        $nama_customer = $request->filled('nama_customer') ? trim($request->nama_customer) : null;
        $tanggal = $request->filled('tanggal') ? $request->tanggal : null;

        return view('stockkeluar', compact('history', 'masterBarang', 'customers', 'nama_barang', 'nama_customer', 'tanggal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'stock_id' => 'required|exists:stocks,id',
            'customer_id' => 'required|exists:customers,id',
            'jumlah' => 'required|integer|min:1',
            'kualitas' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $stock = Stock::findOrFail($request->stock_id);

        if ($stock->stok < $request->jumlah) {
            return back()->withErrors(['jumlah' => 'Insufficient stock.']);
        }

        $payload = [
            'tanggal' => $request->tanggal,
            'stock_id' => $request->stock_id,
            'customer_id' => $request->customer_id,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
        ];

        if (Schema::hasColumn('stock_keluars', 'kualitas')) {
            $payload['kualitas'] = $request->kualitas;
        }

        StockKeluar::create($payload);

        $stock->decrement('stok', $request->jumlah);

        return back()->with('success', 'Stock out recorded successfully.');
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

        $customerForm = trim((string) $request->nama_customer);
        if ($customerForm === '') {
            if ($history->count() > 0) {
                $daftarCustomer = $history->pluck('customer.nama')->filter()->unique()->values();
                $customerForm = $daftarCustomer->count() === 1 ? (string) $daftarCustomer->first() : 'Multiple Customer';
            } else {
                $customerForm = '-';
            }
        }

        $tanggalForm = $request->filled('tanggal')
            ? \Carbon\Carbon::parse($request->tanggal)->format('d-m-Y')
            : now()->format('d-m-Y');

        $pdf = Pdf::loadView('pdf.stock_keluar', [
            'isForm' => true,
            'history' => $history,
            'noForm' => $this->generateNoFormTahunan(),
            'tanggalForm' => $tanggalForm,
            'customerForm' => $customerForm,
        ])->setPaper('a4', 'portrait');

        $filename = 'Stock_Keluar_' . date('Y-m-d_His') . '.pdf';
        return $pdf->download($filename);
    }

    public function formPengeluaranBarang()
    {
        $pdf = Pdf::loadView('pdf.stock_keluar', [
            'isForm' => true,
            'noForm' => $this->generateNoFormTahunan(),
            'tanggalForm' => now()->format('d-m-Y'),
        ])
                   ->setPaper('a4', 'portrait');

        $filename = 'Form_Pengeluaran_Barang_' . date('Y-m-d_His') . '.pdf';
        return $pdf->download($filename);
    }
}
