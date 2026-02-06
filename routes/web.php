<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/stock', function () {
    return view('stock');
});

Route::get('/stockmasuk', function () {
    return view('stockmasuk');
});

Route::get('/stockkeluar', function () {
    return view('stockkeluar');
});
