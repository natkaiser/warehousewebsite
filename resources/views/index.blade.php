@extends('layouts.app')

@section('header_title', 'Dashboard Manajemen Warehouse')

@section('content')

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-sm text-gray-500 font-medium">Total Jenis Barang</p>
                <h3 class="text-3xl font-bold text-slate-800 mt-2">124</h3>
                <p class="text-xs text-green-500 mt-1 flex items-center gap-1">
                </p>
            </div>
            <div class="p-4 bg-blue-50 text-blue-600 rounded-full">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-sm text-gray-500 font-medium">Total Supplier</p>
                <h3 class="text-3xl font-bold text-slate-800 mt-2">8</h3>
            </div>
            <div class="p-4 bg-orange-50 text-orange-600 rounded-full">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-sm text-gray-500 font-medium">Total Customer</p>
                <h3 class="text-3xl font-bold text-slate-800 mt-2">0</h3>
            </div>
            <div class="p-4 bg-emerald-50 text-emerald-600 rounded-full">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.485 0 4.797.66 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-sm text-gray-500 font-medium">Transaksi Bulan Ini: Februari 2026</p>
                <h3 class="text-3xl font-bold text-slate-800 mt-2">45</h3>
            </div>
            <div class="p-4 bg-purple-50 text-purple-600 rounded-full">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            </div>
        </div>

    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-bold text-slate-800 text-lg">Aktivitas Terbaru</h3>
            <a href="#" class="text-sm text-blue-600 hover:underline">Lihat Semua</a>
        </div>
        
        <div class="p-6">
            <div class="space-y-6 border-l-2 border-dashed border-gray-200 ml-3">
                
                <div class="relative pl-8 sm:pl-12">
                    <div class="absolute -left-2.5 top-1 bg-green-500 h-5 w-5 rounded-full border-4 border-white"></div>
                    
                    <div class="flex flex-col sm:flex-row justify-between sm:items-center">
                        <div>
                            <span class="text-xs font-semibold text-green-600 bg-green-100 px-2 py-1 rounded-md">Barang Masuk</span>
                            <p class="text-sm font-medium text-slate-800 mt-1">Menambahkan 50 unit "Chitato 350g"</p>
                            <p class="text-xs text-gray-400 mt-1">Oleh: Bu Fatma</p>
                        </div>
                        <span class="text-xs text-gray-400 mt-2 sm:mt-0">2 jam yang lalu</span>
                    </div>
                </div>

                <div class="relative pl-8 sm:pl-12">
                    <div class="absolute -left-2.5 top-1 bg-red-500 h-5 w-5 rounded-full border-4 border-white"></div>
                    <div class="flex flex-col sm:flex-row justify-between sm:items-center">
                        <div>
                            <span class="text-xs font-semibold text-red-600 bg-red-100 px-2 py-1 rounded-md">Barang Keluar</span>
                            <p class="text-sm font-medium text-slate-800 mt-1">Pengeluaran 2 Dus "Aqua 350ml"</p>
                            <p class="text-xs text-gray-400 mt-1">Oleh: Kelas XII TKJ 1</p>
                        </div>
                        <span class="text-xs text-gray-400 mt-2 sm:mt-0">5 jam yang lalu</span>
                    </div>
                </div>

                <div class="relative pl-8 sm:pl-12">
                    <div class="absolute -left-2.5 top-1 bg-blue-500 h-5 w-5 rounded-full border-4 border-white"></div>
                    <div class="flex flex-col sm:flex-row justify-between sm:items-center">
                        <div>
                            <span class="text-xs font-semibold text-blue-600 bg-blue-100 px-2 py-1 rounded-md">Stok Baru</span>
                            <p class="text-sm font-medium text-slate-800 mt-1">Input Data Supplier "PT. Elektronik Jaya"</p>
                            <p class="text-xs text-gray-400 mt-1">Oleh: Admin</p>
                        </div>
                        <span class="text-xs text-gray-400 mt-2 sm:mt-0">1 hari yang lalu</span>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection