@extends('layouts.app')

@section('header_title', 'User Management')

@section('content')

<div class="space-y-6">
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg" role="alert">
            <p class="font-bold">Success!</p>
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
            <h3 class="text-lg font-bold text-slate-800 tracking-tight">Add New User</h3>
        </div>

        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Example: John Smith"
                           class="w-full px-3 py-2 bg-gray-50 border @error('name') border-red-500 @else border-gray-200 @enderror rounded-lg text-sm">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Example: john@example.com"
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
                    <input type="password" name="password" placeholder="Minimum 8 characters"
                           class="w-full px-3 py-2 bg-gray-50 border @error('password') border-red-500 @else border-gray-200 @enderror rounded-lg text-sm">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">Confirm Password</label>
                    <input type="password" name="password_confirmation" placeholder="Repeat password"
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm">
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white px-6 py-2 rounded-lg text-sm font-semibold transition">
                    Save User
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
            <h3 class="text-lg font-bold text-slate-800 tracking-tight">Search User</h3>
        </div>

        <form action="{{ route('users.index') }}" method="GET" class="flex gap-3">
            <div class="flex-1">
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search name, email, or role..."
                       class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg text-sm font-semibold transition">
                Search
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
                <h3 class="text-lg font-bold text-slate-800 tracking-tight">User List (Total: {{ $users->total() }})</h3>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-emerald-50 text-emerald-700 text-sm uppercase">
                <tr>
                    <th class="p-4 w-16">No</th>
                    <th class="p-4">Name</th>
                    <th class="p-4">Email</th>
                    <th class="p-4 w-32">Role</th>
                    <th class="p-4 w-40">Created</th>
                    <th class="p-4 w-36 text-center">Action</th>
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
                        <td class="p-4 text-center">
                            <div class="flex justify-center gap-2">
                                <button type="button"
                                        onclick="openEditUserModal({{ $user->id }}, @js($user->name), @js($user->email), @js($user->role))"
                                        class="text-blue-500 hover:text-blue-700 p-1 bg-blue-50 rounded">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                                <button type="button"
                                        onclick="openDeleteUserModal({{ $user->id }}, @js($user->name))"
                                        class="text-red-500 hover:text-red-700 p-1 bg-red-50 rounded">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-400">No users found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between bg-gray-50">
            <div class="text-sm text-gray-600">
                Showing <span class="font-bold">{{ $users->count() }}</span> of <span class="font-bold">{{ $users->total() }}</span> users
            </div>
            <div class="flex items-center gap-2">
                {{ $users->appends(request()->query())->links('pagination::tailwind') }}
            </div>
        </div>
    </div>

    <div id="editUserModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-lg font-bold text-slate-800">Edit User</h4>
                <button type="button" onclick="closeEditUserModal()" class="text-gray-500 hover:text-gray-700 text-xl leading-none">&times;</button>
            </div>

            <form id="editUserForm" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Name</label>
                        <input type="text" name="name" id="editName"
                               class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm" required>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Email</label>
                        <input type="email" name="email" id="editEmail"
                               class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm" required>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Role</label>
                        <select name="role" id="editRole"
                                class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm" required>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">New Password (Optional)</label>
                        <input type="password" name="password"
                               class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm"
                               placeholder="Leave blank to keep current password">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Confirm New Password</label>
                        <input type="password" name="password_confirmation"
                               class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm"
                               placeholder="Repeat new password">
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-2">
                    <button type="button" onclick="closeEditUserModal()"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold transition">
                        Cancel
                    </button>
                    <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                        Update User
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="deleteUserModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
            <h4 class="text-lg font-bold text-slate-800 mb-2">Delete User</h4>
            <p class="text-sm text-gray-600 mb-4">Are you sure you want to delete <span id="deleteUserName" class="font-semibold text-slate-800"></span>?</p>

            <form id="deleteUserForm" method="POST">
                @csrf
                @method('DELETE')

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeDeleteUserModal()"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold transition">
                        Cancel
                    </button>
                    <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                        Delete
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const usersBaseUrl = '{{ url('/users') }}';

    function openEditUserModal(id, name, email, role) {
        const modal = document.getElementById('editUserModal');
        const form = document.getElementById('editUserForm');

        form.action = `${usersBaseUrl}/${id}`;
        document.getElementById('editName').value = name;
        document.getElementById('editEmail').value = email;
        document.getElementById('editRole').value = role;

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeEditUserModal() {
        const modal = document.getElementById('editUserModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function openDeleteUserModal(id, name) {
        const modal = document.getElementById('deleteUserModal');
        const form = document.getElementById('deleteUserForm');

        form.action = `${usersBaseUrl}/${id}`;
        document.getElementById('deleteUserName').textContent = name;

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeDeleteUserModal() {
        const modal = document.getElementById('deleteUserModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.getElementById('editUserModal')?.addEventListener('click', function (e) {
        if (e.target === this) {
            closeEditUserModal();
        }
    });

    document.getElementById('deleteUserModal')?.addEventListener('click', function (e) {
        if (e.target === this) {
            closeDeleteUserModal();
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeEditUserModal();
            closeDeleteUserModal();
        }
    });
</script>

@endsection
