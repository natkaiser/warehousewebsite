@extends('layouts.app')

@section('header_title', 'Barang Masuk')

@section('content')

{{-- DATA DUMMY: Riwayat Transaksi --}}
@php
    $dummyHistory = [
        (object)['tanggal' => '06/02/2026', 'kode_barang' => 'BRG-001', 'nama_barang' => 'Aqua', 'supplier' => 'PT. Sumber Air', 'jumlah' => 100, 'keterangan' => 'Restock Mingguan'],
        (object)['tanggal' => '05/02/2026', 'kode_barang' => 'BRG-002', 'nama_barang' => 'Chitato', 'supplier' => 'Indofood', 'jumlah' => 50, 'keterangan' => 'Barang Promo'],
    ];

    // Dummy untuk pilihan di dropdown
    $masterBarang = [
        (object)['id' => 1, 'kode' => 'BRG-001', 'nama' => 'Aqua'],
        (object)['id' => 2, 'kode' => 'BRG-002', 'nama' => 'Chitato'],
    ];
@endphp

<div class="space-y-6">
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center gap-2 mb-6">
            <div class="bg-indigo-100 p-2 rounded-lg text-indigo-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800">Input Barang Masuk</h3>
        </div>

        <form action="#" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">Tanggal</label>
                    <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 outline-none transition text-sm">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">Pilih Barang</label>
                    <select name="barang_id" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 outline-none transition text-sm">
                        <option value="">-- Pilih Barang --</option>
                        @foreach($masterBarang as $b)
                            <option value="{{ $b->id }}">{{ $b->kode }} - {{ $b->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">Supplier</label>
                    <select name="supplier" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 outline-none transition text-sm">
                        <option value="">-- Pilih Supplier --</option>
                        <option value="1">PT. Sumber Air</option>
                        <option value="2">Indofood</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">Jumlah Masuk</label>
                    <input type="number" name="jumlah" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 outline-none transition text-sm" placeholder="0">
                </div>
            </div>

            <div class="mt-4">
                <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">Keterangan</label>
                <textarea name="keterangan" rows="2" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 outline-none transition text-sm" placeholder="Opsional (Contoh: Restock gudang B)"></textarea>
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg text-sm font-semibold transition shadow-md shadow-indigo-100">
                    Simpan Barang Masuk
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50 flex justify-between items-center bg-white">
            <div class="flex items-center gap-2">
                <span class="text-xl">📋</span>
                <h3 class="text-lg font-bold text-slate-800">Riwayat Barang Masuk</h3>
            </div>
            <button class="flex items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export Excel
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-indigo-50 text-indigo-800 text-xs uppercase tracking-widest font-bold">
                    <tr>
                        <th class="px-6 py-4 border-b border-indigo-100">No</th>
                        <th class="px-6 py-4 border-b border-indigo-100">Tanggal</th>
                        <th class="px-6 py-4 border-b border-indigo-100">Kode Barang</th>
                        <th class="px-6 py-4 border-b border-indigo-100">Nama Barang</th>
                        <th class="px-6 py-4 border-b border-indigo-100">Supplier</th>
                        <th class="px-6 py-4 border-b border-indigo-100 text-center">Jumlah</th>
                        <th class="px-6 py-4 border-b border-indigo-100">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($dummyHistory as $index => $item)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm font-bold text-gray-500">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 text-sm font-bold text-gray-600">{{ $item->tanggal }}</td>
                        <td class="px-6 py-4 text-sm font-bold text-slate-600">{{ $item->kode_barang }}</td>
                        <td class="px-6 py-4 text-sm font-bold text-slate-800">{{ $item->nama_barang }}</td>
                        <td class="px-6 py-4 text-sm font-bold text-gray-600">{{ $item->supplier }}</td>
                        <td class="px-6 py-4 text-sm font-bold text-center text-slate-600">{{ $item->jumlah }}</td>
                        <td class="px-6 py-4 text-sm font-bold text-gray-500 italic">{{ $item->keterangan }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-400">Belum ada riwayat barang masuk</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection