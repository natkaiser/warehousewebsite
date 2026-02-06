@extends('layouts.app')

@section('header_title', 'Supplier')

@section('content')

@php
    $dummySuppliers = [
        // contoh dummy (boleh dikosongkan)
        // (object)['nama' => 'PT Sumber Air', 'alamat' => 'Jakarta', 'telepon' => '021-123456'],
    ];
@endphp

<div class="space-y-6">

    {{-- FORM TAMBAH SUPPLIER --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center gap-2 mb-6">
            <div class="bg-purple-100 p-2 rounded-lg text-purple-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 tracking-tight">
                Tambah Supplier Baru
            </h3>
        </div>

        <form action="#" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">
                        Nama Supplier
                    </label>
                    <input type="text" placeholder="Contoh: PT Sumber Air"
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">
                        Alamat
                    </label>
                    <input type="text" placeholder="Alamat supplier"
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">
                        Telepon
                    </label>
                    <input type="text" placeholder="08xxxxxxxx"
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm">
                </div>
            </div>

            <div class="mt-6">
                <button type="submit"
                        class="bg-indigo-500 hover:bg-indigo-600 text-white px-6 py-2 rounded-lg text-sm font-semibold transition">
                    Tambah Supplier
                </button>
            </div>
        </form>
    </div>

    {{-- DAFTAR SUPPLIER --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="flex items-center justify-between p-6 border-b border-gray-100">
            <div class="flex items-center gap-2">
                <div class="bg-blue-100 p-2 rounded-lg text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12h6m2 8H7a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v12a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800 tracking-tight">
                    Daftar Supplier
                </h3>
            </div>

            <button class="flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 10v6m0 0l-3-3m3 3l3-3"/>
                </svg>
                Export Excel
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-emerald-50 text-emerald-700 text-sm uppercase">
                <tr>
                    <th class="p-4">No</th>
                    <th class="p-4">Nama</th>
                    <th class="p-4">Alamat</th>
                    <th class="p-4">Telepon</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                @forelse($dummySuppliers as $i => $supplier)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4 text-sm text-gray-600">{{ $i + 1 }}</td>
                        <td class="p-4 text-sm font-medium text-slate-800">{{ $supplier->nama }}</td>
                        <td class="p-4 text-sm text-slate-600">{{ $supplier->alamat }}</td>
                        <td class="p-4 text-sm text-slate-600">{{ $supplier->telepon }}</td>
                        <td class="p-4 text-center text-sm text-gray-400">
                            —
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-gray-400">
                            Belum ada data supplier
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
