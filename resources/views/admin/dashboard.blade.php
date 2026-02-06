@extends('layouts.app')

@section('header_title', 'Dashboard Admin')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h1 class="text-2xl font-bold text-slate-800">Selamat Datang di Dashboard Admin</h1>
        <p class="text-gray-600 mt-2">Kelola stok, supplier, customer, dan transaksi barang masuk/keluar.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <a href="{{ route('stock.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white p-6 rounded-xl shadow-sm transition">
            <h3 class="text-lg font-semibold">Stok Barang</h3>
            <p>Kelola master data barang</p>
        </a>
        <a href="{{ route('stockmasuk.index') }}" class="bg-green-500 hover:bg-green-600 text-white p-6 rounded-xl shadow-sm transition">
            <h3 class="text-lg font-semibold">Barang Masuk</h3>
            <p>Input dan lihat riwayat barang masuk</p>
        </a>
        <a href="{{ route('stockkeluar.index') }}" class="bg-red-500 hover:bg-red-600 text-white p-6 rounded-xl shadow-sm transition">
            <h3 class="text-lg font-semibold">Barang Keluar</h3>
            <p>Input dan lihat riwayat barang keluar</p>
        </a>
        <a href="{{ route('supplier.index') }}" class="bg-purple-500 hover:bg-purple-600 text-white p-6 rounded-xl shadow-sm transition">
            <h3 class="text-lg font-semibold">Supplier</h3>
            <p>Kelola data supplier</p>
        </a>
        <a href="{{ route('customer.index') }}" class="bg-indigo-500 hover:bg-indigo-600 text-white p-6 rounded-xl shadow-sm transition">
            <h3 class="text-lg font-semibold">Customer</h3>
            <p>Kelola data customer</p>
        </a>
    </div>
</div>
@endsection
