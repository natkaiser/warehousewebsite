@extends('layouts.app')

@section('header_title', 'Dashboard Management')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-4">Total Barang</h3>
            <p class="text-3xl font-bold">1,250</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-4">Barang Masuk Hari Ini</h3>
            <p class="text-3xl font-bold">150</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-4">Barang Keluar Hari Ini</h3>
            <p class="text-3xl font-bold">75</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-4">Stok Rendah</h3>
            <p class="text-3xl font-bold">20</p>
        </div>

@endsection
