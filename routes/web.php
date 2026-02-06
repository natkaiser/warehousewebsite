<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StockMasukController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StockKeluarController;
use App\Http\Controllers\CustomerController;

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
Route::get('/stockmasuk', function () {return redirect()->route('stockmasuk.index');});

Route::get('/stock-keluar', [StockKeluarController::class, 'index'])->name('stockkeluar.index');
Route::post('/stock-keluar', [StockKeluarController::class, 'store'])->name('stockkeluar.store');
Route::get('/stockkeluar', function () {
    return view('stockkeluar');
});

Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier.index');
Route::get('/supplier/export/pdf', [SupplierController::class, 'exportPdf'])->name('supplier.export.pdf');
Route::post('/supplier', [SupplierController::class, 'store'])->name('supplier.store');
Route::put('/supplier/{supplier}', [SupplierController::class, 'update'])->name('supplier.update');
Route::delete('/supplier/{supplier}', [SupplierController::class, 'destroy'])->name('supplier.destroy');

Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
Route::get('/customer/export/pdf', [CustomerController::class, 'exportPdf'])->name('customer.export.pdf');
Route::post('/customer', [CustomerController::class, 'store'])->name('customer.store');
Route::put('/customer/{customer}', [CustomerController::class, 'update'])->name('customer.update');
Route::delete('/customer/{customer}', [CustomerController::class, 'destroy'])->name('customer.destroy');
