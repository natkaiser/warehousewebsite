<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_barang',
        'nama_barang',
<<<<<<< HEAD
        'rack_id',
=======
        'rak',
>>>>>>> 24713998c3cd3e6207052a0e1ef97b3320ddf0b8
        'spesifikasi',
        'stok',
        'satuan',
    ];
}
