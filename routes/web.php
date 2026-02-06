<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SupplierController;

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

Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier.index');
Route::post('/supplier', [SupplierController::class, 'store'])->name('supplier.store');
Route::put('/supplier/{supplier}', [SupplierController::class, 'update'])->name('supplier.update');
Route::delete('/supplier/{supplier}', [SupplierController::class, 'destroy'])->name('supplier.destroy');
