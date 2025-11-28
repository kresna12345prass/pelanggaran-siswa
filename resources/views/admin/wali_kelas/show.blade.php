@extends('admin.layouts.app')

@section('title', 'Detail Wali Kelas')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/wali_kelas.css') }}">
@endpush

@section('content')
    
    <div class="mb-4">
        <h1 class="h3 mb-1 text-gray-800">Detail Wali Kelas</h1>
        <p class="text-muted mb-0 small">Informasi detail penugasan wali kelas</p>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 fw-bold text-dark"><i class="fa-solid fa-info-circle me-2"></i>Informasi Wali Kelas</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tahun Ajaran</label>
                                <p class="form-control-plaintext">
                                    <span class="badge bg-primary">{{ $waliKelas->tahunAjaran->tahun_ajaran }} - {{ $waliKelas->tahunAjaran->semester }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Guru</label>
                                <p class="form-control-plaintext">{{ $waliKelas->guru->nama_guru }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">NIP</label>
                                <p class="form-control-plaintext">{{ $waliKelas->guru->nip }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Kelas</label>
                                <p class="form-control-plaintext">{{ $waliKelas->kelas->nama_kelas }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Jurusan</label>
                                <p class="form-control-plaintext">
                                    <span class="badge bg-secondary">{{ $waliKelas->kelas->jurusan?->nama_jurusan ?? '-' }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Jumlah Siswa</label>
                                <p class="form-control-plaintext">{{ $waliKelas->kelas->siswa->count() }} siswa</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-header py-3">
                    <h6 class="m-0 fw-bold text-dark"><i class="fa-solid fa-cogs me-2"></i>Aksi</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.wali_kelas.edit', $waliKelas) }}" class="btn btn-warning">
                            <i class="fa-solid fa-pencil-alt me-2"></i>Edit Data
                        </a>
                        <button class="btn btn-danger" 
                                data-bs-toggle="modal" 
                                data-bs-target="#deleteWaliKelasModal"
                                data-wali-kelas-name="{{ $waliKelas->guru->nama_guru }} - {{ $waliKelas->kelas->nama_kelas }}"
                                data-delete-url="{{ route('admin.wali_kelas.destroy', $waliKelas) }}">
                            <i class="fa-solid fa-trash me-2"></i>Hapus Data
                        </button>
                        <a href="{{ route('admin.wali_kelas.index') }}" class="btn btn-secondary">
                            <i class="fa-solid fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Hapus -->
    <div class="modal fade" id="deleteWaliKelasModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Hapus Wali Kelas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="modal-body-text">Apakah Anda yakin ingin menghapus penugasan wali kelas ini? Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteWaliKelasForm" method="POST" action="">
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
    <script src="{{ asset('admin/wali_kelas.js') }}" defer></script>
@endpush
