<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Warehouse System' }} - Toko Sekolah</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-slate-800">

    <div class="flex min-h-screen">
        <aside class="w-64 bg-slate-900 text-white flex flex-col fixed h-full transition-all duration-300">
            <div class="p-6 text-xl font-bold border-b border-slate-800 flex items-center gap-2">
                <span class="bg-blue-600 p-2 rounded-lg text-sm">WS</span>
                <span>Gudang Kita</span>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2">
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-blue-600 text-white font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    Stok Barang
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    Barang Masuk
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    Laporan
                </a>
            </nav>

            <div class="p-4 border-t border-slate-800">
                <div class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400">
                    <div class="w-8 h-8 rounded-full bg-slate-700 flex items-center justify-center text-xs font-bold">JD</div>
                    <div class="text-sm">
                        <p class="text-white font-medium">Admin Guru</p>
                        <p class="text-xs">Keluar</p>
                    </div>
                </div>
            </div>
        </aside>

        <main class="flex-1 ml-64 flex flex-col">
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8 sticky top-0 z-10">
                <h2 class="text-lg font-semibold text-slate-700">@yield('header_title', 'Dashboard')</h2>
                <div class="flex items-center gap-4">
                    <input type="text" placeholder="Cari barang..." class="bg-gray-100 border-none rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 w-64">
                    <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold">A</div>
                </div>
            </header>

            <section class="p-8 flex-1">
                @yield('content')
            </section>

            <footer class="p-6 bg-white border-t border-gray-200 text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} Warehouse Management System - SMK Indonesia.
            </footer>
        </main>
    </div>

</body>
</html>