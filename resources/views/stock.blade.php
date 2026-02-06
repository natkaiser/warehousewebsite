@extends('layouts.app')

@section('header_title', 'Stock Barang')

@section('content')

{{-- DATA DUMMY: Baris ini hanya sementara agar tidak error --}}
@php
    $dummyStocks = [
        (object)['kode_barang' => 'BRG-001', 'nama_barang' => 'Aqua', 'Spesifikasi' => '350ml', 'stok' => 50, 'satuan' => 'Meter'],
        (object)['kode_barang' => 'BRG-002', 'nama_barang' => 'Chitato', 'Spesifikasi' => '300g', 'stok' => 5, 'satuan' => 'Unit'],
        (object)['kode_barang' => 'BRG-003', 'nama_barang' => 'Switch Hub 24 Port', 'Spesifikasi' => 'Jaringan', 'stok' => 2, 'satuan' => 'Pcs'],
        (object)['kode_barang' => 'BRG-004', 'nama_barang' => 'Solder Dekko', 'Spesifikasi' => 'Alat Bengkel', 'stok' => 15, 'satuan' => 'Pcs'],
    ];
@endphp
<div class="space-y-6">
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center gap-2 mb-6">
            <div class="bg-purple-100 p-2 rounded-lg text-purple-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 tracking-tight">Tambah Barang Baru</h3>
        </div>

        <form action="#" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">Kode Barang</label>
                    <input type="text" name="kode_barang" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-100 focus:border-purple-400 outline-none transition text-sm" placeholder="Contoh: BRG-001">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">Nama Barang</label>
                    <input type="text" name="nama_barang" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-100 focus:border-purple-400 outline-none transition text-sm" placeholder="Masukkan nama barang">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">Spesifikasi</label>
                    <input type="text" name="spesifikasi" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-100 focus:border-purple-400 outline-none transition text-sm" placeholder="Contoh: 350ml, 1kg, dll">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">Satuan</label>
                    <input type="text" name="satuan" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-100 focus:border-purple-400 outline-none transition text-sm" placeholder="Contoh: Pcs, Box, Kg, dll">
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white px-6 py-2 rounded-lg text-sm font-semibold transition shadow-md shadow-indigo-100">
                    Tambah Barang
                </button>
            </div>
        </form>
    </div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    
    <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
        
        <div class="w-full md:w-1/3 relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="text" 
                   class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out" 
                   placeholder="Cari nama barang atau kode...">
        </div>

        <div class="flex gap-2">
            <button class="flex items-center gap-2 bg-green-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-600 transition shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Export Excel
            </button>

            <button class="flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tambah Barang
            </button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-emerald-50 text-emerald-700 text-sm uppercase">
                <tr>
                    <th class="p-4 font-semibold border-b border-emerald-100">No</th>
                    <th class="p-4 font-semibold border-b border-emerald-100">Kode</th>
                    <th class="p-4 font-semibold border-b border-emerald-100">Nama Barang</th>
                    <th class="p-4 font-semibold border-b border-emerald-100">Spesifikasi</th>
                    <th class="p-4 font-semibold border-b border-emerald-100 text-right">Stok</th>
                    <th class="p-4 font-semibold border-b border-emerald-100">Satuan</th>
                    <th class="p-4 font-semibold border-b border-emerald-100 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($dummyStocks as $index => $item)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-4 text-sm text-gray-600">{{ $index + 1 }}</td>
                    <td class="p-4 text-sm font-mono text-slate-700">{{ $item->kode_barang }}</td>
                    <td class="p-4 text-sm font-medium text-slate-800">{{ $item->nama_barang }}</td>
                    <td class="p-4 text-sm text-slate-600">
                        <span class="px-2 py-1 bg-gray-100 rounded text-xs font-semibold text-gray-600">
                            {{ $item->Spesifikasi }}
                        </span>
                    </td>
                    <td class="p-4 text-sm font-bold text-slate-800 text-right">{{ $item->stok }}</td>
                    <td class="p-4 text-sm text-slate-500">{{ $item->satuan }}</td>
                    <td class="p-4 text-center">
                        <div class="flex justify-center gap-2">
                            <button class="text-blue-500 hover:text-blue-700 p-1 bg-blue-50 rounded">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>
                            <button class="text-red-500 hover:text-red-700 p-1 bg-red-50 rounded">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="p-4 border-t border-gray-100 bg-gray-50 flex justify-between items-center">
        <span class="text-sm text-gray-600">Showing 1 to 4 of 4 results</span>
        <div class="flex gap-1">
            <button class="px-3 py-1 border border-gray-300 rounded bg-white text-gray-500 cursor-not-allowed">Previous</button>
            <button class="px-3 py-1 border border-blue-600 rounded bg-blue-600 text-white">1</button>
            <button class="px-3 py-1 border border-gray-300 rounded bg-white text-gray-600 hover:bg-gray-50">Next</button>
        </div>
    </div>
</div>
@endsection