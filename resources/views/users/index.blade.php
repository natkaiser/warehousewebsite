@extends('layouts.app')

@section('header_title', 'Manajemen User')

@section('content')

<div class="space-y-6">
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg" role="alert">
            <p class="font-bold">Berhasil!</p>
            <p class="text-sm">{{ session('success') }}</p>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg" role="alert">
            <p class="font-bold">Error!</p>
            <p class="text-sm">{{ session('error') }}</p>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center gap-2 mb-6">
            <div class="bg-purple-100 p-2 rounded-lg text-purple-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 tracking-tight">Tambah User Baru</h3>
        </div>

        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">Nama</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Budi Santoso"
                           class="w-full px-3 py-2 bg-gray-50 border @error('name') border-red-500 @else border-gray-200 @enderror rounded-lg text-sm">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Contoh: budi@example.com"
                           class="w-full px-3 py-2 bg-gray-50 border @error('email') border-red-500 @else border-gray-200 @enderror rounded-lg text-sm">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">Role</label>
                    <select name="role" class="w-full px-3 py-2 bg-gray-50 border @error('role') border-red-500 @else border-gray-200 @enderror rounded-lg text-sm">
                        <option value="user" {{ old('role', 'user') === 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">Password</label>
                    <input type="password" name="password" placeholder="Minimal 8 karakter"
                           class="w-full px-3 py-2 bg-gray-50 border @error('password') border-red-500 @else border-gray-200 @enderror rounded-lg text-sm">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" placeholder="Ulangi password"
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm">
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white px-6 py-2 rounded-lg text-sm font-semibold transition">
                    Simpan User
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center gap-2 mb-4">
            <div class="bg-blue-100 p-2 rounded-lg text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 tracking-tight">Cari User</h3>
        </div>

        <form action="{{ route('users.index') }}" method="GET" class="flex gap-3">
            <div class="flex-1">
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama, email, atau role..."
                       class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg text-sm font-semibold transition">
                Cari
            </button>
            @if($search)
                <a href="{{ route('users.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg text-sm font-semibold transition">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="flex items-center justify-between p-6 border-b border-gray-100">
            <div class="flex items-center gap-2">
                <div class="bg-blue-100 p-2 rounded-lg text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m2 8H7a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v12a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800 tracking-tight">Daftar User (Total: {{ $users->total() }})</h3>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-emerald-50 text-emerald-700 text-sm uppercase">
                <tr>
                    <th class="p-4 w-16">No</th>
                    <th class="p-4">Nama</th>
                    <th class="p-4">Email</th>
                    <th class="p-4 w-32">Role</th>
                    <th class="p-4 w-40">Dibuat</th>
                </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                @forelse($users as $i => $user)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4 text-sm text-gray-600">{{ ($users->currentPage() - 1) * 10 + $i + 1 }}</td>
                        <td class="p-4 text-sm font-medium text-slate-800">{{ $user->name }}</td>
                        <td class="p-4 text-sm text-slate-600">{{ $user->email }}</td>
                        <td class="p-4 text-sm">
                            @if($user->role === 'admin')
                                <span class="inline-flex px-2 py-1 rounded-full bg-indigo-100 text-indigo-700 text-xs font-semibold">Admin</span>
                            @else
                                <span class="inline-flex px-2 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-semibold">User</span>
                            @endif
                        </td>
                        <td class="p-4 text-sm text-slate-600">{{ $user->created_at->format('d-m-Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-gray-400">Belum ada data user.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between bg-gray-50">
            <div class="text-sm text-gray-600">
                Menampilkan <span class="font-bold">{{ $users->count() }}</span> dari <span class="font-bold">{{ $users->total() }}</span> user
            </div>
            <div class="flex items-center gap-2">
                {{ $users->appends(request()->query())->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
</div>

@endsection
