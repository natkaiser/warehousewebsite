<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;

Route::get('/', function () {
    return view('index');
});


Route::get('/stock', [StockController::class, 'index'])->name('stock.index');
Route::get('/stock/export', [StockController::class, 'export'])->name('stock.export');
Route::post('/stock', [StockController::class, 'store'])->name('stock.store');
Route::put('/stock/{stock}', [StockController::class, 'update'])->name('stock.update');
Route::delete('/stock/{stock}', [StockController::class, 'destroy'])->name('stock.destroy');


Route::get('/stockmasuk', function () {
    return view('stockmasuk');
});

Route::get('/stockkeluar', function () {
    return view('stockkeluar');
});

Route::get('/supplier', function () {
    return view('supplier');
});

