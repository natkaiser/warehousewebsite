<?php

namespace App\Exports;

use App\Models\Customer;

class CustomersPDF
{
    private $customers;

    public function __construct($customers = null)
    {
        $this->customers = $customers;
    }

    public function generate()
    {
        $customers = $this->customers ?? Customer::all();

        return [
            'customers' => $customers,
            'tanggal' => now()->format('d/m/Y H:i'),
            'total_items' => $customers->count(),
        ];
    }
}
