@extends('layouts.app')

@section('header_title', 'Stock Barang')

@section('content')

<div class="space-y-6">



    {{-- FORM TAMBAH BARANG --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center gap-2 mb-6">
            <div class="bg-purple-100 p-2 rounded-lg text-purple-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 tracking-tight">Tambah Barang Baru</h3>
        </div>

        <form action="{{ route('stock.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">Kode Barang</label>
                    <input type="text" name="kode_barang" required placeholder="Contoh : BGR-001"
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">Nama Barang</label>
                    <input type="text" name="nama_barang" required placeholder="Masukan nama barang"
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">Spesifikasi</label>
                    <input type="text" name="spesifikasi" placeholder="Contoh : 350ml, 1kg, dll"
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">Satuan</label>
                    <input type="text" name="satuan" required placeholder="Contoh : pcs, botol, kg, dll"    
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm">
                </div>
            </div>

            <div class="mt-6">
                <button type="submit"
                        class="bg-indigo-500 hover:bg-indigo-600 text-white px-6 py-2 rounded-lg text-sm font-semibold">
                    Tambah Barang
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
                <h3 class="text-lg font-bold text-slate-800 tracking-tight">Cari Barang</h3>
            </div>
            <button onclick="downloadExcel()" class="flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Export Excel
            </button>
        </div>

        <form action="{{ route('stock.index') }}" method="GET" class="flex gap-3">
            <div class="flex-1">
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari berdasarkan nama barang, kode, atau spesifikasi..."
                       class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg text-sm font-semibold transition">
                Cari
            </button>
            @if($search)
                <a href="{{ route('stock.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg text-sm font-semibold transition">
                    Reset
                </a>
            @endif
        </form>

        @if($search)
            <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                <p class="text-sm text-blue-800">
                    Hasil pencarian untuk: <span class="font-semibold">{{ $search }}</span>
                    <span class="text-blue-600">({{ $stocks->count() }} hasil ditemukan)</span>
                </p>
            </div>
        @endif
    </div>

    {{-- TABEL DATA --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-emerald-50 text-emerald-700 text-sm uppercase">
                <tr>
                    <th class="p-4">No</th>
                    <th class="p-4">Kode</th>
                    <th class="p-4">Nama Barang</th>
                    <th class="p-4">Spesifikasi</th>
                    <th class="p-4 text-right">Stok</th>
                    <th class="p-4">Satuan</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                @forelse($stocks as $index => $item)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4 text-sm text-gray-600">{{ $index + 1 }}</td>
                        <td class="p-4 text-sm font-mono text-slate-700">{{ $item->kode_barang }}</td>
                        <td class="p-4 text-sm font-medium text-slate-800">{{ $item->nama_barang }}</td>
                        <td class="p-4 text-sm text-slate-600">
                            <span class="px-2 py-1 bg-gray-100 rounded text-xs font-semibold">
                                {{ $item->spesifikasi ?? '-' }}
                            </span>
                        </td>
                        <td class="p-4 text-sm font-bold text-slate-800 text-right">{{ $item->stok }}</td>
                        <td class="p-4 text-sm text-slate-500">{{ $item->satuan }}</td>

                        {{-- AKSI --}}
                        <td class="p-4 text-center">
                            <div class="flex justify-center gap-2">
                                <button onclick="openEditModal({{ $item->id }}, '{{ $item->kode_barang }}', '{{ $item->nama_barang }}', '{{ $item->spesifikasi }}', '{{ $item->satuan }}')" class="text-blue-500 hover:text-blue-700 p-1 bg-blue-50 rounded">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>

                                <form id="deleteForm" action="" method="POST" style="display:none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button type="button" onclick="openDeleteModal({{ $item->id }}, '{{ $item->nama_barang }}')" class="text-red-500 hover:text-red-700 p-1 bg-red-50 rounded">
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
                        <td colspan="7" class="p-8 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                </svg>
                                <p class="text-gray-500">
                                    @if($search)
                                        Barang dengan nama "<span class="font-semibold">{{ $search }}</span>" tidak ditemukan
                                    @else
                                        Data barang masih kosong
                                    @endif
                                </p>
                                @if($search)
                                    <p class="text-sm text-gray-400">Coba gunakan kata kunci lain</p>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL EDIT BARANG --}}
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md">
        <div class="flex items-center gap-2 mb-6">
            <div class="bg-blue-100 p-2 rounded-lg text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800">Edit Barang</h3>
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
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">Kode Barang</label>
                    <input type="text" id="editKodeBarang" name="kode_barang" required
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">Nama Barang</label>
                    <input type="text" id="editNamaBarang" name="nama_barang" required
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">Spesifikasi</label>
                    <input type="text" id="editSpesifikasi" name="spesifikasi"
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">Satuan</label>
                    <input type="text" id="editSatuan" name="satuan" required
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
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-sm">
        <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-4">
            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </div>
        
        <h3 class="text-lg font-bold text-center text-slate-800 mb-2">Hapus Barang?</h3>
        <p class="text-center text-gray-600 text-sm mb-6">
            Apakah Anda yakin ingin menghapus barang <span id="deleteItemName" class="font-semibold text-slate-800"></span>? Tindakan ini tidak dapat dibatalkan.
        </p>

        <div class="flex gap-3">
            <button type="button" onclick="closeDeleteModal()" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold transition">
                Batal
            </button>
            <button type="button" onclick="confirmDelete()" class="flex-1 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

<script>
let deleteItemId = null;

function openEditModal(id, kodeBarang, namaBarang, spesifikasi, satuan) {
    document.getElementById('editKodeBarang').value = kodeBarang;
    document.getElementById('editNamaBarang').value = namaBarang;
    document.getElementById('editSpesifikasi').value = spesifikasi;
    document.getElementById('editSatuan').value = satuan;
    
    const form = document.getElementById('editForm');
    form.action = '/stock/' + id;
    
    document.getElementById('editModal').classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}

function openDeleteModal(id, namaBarang) {
    deleteItemId = id;
    document.getElementById('deleteItemName').textContent = namaBarang;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    deleteItemId = null;
}

function confirmDelete() {
    if (deleteItemId) {
        const form = document.getElementById('deleteForm');
        form.action = '/stock/' + deleteItemId;
        
        showAlert('Menghapus barang...', 'info', 0);
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

// Fungsi export excel
function downloadExcel() {
    const search = document.querySelector('input[name="search"]').value;
    let url = '{{ route("stock.export") }}';
    
    if (search) {
        url += '?search=' + encodeURIComponent(search);
    }
    
    showAlert('Mengunduh file Excel...', 'info', 0);
    window.location.href = url;
    
    setTimeout(() => {
        showAlert('File berhasil diunduh!', 'success', 3000);
    }, 1000);
}
</script>
@endsection
