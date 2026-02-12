@extends('layouts.app')

@section('header_title', 'Supplier')

@section('content')

<div class="space-y-6">
    {{-- FLASH MESSAGE SUCCESS --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg" role="alert">
            <p class="font-bold">Berhasil!</p>
            <p class="text-sm">{{ session('success') }}</p>
        </div>
    @endif

    {{-- FLASH MESSAGE ERROR --}}
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg" role="alert">
            <p class="font-bold">Error!</p>
            <p class="text-sm">{{ session('error') }}</p>
        </div>
    @endif

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

        <form action="{{ route('supplier.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">
                        Nama Supplier
                    </label>
                    <input type="text" name="nama" placeholder="Contoh: PT Sumber Air" value="{{ old('nama') }}"
                           class="w-full px-3 py-2 bg-gray-50 border @error('nama') border-red-500 @else border-gray-200 @enderror rounded-lg text-sm">
                    @error('nama')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">
                        Alamat
                    </label>
                    <input type="text" name="alamat" placeholder="Alamat Supplier" value="{{ old('alamat') }}"
                           class="w-full px-3 py-2 bg-gray-50 border @error('alamat') border-red-500 @else border-gray-200 @enderror rounded-lg text-sm">
                    @error('alamat')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">
                        Telepon
                    </label>
                    <input type="text" name="telepon" placeholder="08xxxxxxxx" value="{{ old('telepon') }}"
                           class="w-full px-3 py-2 bg-gray-50 border @error('telepon') border-red-500 @else border-gray-200 @enderror rounded-lg text-sm">
                    @error('telepon')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
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

    {{-- FORM CARI SUPPLIER --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <div class="bg-blue-100 p-2 rounded-lg text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800 tracking-tight">Cari Supplier</h3>
            </div>
            <button class="flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition"
                    onclick="window.location.href='{{ route('supplier.export.pdf') }}{{ $search ? '?search=' . urlencode($search) : '' }}'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Export PDF
            </button>
        </div>

        <form action="{{ route('supplier.index') }}" method="GET" class="flex gap-3">
            <div class="flex-1">
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari berdasarkan nama supplier, alamat, atau telepon..."
                       class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg text-sm font-semibold transition">
                Cari
            </button>
            @if($search)
                <a href="{{ route('supplier.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg text-sm font-semibold transition">
                    Reset
                </a>
            @endif
        </form>

        @if($search)
            <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                <p class="text-sm text-blue-800">
                    Hasil pencarian untuk: <span class="font-semibold">{{ $search }}</span>
                    <span class="text-blue-600">({{ $suppliers->count() }} hasil ditemukan)</span>
                </p>
            </div>
        @endif
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
                    Daftar Supplier (Total: {{ $suppliers->total() }})
                </h3>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-emerald-50 text-emerald-700 text-sm uppercase">
                <tr>
                    <th class="p-4 w-16">No</th>
                    <th class="p-4 w-48">Nama</th>
                    <th class="p-4 w-64">Alamat</th>
                    <th class="p-4 w-32">Telepon</th>
                    <th class="p-4 text-center w-24">Aksi</th>
                </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                @forelse($suppliers as $i => $supplier)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4 text-sm text-gray-600">{{ ($suppliers->currentPage() - 1) * 10 + $i + 1 }}</td>
                        <td class="p-4 text-sm font-medium text-slate-800">{{ $supplier->nama }}</td>
                        <td class="p-4 text-sm text-slate-600">{{ $supplier->alamat }}</td>
                        <td class="p-4 text-sm text-slate-600">{{ $supplier->telepon }}</td>
                        <td class="p-4 text-center">
    <div class="flex justify-center gap-2">

        {{-- EDIT --}}
        <button
            onclick="openEditModal(
                {{ $supplier->id }},
                '{{ $supplier->nama }}',
                '{{ $supplier->alamat }}',
                '{{ $supplier->telepon }}'
            )"
            class="text-blue-500 hover:text-blue-700 p-1 bg-blue-50 rounded">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
        </button>

        {{-- DELETE --}}
        <button
            onclick="openDeleteModal({{ $supplier->id }}, '{{ $supplier->nama }}')"
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
                        <td colspan="5" class="p-8 text-center text-gray-400">
                            Belum ada data supplier
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between bg-gray-50">
            <div class="text-sm text-gray-600">
                Menampilkan <span class="font-bold">{{ $suppliers->count() }}</span> dari <span class="font-bold">{{ $suppliers->total() }}</span> supplier
            </div>
            <div class="flex items-center gap-2">
                {{ $suppliers->appends(request()->query())->links('pagination::tailwind') }}
            </div>
        </div>
    </div>

</div>
{{-- MODAL EDIT SUPPLIER --}}
<div id="editModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md">
        <div class="flex items-center gap-2 mb-6">
            <div class="bg-blue-100 p-2 rounded-lg text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800">Edit Supplier</h3>
            <button onclick="closeEditModal()" class="ml-auto text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form id="editForm" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">Nama Supplier</label>
                    <input type="text" id="editNama" name="nama" required
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">Alamat</label>
                    <input type="text" id="editAlamat" name="alamat" required
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">Telepon</label>
                    <input type="text" id="editTelepon" name="telepon" required
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>

            <div class="flex gap-3 mt-6">
                <button type="submit" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                    Simpan Perubahan
                </button>
                <button type="button" onclick="closeEditModal()" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold transition">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL KONFIRMASI DELETE --}}
<div id="deleteModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-sm">
        <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-4">
            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </div>
        
        <h3 class="text-lg font-bold text-center text-slate-800 mb-2">Hapus Supplier?</h3>
        <p class="text-center text-gray-600 text-sm mb-6">
            Apakah Anda yakin ingin menghapus supplier <span id="deleteName" class="font-semibold text-slate-800"></span>? Tindakan ini tidak dapat dibatalkan.
        </p>

        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')

            <div class="flex gap-3">
                <button type="button" onclick="closeDeleteModal()" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold transition">
                    Batal
                </button>
                <button class="flex-1 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                    Ya, Hapus
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    function openEditModal(id, nama, alamat, telepon) {
        document.getElementById('editNama').value = nama;
        document.getElementById('editAlamat').value = alamat;
        document.getElementById('editTelepon').value = telepon;
        
        const form = document.getElementById('editForm');
        form.action = '/supplier/' + id;
        
        document.getElementById('editModal').classList.remove('hidden');
        document.getElementById('editModal').classList.add('flex');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    function openDeleteModal(id, nama) {
        document.getElementById('deleteName').textContent = nama;
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('deleteModal').classList.add('flex');
        
        const form = document.getElementById('deleteForm');
        form.action = '/supplier/' + id;
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('editModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeEditModal();
        }
    });

    document.getElementById('deleteModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });

    // Handle keyboard events
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeEditModal();
            closeDeleteModal();
        }
    });
</script>

@endsection
