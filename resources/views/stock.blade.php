@extends('layouts.app')

@section('header_title', 'Products')

@section('content')

@php($isAdmin = Auth::user()?->role === 'admin')

<div class="space-y-6">
    {{-- FLASH MESSAGE SUCCESS --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg" role="alert">
            <p class="font-bold">Success!</p>
            <p class="text-sm">{{ session('success') }}</p>
        </div>
    @endif

    {{-- FLASH MESSAGE ERROR --}}
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg" role="alert">
            <p class="font-bold">Error.</p>
            <p class="text-sm">{{ session('error') }}</p>
        </div>
    @endif

    {{-- FORM TAMBAH BARANG --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center gap-2 mb-6">
            <div class="bg-purple-100 p-2 rounded-lg text-purple-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 tracking-tight">Add New Product</h3>
        </div>

        <form action="{{ route('stock.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">Product ID</label>
                    <input type="text" name="kode_barang" id="kodeBarang" required placeholder="Scan barcode or enter manually"
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">Product Name</label>
                    <input type="text" name="nama_barang" required placeholder="Example: Oreo Vanilla"
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">Rack</label>
                    <input type="text" name="rak" placeholder="Example: A1-03"
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">Specification</label>
                    <input type="text" name="spesifikasi" placeholder="Example : 350ml, 1kg, dll"
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">Unit</label>
                    <input type="text" name="satuan" required placeholder="Example : pcs, botol, kg, dll"
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm">
                </div>
            </div>

            <div class="mt-6">
                <button type="submit"
                        class="bg-indigo-500 hover:bg-indigo-600 text-white px-6 py-2 rounded-lg text-sm font-semibold">
                    Add Product
                </button>
            </div>
        </form>
    </div>

    {{-- FORM CARI BARANG --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <div class="bg-blue-100 p-2 rounded-lg text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800 tracking-tight">Search Product</h3>
            </div>
            <button onclick="downloadPDF()" class="flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Export PDF
            </button>
        </div>

        <form action="{{ route('stock.index') }}" method="GET" class="flex gap-3">
            <div class="flex-1">
                <input type="text" name="kode_barang"
                       placeholder="Search Product ID..."
                       value="{{ request('kode_barang') }}"
                       class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div class="flex-1">
                <input type="text" name="nama_barang"
                       placeholder="Search Product Name..."
                       value="{{ request('nama_barang') }}"
                       class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div class="flex-1">
                <input type="text" name="rak"
                       placeholder="Search Rack..."
                       value="{{ request('rak') }}"
                       class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div class="flex-1">
                <input type="text" name="spesifikasi"
                       placeholder="Search Specification..."
                       value="{{ request('spesifikasi') }}"
                       class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg text-sm font-semibold transition">
                Search
            </button>
            @if(request('kode_barang') || request('nama_barang') || request('rak') || request('spesifikasi'))
                <a href="{{ route('stock.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg text-sm font-semibold transition">
                    Reset
                </a>
            @endif
        </form>

        @if(request('kode_barang') || request('nama_barang') || request('rak') || request('spesifikasi'))
            <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                <p class="text-sm text-blue-800">
                    Search Results:
                    @if(request('kode_barang')) Product ID: "{{ request('kode_barang') }}", @endif
                    @if(request('nama_barang')) Product Name: "{{ request('nama_barang') }}", @endif
                    @if(request('rak')) Rack: "{{ request('rak') }}", @endif
                    @if(request('spesifikasi')) Specification: "{{ request('spesifikasi') }}", @endif
                    <span class="text-blue-600">({{ $stocks->total() }} results found)</span>
                </p>
            </div>
        @endif
    </div>

    {{-- DAFTAR STOCK BARANG --}}
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
                    Stock List (Total: {{ $stocks->total() }})
                </h3>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-emerald-50 text-emerald-700 text-sm uppercase">
                <tr>
                    {{-- <th class="p-4">No</th> --}}
                    <th class="p-4">Product ID</th>
                    <th class="p-4">Product Name</th>
                    <th class="p-4">Rack</th>
                    <th class="p-4">Specification</th>
                    <th class="p-4 text-right">Stock</th>
                    <th class="p-4">Unit</th>
                    @if($isAdmin)
                        <th class="p-4 text-center">Action</th>
                    @endif
                </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                @forelse($stocks as $index => $item)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4 text-sm font-mono text-slate-700">{{ $item->kode_barang }}</td>
                        <td class="p-4 text-sm font-medium text-slate-800">{{ $item->nama_barang }}</td>
                        <td class="p-4 text-sm text-slate-600">{{ $item->rak ?? '-' }}</td>
                        <td class="p-4 text-sm text-slate-600">
                            <span class="px-2 py-1 bg-gray-100 rounded text-xs font-semibold">
                                {{ $item->spesifikasi ?? '-' }}
                            </span>
                        </td>
                        <td class="p-4 text-sm font-bold text-slate-800 text-right">{{ $item->stok }}</td>
                        <td class="p-4 text-sm text-slate-500">{{ $item->satuan }}</td>

                        {{-- AKSI --}}
                        @if($isAdmin)
                            <td class="p-4 text-center">
                                <div class="flex justify-center gap-2">
                                    {{-- EDIT --}}
                                    <button
                                        onclick="openEditModal(
                                            {{ $item->id }},
                                            '{{ addslashes($item->kode_barang) }}',
                                            '{{ addslashes($item->nama_barang) }}',
                                            '{{ addslashes($item->rak ?? '') }}',
                                            '{{ addslashes($item->spesifikasi) }}',
                                            '{{ addslashes($item->satuan) }}'
                                        )"
                                        class="text-blue-500 hover:text-blue-700 p-1 bg-blue-50 rounded">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>

                                    {{-- DELETE --}}
                                    <button type="button" onclick="openDeleteModal({{ $item->id }}, '{{ addslashes($item->nama_barang) }}')" class="text-red-500 hover:text-red-700 p-1 bg-red-50 rounded">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $isAdmin ? 8 : 7 }}" class="p-8 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                </svg>
                                <p class="text-gray-500">
                                    @if($search)
                                        No item found with the name "<span class="font-semibold">{{ $search }}</span>" not found
                                    @else
                                        No Product Data.
                                    @endif
                                </p>
                                @if($search)
                                    <p class="text-sm text-gray-400">Try using different keywords</p>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between bg-gray-50">
            <div class="text-sm text-gray-600">
                Showing <span class="font-bold">{{ $stocks->count() }}</span> From <span class="font-bold">{{ $stocks->total() }}</span> Products
            </div>
            <div class="flex items-center gap-2">
                {{ $stocks->appends(request()->query())->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
</div>

{{-- HIDDEN DELETE FORM --}}
<form id="deleteForm" action="" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>

{{-- MODAL EDIT BARANG --}}
<div id="editModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md">
        <div class="flex items-center gap-2 mb-6">
            <div class="bg-blue-100 p-2 rounded-lg text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800">Edit Product</h3>
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
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">Product ID<label>
                    <input type="text" id="editKodeBarang" name="kode_barang" required
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">Product Name</label>
                    <input type="text" id="editNamaBarang" name="nama_barang" required
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">Specification</label>
                    <input type="text" id="editSpesifikasi" name="spesifikasi"
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">Rack</label>
                    <input type="text" id="editRak" name="rak"
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">Unit</label>
                    <input type="text" id="editSatuan" name="satuan" required
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>

            <div class="flex gap-3 mt-6">
                <button type="submit" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                    Save Changes
                </button>
                <button type="button" onclick="closeEditModal()" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold transition">
                    Cancel
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

        <h3 class="text-lg font-bold text-center text-slate-800 mb-2">Delete Product?</h3>
        <p class="text-center text-gray-600 text-sm mb-6">
            Are you sure you want to delete product<br><span id="deleteItemName" class="font-semibold text-slate-800"></span>?<br> This action cannot be undone.
        </p>

        <div class="flex gap-3">
            <button type="button" onclick="closeDeleteModal()" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold transition">
                Cancel
            </button>
            <button type="button" onclick="confirmDelete()" class="flex-1 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                Yes, Delete
            </button>
        </div>
    </div>
</div>

<script>
let deleteItemId = null;

function openEditModal(id, kodeBarang, namaBarang, rak, spesifikasi, satuan) {
    document.getElementById('editKodeBarang').value = kodeBarang;
    document.getElementById('editNamaBarang').value = namaBarang;
    document.getElementById('editRak').value = rak || '';
    document.getElementById('editSpesifikasi').value = spesifikasi;
    document.getElementById('editSatuan').value = satuan;

    const form = document.getElementById('editForm');
    form.action = '/stock/' + id;

    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('editModal').classList.add('flex');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}

function openDeleteModal(id, namaBarang) {
    deleteItemId = id;
    document.getElementById('deleteItemName').textContent = namaBarang;
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteModal').classList.add('flex');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    deleteItemId = null;
}

function confirmDelete() {
    if (deleteItemId) {
        const form = document.getElementById('deleteForm');
        form.action = '/stock/' + deleteItemId;
        form.submit();
    }
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

// Fungsi export PDF
function downloadPDF() {
    const kodeBarang = document.querySelector('input[name="kode_barang"]').value;
    const namaBarang = document.querySelector('input[name="nama_barang"]').value;
    const rak = document.querySelector('input[name="rak"]').value;
    const spesifikasi = document.querySelector('input[name="spesifikasi"]').value;
    let url = '{{ route("stock.export") }}';
    const params = [];

    if (kodeBarang) params.push('kode_barang=' + encodeURIComponent(kodeBarang));
    if (namaBarang) params.push('nama_barang=' + encodeURIComponent(namaBarang));
    if (rak) params.push('rak=' + encodeURIComponent(rak));
    if (spesifikasi) params.push('spesifikasi=' + encodeURIComponent(spesifikasi));

    if (params.length > 0) {
        url += '?' + params.join('&');
    }

    showAlert('Downloading PDF...', 'info', 0);
    window.location.href = url;

    setTimeout(() => {
        showAlert('PDF downloaded successfully!', 'success', 3000);
    }, 1000);
}

// Barcode scan functionality - langsung isi kode_barang saat scan
document.getElementById('kodeBarang').addEventListener('keydown', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        // Barcode scanner sudah mengisi field ini, lanjut ke field berikutnya
        document.querySelector('input[name="nama_barang"]').focus();
    }
});
</script>
@endsection
