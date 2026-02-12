@extends('layouts.app')

@section('header_title', 'Barang Masuk')

@section('content')

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

        <form action="{{ route('stockmasuk.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">
                        Tanggal
                    </label>
                    <input type="date" name="tanggal" value="{{ date('Y-m-d') }}"
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm" required>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">
                        Barang
                    </label>
                    <select name="stock_id" class="select2 w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm" required>
                        <option></option>
                        @foreach($stocks as $b)
                            <option value="{{ $b->id }}">{{ $b->kode_barang }} - {{ $b->nama_barang }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">
                        Supplier
                    </label>
                    <select name="supplier_id" class="select2 w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm" required>
                        <option></option>
                        @foreach($suppliers as $s)
                            <option value="{{ $s->id }}">{{ $s->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">
                        Jumlah
                    </label>
                    <input type="number" name="jumlah" placeholder="0" min="1"
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm" required>
                </div>
            </div>

            <div class="mt-4">
                <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">
                    Kualitas
                </label>
                <input type="text" name="kualitas" placeholder="Baik/Buruk"
                       class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm">
            </div>

            <div class="mt-4">
                <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">
                    Keterangan
                </label>
                <textarea name="keterangan" rows="2" placeholder="Opsional"
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

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.jQuery && typeof jQuery().select2 === 'function') {
                $('.select2').select2({
                    placeholder: '-- Pilih Barang --',
                    allowClear: true,
                    width: '100%'
                });
            }
        });
    </script>

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
                <h3 class="text-lg font-bold text-slate-800 tracking-tight">Cari Barang Masuk</h3>
            </div>
            <button onclick="window.location.href='{{ route('stockmasuk.export.pdf', ['nama_barang' => request('nama_barang'), 'supplier' => request('supplier'), 'tanggal' => request('tanggal')]) }}'"
                    class="flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Export PDF
            </button>
        </div>

        <form action="{{ route('stockmasuk.index') }}" method="GET" class="flex gap-3">
            <div class="flex-1">
                <input type="text" name="nama_barang"
                       placeholder="Cari nama barang..."
                       value="{{ request('nama_barang') }}"
                       class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div class="flex-1">
                <input type="text" name="supplier"
                       placeholder="Cari supplier..."
                       value="{{ request('supplier') }}"
                       class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div class="flex-1">
                <input type="date" name="tanggal"
                       value="{{ request('tanggal') }}"
                       class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg text-sm font-semibold transition">
                Cari
            </button>
            @if(request('nama_barang') || request('supplier') || request('tanggal'))
                <a href="{{ route('stockmasuk.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg text-sm font-semibold transition">
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- TABEL RIWAYAT --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            @if(request('nama_barang') || request('supplier') || request('tanggal'))
                <p class="text-sm text-gray-600">
                    Hasil pencarian: <span class="font-bold text-slate-800">{{ $history->count() }}</span> data ditemukan
                    <a h  ref="{{ route('stockmasuk.index') }}" class="ml-3 text-blue-500 hover:text-blue-600 font-semibold">Reset</a>
                </p>
            @else
                <p class="text-sm text-gray-600">
                    Total: <span class="font-bold text-slate-800">{{ $history->count() }}</span> data
                </p>
            @endif
        </div>
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
                    <th class="p-4">Kualitas</th>
                    <th class="p-4">Keterangan</th>
                </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                @forelse($history as $i => $row)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4 text-sm text-gray-600">{{ $i + 1 }}</td>
                        <td class="p-4 text-sm text-gray-600">{{ $row->tanggal }}</td>
                        <td class="p-4 text-sm font-mono text-slate-700">{{ $row->stock->kode_barang }}</td>
                        <td class="p-4 text-sm font-medium text-slate-800">{{ $row->stock->nama_barang }}</td>
                        <td class="p-4 text-sm text-slate-600">{{ $row->supplier->nama }}</td>
                        <td class="p-4 text-sm font-bold text-right text-slate-800">{{ $row->jumlah }}</td>
                        <td class="p-4 text-sm text-slate-600">{{ $row->kualitas ?? '-' }}</td>
                        <td class="p-4 text-sm text-gray-500 italic">{{ $row->keterangan }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="p-8 text-center text-gray-400">
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
