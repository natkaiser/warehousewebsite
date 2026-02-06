<?php

namespace App\Http\Controllers;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        
        $query = Supplier::oldest();
        
        if ($search) {
            $query->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('alamat', 'like', '%' . $search . '%')
                  ->orWhere('telepon', 'like', '%' . $search . '%');
        }
        
        $suppliers = $query->get();
        return view('supplier', compact('suppliers', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
        ]);

        Supplier::create($request->all());

        return back()->with('success', 'Supplier ditambahkan');
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
        ]);

        $supplier->update($request->all());

        return back()->with('success', 'Supplier diperbarui');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return back()->with('success', 'Supplier dihapus');
    }

    public function exportPdf(Request $request)
    {
        $search = $request->input('search', '');
        
        $query = Supplier::oldest();
        
        if ($search) {
            $query->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('alamat', 'like', '%' . $search . '%')
                  ->orWhere('telepon', 'like', '%' . $search . '%');
        }
        
        $suppliers = $query->get();
        
        $pdf = Pdf::loadView('pdf.supplier', ['suppliers' => $suppliers])
                  ->setPaper('a4')
                  ->setOption('margin-top', 10)
                  ->setOption('margin-bottom', 10)
                  ->setOption('margin-left', 10)
                  ->setOption('margin-right', 10);
        
        return $pdf->download('daftar-supplier-' . date('Y-m-d') . '.pdf');
    }
}
