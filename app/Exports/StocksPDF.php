<?php

namespace App\Exports;

use App\Models\Stock;

class StocksPDF
{
    private $stocks;

    public function __construct($stocks = null)
    {
        $this->stocks = $stocks;
    }

    public function generate()
    {
        $stocks = $this->stocks ?? Stock::all();
        
        $data = [
            'stocks' => $stocks,
            'tanggal' => now()->format('d/m/Y H:i'),
            'total_items' => $stocks->count(),
        ];

        return $data;
    }
}
