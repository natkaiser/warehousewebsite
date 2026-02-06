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
                    <input type="text" name="alamat" placeholder="Alamat supplier" value="{{ old('alamat') }}"
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
                    Daftar Supplier
                </h3>
            </div>

            <button class="flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 10v6m0 0l-3-3m3 3l3-3"/>
                </svg>
                Export Excel
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-emerald-50 text-emerald-700 text-sm uppercase">
                <tr>
                    <th class="p-4">No</th>
                    <th class="p-4">Nama</th>
                    <th class="p-4">Alamat</th>
                    <th class="p-4">Telepon</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                @forelse($suppliers as $i => $supplier)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4 text-sm text-gray-600">{{ $i + 1 }}</td>
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
    </div>

</div>
{{-- MODAL EDIT --}}
<div id="editModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl w-full max-w-md p-6">
        <h3 class="text-lg font-bold mb-4">Edit Supplier</h3>

        <form id="editForm" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <input id="editNama" name="nama" class="w-full px-3 py-2 border rounded-lg">
                <input id="editAlamat" name="alamat" class="w-full px-3 py-2 border rounded-lg">
                <input id="editTelepon" name="telepon" class="w-full px-3 py-2 border rounded-lg">
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-300 rounded-lg">
                    Batal
                </button>
                <button class="px-4 py-2 bg-indigo-500 text-white rounded-lg">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL DELETE --}}
<div id="deleteModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl w-full max-w-sm p-6 text-center">
        <h3 class="text-lg font-bold mb-2">Hapus Supplier?</h3>
        <p id="deleteName" class="text-gray-500 mb-4"></p>

        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')

            <div class="flex justify-center gap-3">
                <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-300 rounded-lg">
                    Batal
                </button>
                <button class="px-4 py-2 bg-red-500 text-white rounded-lg">
                    Hapus
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    function openEditModal(id, nama, alamat, telepon) {
        editModal.classList.remove('hidden')
        editModal.classList.add('flex')

        editNama.value = nama
        editAlamat.value = alamat
        editTelepon.value = telepon
        editForm.action = `/supplier/${id}`
    }

    function closeEditModal() {
        editModal.classList.add('hidden')
    }

    function openDeleteModal(id, nama) {
        deleteModal.classList.remove('hidden')
        deleteModal.classList.add('flex')

        deleteName.innerText = nama
        deleteForm.action = `/supplier/${id}`
    }

    function closeDeleteModal() {
        deleteModal.classList.add('hidden')
    }
</script>

@endsection
