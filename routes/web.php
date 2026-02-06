<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StockMasukController;
use App\Http\Controllers\SupplierController;

Route::get('/', function () {
    return view('index');
});


Route::get('/stock', [StockController::class, 'index'])->name('stock.index');
Route::get('/stock/export', [StockController::class, 'export'])->name('stock.export');
Route::post('/stock', [StockController::class, 'store'])->name('stock.store');
Route::put('/stock/{stock}', [StockController::class, 'update'])->name('stock.update');
Route::delete('/stock/{stock}', [StockController::class, 'destroy'])->name('stock.destroy');


Route::get('/stock-masuk', [StockMasukController::class, 'index'])->name('stockmasuk.index');
Route::get('/stock-masuk/export/pdf', [StockMasukController::class, 'exportPdf'])->name('stockmasuk.export.pdf');
Route::post('/stock-masuk', [StockMasukController::class, 'store'])->name('stockmasuk.store');

// Compatibility route: some links use /stockmasuk (no dash)
Route::get('/stockmasuk', function () {
    return redirect()->route('stockmasuk.index');
});

Route::get('/stockkeluar', function () {
    return view('stockkeluar');
});

Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier.index');
Route::get('/supplier/export/pdf', [SupplierController::class, 'exportPdf'])->name('supplier.export.pdf');
Route::post('/supplier', [SupplierController::class, 'store'])->name('supplier.store');
Route::put('/supplier/{supplier}', [SupplierController::class, 'update'])->name('supplier.update');
Route::delete('/supplier/{supplier}', [SupplierController::class, 'destroy'])->name('supplier.destroy');
