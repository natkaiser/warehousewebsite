@extends('layouts.app')

@section('header_title', 'Dashboard Warehouse Management')

@section('content')

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-sm text-gray-500 font-medium">Total Type of Products</p>
                <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ $totalStocks }}</h3>
                <p class="text-xs text-green-500 mt-1 flex items-center gap-1">
                </p>
            </div>
            <div class="p-4 bg-gradient-to-br from-sky-50 to-blue-100 text-blue-600 rounded-full ring-1 ring-blue-200/80">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-sm text-gray-500 font-medium">Total Supplier</p>
                <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ $totalSuppliers }}</h3>
            </div>
            <div class="p-4 bg-gradient-to-br from-orange-50 to-amber-100 text-orange-600 rounded-full ring-1 ring-orange-200/80">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-sm text-gray-500 font-medium">Total Customer</p>
                <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ $totalCustomers }}</h3>
            </div>
            <div class="p-4 bg-gradient-to-br from-emerald-50 to-teal-100 text-emerald-600 rounded-full ring-1 ring-emerald-200/80">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.485 0 4.797.66 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-sm text-gray-500 font-medium">This month's transactions: {{ $monthName }}</p>
                <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ $monthlyTransactions }}</h3>
            </div>
            <div class="p-4 bg-gradient-to-br from-violet-50 to-purple-100 text-violet-600 rounded-full ring-1 ring-violet-200/80">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            </div>
        </div>

    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/70 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="h-9 w-9 rounded-lg bg-slate-100 text-slate-500 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10m-12 9h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v11a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-slate-800 text-lg tracking-tight">Latest Activites</h3>
            </div>
            <span class="text-xs font-medium text-slate-400">Realtime</span>
        </div>

        <div class="p-6">
            <div class="space-y-4 border-l-2 border-dashed border-slate-200 ml-2">
                @forelse($recentActivities as $activity)

                @php
                    // Map the colors so Tailwind CSS picks them up during the build process
                    $bgColor = match($activity['color'] ?? 'gray') {
                        'red' => 'bg-red-500',
                        'green' => 'bg-green-500',
                        'purple' => 'bg-purple-500',
                        'blue' => 'bg-blue-500',
                        'yellow' => 'bg-yellow-500',
                        default => 'bg-gray-500',
                    };

                    $badgeBg = match($activity['color'] ?? 'gray') {
                        'red' => 'bg-red-100',
                        'green' => 'bg-green-100',
                        'purple' => 'bg-purple-100',
                        'blue' => 'bg-blue-100',
                        'yellow' => 'bg-yellow-100',
                        default => 'bg-gray-100',
                    };

                    $badgeText = match($activity['color'] ?? 'gray') {
                        'red' => 'text-red-600',
                        'green' => 'text-green-600',
                        'purple' => 'text-purple-600',
                        'blue' => 'text-blue-600',
                        'yellow' => 'text-yellow-600',
                        default => 'text-gray-600',
                    };
                @endphp

                <div class="relative pl-8 sm:pl-10">
                    <div class="absolute -left-2.5 top-5 {{ $bgColor }} h-5 w-5 rounded-full border-4 border-white shadow-sm"></div>

                    <div class="rounded-xl border border-slate-100 bg-slate-50/60 p-4 sm:p-5 shadow-sm hover:shadow-md transition-all duration-200">
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-3">
                            <div>
                                <span class="text-xs font-semibold {{ $badgeText }} {{ $badgeBg }} px-2.5 py-1 rounded-md">{{ $activity['type'] }}</span>
                                <p class="text-sm font-medium text-slate-800 mt-2">{{ $activity['message'] }}</p>
                                <p class="text-xs text-gray-400 mt-1">Oleh: Admin</p>
                            </div>
                            <span class="inline-flex items-center rounded-full bg-white border border-slate-200 px-3 py-1 text-xs text-slate-500 mt-1 sm:mt-0">{{ $activity['time'] }}</span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="rounded-xl border border-dashed border-slate-200 bg-slate-50/70 text-center text-slate-500 py-8 px-4">
                    Tidak ada aktivitas terbaru.
                </div>
                @endforelse
            </div>
        </div>
    </div>

@endsection
