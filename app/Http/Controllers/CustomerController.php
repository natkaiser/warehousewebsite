<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use App\Exports\CustomersPDF;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $query = Customer::oldest();

        if ($search) {
            $query->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('alamat', 'like', '%' . $search . '%')
                  ->orWhere('telepon', 'like', '%' . $search . '%');
        }

        $customers = $query->paginate(10);
        return view('customer', compact('customers', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
        ]);

        Customer::create($request->all());

        return back()->with('success', 'Customer ditambahkan');
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
        ]);

        $customer->update($request->all());

        return back()->with('success', 'Customer diperbarui');
    }

    public function exportPdf(Request $request)
    {
        $search = $request->input('search', '');

        $query = Customer::latest();

        if ($search) {
            $query->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('alamat', 'like', '%' . $search . '%')
                  ->orWhere('telepon', 'like', '%' . $search . '%');
        }

        $customers = $query->get();

        $pdfData = new CustomersPDF($customers);
        $data = $pdfData->generate();

        $pdf = Pdf::loadView('pdf.customer-pdf', $data)
                  ->setPaper('a4');

        return $pdf->download('daftar-customer-' . date('d-m-Y_H-i-s') . '.pdf');
    }
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return back()->with('success', 'Customer dihapus');
    }
}
