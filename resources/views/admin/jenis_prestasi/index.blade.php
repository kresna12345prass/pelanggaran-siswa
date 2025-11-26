@extends('admin.layouts.app')

@section('title', 'Manajemen Jenis Prestasi')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/jenis_prestasi.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endpush

@section('content')
    
    <div class="mb-4">
        <h1 class="h3 mb-1 text-gray-800">Manajemen Jenis Prestasi</h1>
        <p class="text-muted mb-0 small">Kelola data jenis prestasi siswa</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm mb-4 border-0">
        <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-dark"><i class="fa-solid fa-trophy me-2"></i></h6>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.jenis_prestasi.export') }}" class="btn btn-success btn-sm shadow-sm">
                    <i class="fa-solid fa-file-excel me-2"></i>
                    <span class="d-none d-sm-inline">Export Excel</span>
                    <span class="d-inline d-sm-none">Excel</span>
                </a>
                <a href="{{ route('admin.jenis_prestasi.create') }}" class="btn btn-primary btn-sm shadow-sm">
                    <i class="fa-solid fa-plus me-2"></i>
                    <span class="d-none d-sm-inline">Tambah Jenis Prestasi</span>
                    <span class="d-inline d-sm-none">Tambah</span>
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive p-2 p-md-3">
                <table class="table table-hover" id="jenisPrestasiTable" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th>Nama Prestasi</th>
                            <th>Kategori</th>
                            <th class="text-center">Poin</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($jenisPrestasi as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $item->nama_prestasi }}</td>
                                <td><span class="badge bg-info">{{ $item->kategori }}</span></td>
                                <td class="text-center"><span class="badge bg-success">{{ $item->poin }}</span></td>
                                <td class="text-center">
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.jenis_prestasi.show', $item) }}" class="btn btn-info btn-sm" title="Lihat Detail">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.jenis_prestasi.edit', $item) }}" class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fa-solid fa-pencil-alt"></i>
                                        </a>
                                        <button class="btn btn-danger btn-sm" 
                                                title="Hapus" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteModal"
                                                data-nama="{{ $item->nama_prestasi }}"
                                                data-delete-url="{{ route('admin.jenis_prestasi.destroy', $item) }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data jenis prestasi ditemukan.</td>
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
                    <h5 class="modal-title" id="deleteModalLabel">Hapus Jenis Prestasi</h5>
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
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ asset('admin/jenis_prestasi.js') }}" defer></script>
@endpush
