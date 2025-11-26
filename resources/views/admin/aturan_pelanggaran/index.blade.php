@extends('admin.layouts.app')

@section('title', 'Manajemen Aturan Pelanggaran')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/aturan_pelanggaran.css') }}">
@endpush

@section('content')
    
    <div class="mb-4">
        <h1 class="h3 mb-1 text-gray-800">Manajemen Aturan Pelanggaran</h1>
        <p class="text-muted mb-0 small">Kelola aturan dan jenis pelanggaran siswa</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm mb-4 border-0">
        <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-dark"><i class="fa-solid fa-gavel me-2"></i></h6>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.aturan_pelanggaran.export') }}" class="btn btn-success btn-sm shadow-sm">
                    <i class="fa-solid fa-file-excel me-2"></i>
                    <span class="d-none d-sm-inline">Export Excel</span>
                    <span class="d-inline d-sm-none">Excel</span>
                </a>
                <a href="{{ route('admin.aturan_pelanggaran.create') }}" class="btn btn-primary btn-sm shadow-sm">
                    <i class="fa-solid fa-plus me-2"></i>
                    <span class="d-none d-sm-inline">Tambah Aturan Baru</span>
                    <span class="d-inline d-sm-none">Tambah</span>
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive p-2 p-md-3">
                <table class="table aturan-table table-hover" id="pelanggaranTable" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th>Nama Pelanggaran</th>
                            <th class="text-center">Poin</th>
                            <th>Kategori Induk</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($aturan as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $item->nama_pelanggaran }}</td>
                                <td class="text-center">
                                    <span class="badge poin-badge">{{ $item->poin }}</span>
                                </td>
                                <td>{{ $item->kategori?->kategori_induk ?? '-' }}</td>
                                <td class="text-center">
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.aturan_pelanggaran.show', $item) }}" class="btn btn-info btn-sm" title="Lihat Detail">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.aturan_pelanggaran.edit', $item) }}" class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fa-solid fa-pencil-alt"></i>
                                        </a>
                                        <button class="btn btn-danger btn-sm" 
                                                title="Hapus" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteModal"
                                                data-nama="{{ $item->nama_pelanggaran }}"
                                                data-delete-url="{{ route('admin.aturan_pelanggaran.destroy', $item) }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data aturan pelanggaran ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Hapus Aturan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="modal-body-text">Apakah Anda yakin? Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('admin/aturan_pelanggaran.js') }}" defer></script>
@endpush