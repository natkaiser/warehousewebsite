<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMasuk extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'stock_id',
        'supplier_id',
        'jumlah',
        'kualitas',
        'keterangan'
    ];

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}

