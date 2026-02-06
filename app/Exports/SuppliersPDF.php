<?php

namespace App\Exports;

use App\Models\Supplier;

class SuppliersPDF
{
    private $suppliers;

    public function __construct($suppliers = null)
    {
        $this->suppliers = $suppliers;
    }

    public function generate()
    {
        $suppliers = $this->suppliers ?? Supplier::all();

        return [
            'suppliers' => $suppliers,
            'tanggal' => now()->format('d/m/Y H:i'),
            'total_items' => $suppliers->count(),
        ];
    }
}
