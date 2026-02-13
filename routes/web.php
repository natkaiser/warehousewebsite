<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StockMasukController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StockKeluarController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AuthController;
use App\Models\Stock;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\StockMasuk;
use App\Models\StockKeluar;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', function () {
    $totalStocks = Stock::count();
    $totalSuppliers = Supplier::count();
    $totalCustomers = Customer::count();

    $currentMonth = now()->month;
    $currentYear = now()->year;
    $monthlyTransactions = StockMasuk::whereMonth('created_at', $currentMonth)
        ->whereYear('created_at', $currentYear)
        ->count() + StockKeluar::whereMonth('created_at', $currentMonth)
        ->whereYear('created_at', $currentYear)
        ->count();

    $totalStockMasuk = StockMasuk::count();
    $totalStockKeluar = StockKeluar::count();

    $monthName = now()->locale('id')->monthName . ' ' . $currentYear;

    // Fetch recent activities
    $recentStockMasuk = StockMasuk::with('stock', 'supplier')->latest()->take(1)->get()->map(function($item) {
        return [
            'type' => 'Barang Masuk',
            'message' => "Menambahkan {$item->jumlah} {$item->stock->satuan} \"{$item->stock->nama_barang}\" dari {$item->supplier->nama}",
            'time' => $item->created_at->diffForHumans(),
            'color' => 'green',
            'created_at' => $item->created_at
        ];
    });

    $recentStockKeluar = StockKeluar::with('stock', 'customer')->latest()->take(1)->get()->map(function($item) {
        return [
            'type' => 'Barang Keluar',
            'message' => "Pengeluaran {$item->jumlah} {$item->stock->satuan} \"{$item->stock->nama_barang}\" ke {$item->customer->nama}",
            'time' => $item->created_at->diffForHumans(),
            'color' => 'red',
            'created_at' => $item->created_at
        ];
    });

    $recentSuppliers = Supplier::latest()->take(1)->get()->map(function($item) {
        return [
            'type' => 'Supplier Baru',
            'message' => "Input Data Supplier \"{$item->nama}\"",
            'time' => $item->created_at->diffForHumans(),
            'color' => 'blue',
            'created_at' => $item->created_at
        ];
    });

    $recentCustomers = Customer::latest()->take(1)->get()->map(function($item) {
        return [
            'type' => 'Customer Baru',
            'message' => "Input Data Customer \"{$item->nama}\"",
            'time' => $item->created_at->diffForHumans(),
            'color' => 'emerald',
            'created_at' => $item->created_at
        ];
    });

    $recentStocks = Stock::latest()->take(1)->get()->map(function($item) {
        return [
            'type' => 'Stok Baru',
            'message' => "Input Data Barang \"{$item->nama_barang}\"",
            'time' => $item->created_at->diffForHumans(),
            'color' => 'purple',
            'created_at' => $item->created_at
        ];
    });

    $recentActivities = collect()
        ->merge($recentStockMasuk)
        ->merge($recentStockKeluar)
        ->merge($recentSuppliers)
        ->merge($recentCustomers)
        ->merge($recentStocks)
        ->sortByDesc('created_at')
        ->take(5);

    return view('index', compact('totalStocks', 'totalSuppliers', 'totalCustomers', 'monthlyTransactions', 'monthName', 'totalStockMasuk', 'totalStockKeluar', 'recentActivities'));
})->middleware('auth');


Route::middleware('auth')->group(function () {
    Route::get('/stock', [StockController::class, 'index'])->name('stock.index');
    Route::get('/stock/export', [StockController::class, 'export'])->name('stock.export');
    Route::post('/stock', [StockController::class, 'store'])->name('stock.store');
    Route::put('/stock/{stock}', [StockController::class, 'update'])->name('stock.update');
    Route::delete('/stock/{stock}', [StockController::class, 'destroy'])->name('stock.destroy');


Route::get('/stock-masuk', [StockMasukController::class, 'index'])->name('stockmasuk.index');
Route::get('/stock-masuk/export/pdf', [StockMasukController::class, 'exportPdf'])->name('stockmasuk.export.pdf');
Route::get('/stock-masuk/form-penerimaan', [StockMasukController::class, 'formPenerimaanBarang'])->name('stockmasuk.form.penerimaan');
Route::post('/stock-masuk', [StockMasukController::class, 'store'])->name('stockmasuk.store');
Route::get('/stockmasuk', function () {return redirect()->route('stockmasuk.index');});

Route::get('/stock-keluar', [StockKeluarController::class, 'index'])->name('stockkeluar.index');
Route::get('/stock-keluar/export/pdf', [StockKeluarController::class, 'exportPdf'])->name('stockkeluar.export.pdf');
Route::get('/stock-keluar/form-pengeluaran', [StockKeluarController::class, 'formPengeluaranBarang'])->name('stockkeluar.form.pengeluaran');
Route::post('/stock-keluar', [StockKeluarController::class, 'store'])->name('stockkeluar.store');
Route::get('/stockkeluar', [StockKeluarController::class, 'index']);

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
});
