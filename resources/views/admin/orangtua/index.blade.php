@extends('admin.layouts.app')

@section('title', 'Manajemen Orang Tua')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/orangtua.css') }}">
@endpush

@section('content')
    
    <div class="mb-4">
        <h1 class="h3 mb-1 text-gray-800">Manajemen Orang Tua</h1>
        <p class="text-muted mb-0 small">Kelola data orang tua siswa</p>
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
            <h6 class="m-0 fw-bold text-dark"><i class="fa-solid fa-user-group me-2"></i></h6>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.orangtua.export') }}" class="btn btn-success btn-sm shadow-sm">
                    <i class="fa-solid fa-file-excel me-2"></i>
                    <span class="d-none d-sm-inline">Export Excel</span>
                    <span class="d-inline d-sm-none">Excel</span>
                </a>
                <a href="{{ route('admin.orangtua.create') }}" class="btn btn-primary btn-sm shadow-sm">
                    <i class="fa-solid fa-user-plus me-2"></i>
                    <span class="d-none d-sm-inline">Tambah Orang Tua Baru</span>
                    <span class="d-inline d-sm-none">Tambah</span>
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive p-2 p-md-3">
                
                <table class="table orangtua-table table-hover" id="orangtuaTable" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 5%;">No.</th>
                            <th style="width: 30%;">Nama Orang Tua</th>
                            <th style="width: 30%;">Nama Siswa</th>
                            <th style="width: 15%;">Hubungan</th>
                            <th class="text-center" style="width: 20%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orangtua as $o)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td><strong>{{ $o->user->nama_lengkap ?? 'N/A' }}</strong></td>
                                <td>{{ $o->siswa->nama_siswa ?? 'N/A' }}</td>
                                <td><span class="badge bg-info">{{ $o->hubungan ?? '-' }}</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.orangtua.show', $o) }}" class="btn btn-info btn-sm" title="Lihat Detail">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.orangtua.edit', $o) }}" class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fa-solid fa-pencil-alt"></i>
                                        </a>
                                        <button class="btn btn-danger btn-sm" 
                                                title="Hapus" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteOrangtuaModal"
                                                data-orangtua-name="{{ $o->user->nama_lengkap ?? 'N/A' }}"
                                                data-delete-url="{{ route('admin.orangtua.destroy', $o) }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data orang tua ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteOrangtuaModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Hapus Orang Tua</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="modal-body-text">Apakah Anda yakin ingin menghapus data orang tua ini? Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteOrangtuaForm" method="POST" action="">
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
    <script src="{{ asset('admin/orangtua.js') }}" defer></script>
@endpush
