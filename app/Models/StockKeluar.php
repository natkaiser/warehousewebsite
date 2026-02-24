<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockKeluar extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'stock_id',
        'customer_id',
        'jumlah',
        'kualitas',
        'keterangan'
    ];

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
