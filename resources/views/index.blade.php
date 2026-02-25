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
            <div class="p-4 bg-blue-50 text-blue-600 rounded-full">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-sm text-gray-500 font-medium">Total Supplier</p>
                <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ $totalSuppliers }}</h3>
            </div>
            <div class="p-4 bg-orange-50 text-orange-600 rounded-full">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-sm text-gray-500 font-medium">Total Customer</p>
                <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ $totalCustomers }}</h3>
            </div>
            <div class="p-4 bg-emerald-50 text-emerald-600 rounded-full">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.485 0 4.797.66 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-sm text-gray-500 font-medium">This month's transactions: {{ $monthName }}</p>
                <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ $monthlyTransactions }}</h3>
            </div>
            <div class="p-4 bg-purple-50 text-purple-600 rounded-full">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            </div>
        </div>

    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-bold text-slate-800 text-lg">Latest Activites</h3>
        </div>

        <div class="p-6">
            <div class="space-y-6 border-l-2 border-dashed border-gray-200 ml-3">
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

                <div class="relative pl-12 sm:pl-12">
                    <div class="absolute -left-[11px] top-1 {{ $bgColor }} h-5 w-5 rounded-full border-4 border-white shadow-sm"></div>

                    <div class="flex flex-col sm:flex-row justify-between sm:items-center">
                        <div>
                            <span class="text-xs font-semibold {{ $badgeText }} {{ $badgeBg }} px-2 py-1 rounded-md">{{ $activity['type'] }}</span>
                            <p class="text-sm font-medium text-slate-800 mt-1">{{ $activity['message'] }}</p>
                            <p class="text-xs text-gray-400 mt-1">Oleh: Admin</p>
                        </div>
                        <span class="text-xs text-gray-400 mt-2 sm:mt-0">{{ $activity['time'] }}</span>
                    </div>
                </div>
                @empty
                <div class="text-center text-gray-500 py-4">
                    Tidak ada aktivitas terbaru.
                </div>
                @endforelse
            </div>
        </div>
    </div>

@endsection
