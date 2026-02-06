@extends('layouts.app')

@section('header_title', 'Barang Masuk')

@section('content')

@php
    $dummyHistory = [
        (object)[
            'tanggal' => '2026-02-06',
            'kode_barang' => 'BRG-001',
            'nama_barang' => 'Aqua',
            'supplier' => 'PT. Sumber Air',
            'jumlah' => 100,
            'keterangan' => 'Restock Mingguan'
        ],
        (object)[
            'tanggal' => '2026-02-05',
            'kode_barang' => 'BRG-002',
            'nama_barang' => 'Chitato',
            'supplier' => 'Indofood',
            'jumlah' => 50,
            'keterangan' => 'Barang Promo'
        ],
    ];

    $masterBarang = [
        (object)['id' => 1, 'kode' => 'BRG-001', 'nama' => 'Aqua'],
        (object)['id' => 2, 'kode' => 'BRG-002', 'nama' => 'Chitato'],
    ];
@endphp

<div class="space-y-6">

    {{-- FORM BARANG MASUK --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center gap-2 mb-6">
            <div class="bg-purple-100 p-2 rounded-lg text-purple-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 tracking-tight">
                Input Barang Masuk
            </h3>
        </div>

        <form action="#" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">
                        Tanggal
                    </label>
                    <input type="date" value="{{ date('Y-m-d') }}"
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">
                        Barang
                    </label>
                    <select class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm">
                        <option value="">-- Pilih Barang --</option>
                        @foreach($masterBarang as $b)
                            <option>{{ $b->kode }} - {{ $b->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">
                        Supplier
                    </label>
                    <input type="text" placeholder="Nama supplier"
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">
                        Jumlah
                    </label>
                    <input type="number" placeholder="0"
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm">
                </div>
            </div>

            <div class="mt-4">
                <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">
                    Keterangan
                </label>
                <textarea rows="2" placeholder="Opsional"
                          class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm"></textarea>
            </div>

            <div class="mt-6">
                <button type="submit"
                        class="bg-indigo-500 hover:bg-indigo-600 text-white px-6 py-2 rounded-lg text-sm font-semibold transition">
                    Simpan Barang Masuk
                </button>
            </div>
        </form>
    </div>

    {{-- SEARCH BARANG MASUK --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <div class="bg-blue-100 p-2 rounded-lg text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800 tracking-tight">
                    Cari Barang Masuk
                </h3>
            </div>

            <button onclick="downloadExcel()" class="flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Export Excel
            </button>
        </div>

        <form action="#" method="GET" class="flex gap-3">
            <div class="flex-1">
                <input type="text"
                       placeholder="Cari berdasarkan nama barang, kode, atau supplier..."
                       class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <button type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg text-sm font-semibold transition">
                Cari
            </button>
        </form>
    </div>

    {{-- TABEL RIWAYAT --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-emerald-50 text-emerald-700 text-sm uppercase">
                <tr>
                    <th class="p-4">No</th>
                    <th class="p-4">Tanggal</th>
                    <th class="p-4">Kode</th>
                    <th class="p-4">Nama Barang</th>
                    <th class="p-4">Supplier</th>
                    <th class="p-4 text-right">Jumlah</th>
                    <th class="p-4">Keterangan</th>
                </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                @forelse($dummyHistory as $i => $row)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4 text-sm text-gray-600">{{ $i + 1 }}</td>
                        <td class="p-4 text-sm text-gray-600">{{ $row->tanggal }}</td>
                        <td class="p-4 text-sm font-mono text-slate-700">{{ $row->kode_barang }}</td>
                        <td class="p-4 text-sm font-medium text-slate-800">{{ $row->nama_barang }}</td>
                        <td class="p-4 text-sm text-slate-600">{{ $row->supplier }}</td>
                        <td class="p-4 text-sm font-bold text-right text-slate-800">{{ $row->jumlah }}</td>
                        <td class="p-4 text-sm text-gray-500 italic">{{ $row->keterangan }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-gray-400">
                            Belum ada data barang masuk
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
