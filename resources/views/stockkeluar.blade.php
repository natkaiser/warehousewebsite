@extends('layouts.app')

@section('header_title', 'Barang Keluar')

@section('content')

{{-- DATA DUMMY: Riwayat Transaksi Keluar --}}
@php
    $dummyOutHistory = [
        (object)['tanggal' => '06/02/2026', 'kode_barang' => 'BRG-001', 'nama_barang' => 'Aqua', 'customer' => 'Toko Sejahtera', 'jumlah' => 20, 'keterangan' => 'Pesanan Rutin'],
        (object)['tanggal' => '06/02/2026', 'kode_barang' => 'BRG-003', 'nama_barang' => 'Switch Hub 24 Port', 'customer' => 'PT. Teknologi Maju', 'jumlah' => 1, 'keterangan' => 'Instalasi Kantor'],
    ];

    // Dummy untuk pilihan barang dari Master
    $masterBarang = [
        (object)['id' => 1, 'kode' => 'BRG-001', 'nama' => 'Aqua', 'stok' => 80],
        (object)['id' => 3, 'kode' => 'BRG-003', 'nama' => 'Switch Hub 24 Port', 'stok' => 5],
    ];
@endphp

<div class="space-y-6">
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center gap-2 mb-6">
            <div class="bg-orange-100 p-2 rounded-lg text-orange-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800">Input Barang Keluar</h3>
        </div>

        <form action="#" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">Tanggal</label>
                    <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-100 focus:border-orange-400 outline-none transition text-sm">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">Pilih Barang</label>
                    <select name="barang_id" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-100 focus:border-orange-400 outline-none transition text-sm">
                        <option value="">-- Pilih Barang --</option>
                        @foreach($masterBarang as $b)
                            <option value="{{ $b->id }}">{{ $b->kode }} - {{ $b->nama }} (Sisa: {{ $b->stok }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">Customer</label>
                    <select name="customer" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-100 focus:border-orange-400 outline-none transition text-sm">
                        <option value="">-- Pilih Customer --</option>
                        <option value="1">Toko Sejahtera</option>
                        <option value="2">PT. Teknologi Maju</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">Jumlah Keluar</label>
                    <input type="number" name="jumlah" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-100 focus:border-orange-400 outline-none transition text-sm" placeholder="0">
                </div>
            </div>

            <div class="mt-4">
                <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">Keterangan</label>
                <textarea name="keterangan" rows="2" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-100 focus:border-orange-400 outline-none transition text-sm" placeholder="Contoh: Kirim via JNE / Diambil sendiri"></textarea>
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg text-sm font-semibold transition shadow-md shadow-orange-100">
                    Simpan Barang Keluar
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50 flex justify-between items-center bg-white">
            <div class="flex items-center gap-2">
                <span class="text-xl">📄</span>
                <h3 class="text-lg font-bold text-slate-800">Riwayat Barang Keluar</h3>
            </div>
            <button class="flex items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Export Excel
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-orange-50 text-orange-800 text-xs uppercase tracking-widest font-bold">
                    <tr>
                        <th class="px-6 py-4 border-b border-orange-100">No</th>
                        <th class="px-6 py-4 border-b border-orange-100">Tanggal</th>
                        <th class="px-6 py-4 border-b border-orange-100">Kode Barang</th>
                        <th class="px-6 py-4 border-b border-orange-100">Nama Barang</th>
                        <th class="px-6 py-4 border-b border-orange-100">Customer</th>
                        <th class="px-6 py-4 border-b border-orange-100 text-center">Jumlah</th>
                        <th class="px-6 py-4 border-b border-orange-100">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($dummyOutHistory as $index => $item)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm font-bold text-gray-500">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 text-sm font-bold text-gray-600">{{ $item->tanggal }}</td>
                        <td class="px-6 py-4 text-sm font-bold text-gray-700">{{ $item->kode_barang }}</td>
                        <td class="px-6 py-4 text-sm font-bold text-slate-800">{{ $item->nama_barang }}</td>
                        <td class="px-6 py-4 text-sm font-bold text-gray-600">{{ $item->customer }}</td>
                        <td class="px-6 py-4 text-sm font-bold text-center"> {{ $item->jumlah }}</td>
                        <td class="px-6 py-4 text-sm font-bold text-gray-500 italic">{{ $item->keterangan }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-400">Belum ada riwayat barang keluar</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection