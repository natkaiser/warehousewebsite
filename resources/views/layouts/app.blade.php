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

        @keyframes slideInTop {
            from {
                opacity: 0;
                transform: translateY(-1rem);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideOutTop {
            from {
                opacity: 1;
                transform: translateY(0);
            }
            to {
                opacity: 0;
                transform: translateY(-1rem);
            }
        }

        .animate-in {
            animation: slideInTop 0.3s ease-out;
        }

        .animate-out {
            animation: slideOutTop 0.3s ease-out;
        }
    </style>
</head>
<body class="bg-gray-50 text-slate-800">

    <div class="flex min-h-screen">
        <aside class="w-64 bg-slate-900 text-white flex flex-col fixed h-full transition-all duration-300">
            <div class="p-6 text-xl font-bold border-b border-slate-800 flex items-center gap-2">
                <span class="bg-blue-600 p-2 rounded-lg text-sm">43</span>
                <span>Gudang RPS</span>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2">
                <a href="/" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard
                </a>
                <a href="/supplier" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    Supplier
                </a>
                <a href="/customer" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.485 0 4.797.66 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0zM12 3v2m0 14v2M4 12H2m20 0h-2M6.343 6.343L4.929 4.929m14.142 14.142l-1.414-1.414M17.657 6.343l1.414-1.414"/></svg>
                    Customer
                <a href="/stock" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    Products
                </a>
                <a href="/stockmasuk" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    Stock In
                </a>
                <a href="/stockkeluar" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    Stock Out
                </a>
                </a>
            </nav>

            <div class="p-4 border-t border-slate-800">
                <div class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400">
                    <div class="w-8 h-8 rounded-full bg-slate-700 flex items-center justify-center text-xs font-bold">JD</div>
                    <div class="text-sm">
                        <p class="text-white font-medium">{{ Auth::user()->name ?? 'Admin' }}</p>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-xs text-red-400 hover:text-red-300">Keluar</button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        <main class="flex-1 ml-64 flex flex-col">
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8 sticky top-0 z-10">
                <h2 class="text-lg font-semibold text-slate-700">@yield('header_title', 'Dashboard')</h2>

            </header>

            {{-- ALERT NOTIFICATIONS --}}
            <div id="alertContainer" class="fixed top-6 right-6 z-50 space-y-3 w-96"></div>

            <section class="p-8 flex-1">
                @yield('content')
            </section>

            <footer class="p-6 bg-white border-t border-gray-200 text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} System Manajemen Warehouse - SMKN 43 Jakarta, Indonesia.
            </footer>
        </main>
    </div>

    <script>
        // Function untuk menampilkan alert
        function showAlert(message, type = 'success', duration = 4000) {
            const alertContainer = document.getElementById('alertContainer');

            const icons = {
                success: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>',
                error: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>',
                warning: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 4v2M20.88 18.09A5 5 0 1 0 9.11 2m9.77 16.09A5 5 0 1 1 3.23 4m13.65 14.09a5 5 0 0 1-9.88-1.18m9.88 1.18a5 5 0 0 0-9.88-1.18"></path></svg>',
                info: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
            };

            const colors = {
                success: { bg: 'bg-green-50', border: 'border-green-200', text: 'text-green-800', icon: 'text-green-500' },
                error: { bg: 'bg-red-50', border: 'border-red-200', text: 'text-red-800', icon: 'text-red-500' },
                warning: { bg: 'bg-yellow-50', border: 'border-yellow-200', text: 'text-yellow-800', icon: 'text-yellow-500' },
                info: { bg: 'bg-blue-50', border: 'border-blue-200', text: 'text-blue-800', icon: 'text-blue-500' }
            };

            const color = colors[type] || colors.success;

            const alert = document.createElement('div');
            alert.className = `${color.bg} ${color.border} border rounded-lg shadow-lg p-4 flex items-start gap-3 animate-in fade-in slide-in-from-top-2 duration-300 max-w-sm`;
            alert.innerHTML = `
                <div class="${color.icon}">${icons[type]}</div>
                <div class="flex-1">
                    <p class="${color.text} font-semibold text-sm">${message}</p>
                </div>
                <button onclick="this.closest('div').remove()" class="${color.text} hover:opacity-70 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;

            alertContainer.appendChild(alert);

            if (duration > 0) {
                setTimeout(() => {
                    alert.classList.add('animate-out', 'fade-out', 'slide-out-to-top-2', 'duration-300');
                    setTimeout(() => alert.remove(), 300);
                }, duration);
            }
        }

        // Show session alerts
        @if(session('success'))
            showAlert('{{ session('success') }}', 'success', 4000);
        @endif

        @if(session('error'))
            showAlert('{{ session('error') }}', 'error', 5000);
        @endif

        @if($errors->any())
            @foreach($errors->all() as $error)
                showAlert('{{ $error }}', 'error', 5000);
            @endforeach
        @endif
    </script>

</body>
</html>
