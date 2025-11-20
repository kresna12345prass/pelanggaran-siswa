@extends('admin.layouts.app')

@section('title', 'Detail Orang Tua: ' . ($orangtua->user->nama_lengkap ?? 'N/A'))

@push('styles')
    @vite('resources/css/admin/orangtua.css')
@endpush

@section('content')
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Orang Tua</h1>
        <a href="{{ route('admin.orangtua.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fa-solid fa-arrow-left me-2"></i>
            Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card orangtua-detail-card shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($orangtua->user->nama_lengkap ?? 'N/A') }}&background=198754&color=fff&size=150" 
                         alt="{{ $orangtua->user->nama_lengkap ?? 'N/A' }}" class="rounded-circle mb-3 shadow-sm"
                         style="width: 150px; height: 150px;">
                    
                    <h4 class="fw-bold mb-2">{{ $orangtua->user->nama_lengkap ?? 'N/A' }}</h4>
                    <p class="text-muted mb-1"><i class="fa-solid fa-user me-2"></i>{{ $orangtua->user->username ?? 'N/A' }}</p>
                    <p class="text-primary mb-3"><i class="fa-solid fa-envelope me-2"></i>{{ $orangtua->user->email ?? 'N/A' }}</p>
                    
                    <span class="badge fs-6 bg-success px-3 py-2">{{ $orangtua->hubungan ?? 'Orang Tua' }}</span>
                </div>
            </div>
        </div>

        <div class="col-lg-8 mb-4">
            <div class="card orangtua-detail-card shadow-sm h-100">
                <div class="card-header py-3 bg-light">
                    <h6 class="m-0 fw-bold text-primary"><i class="fa-solid fa-info-circle me-2"></i>Informasi Data Orang Tua</h6>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="detail-item">
                                <small class="text-muted d-block mb-1">Nama Lengkap</small>
                                <strong>{{ $orangtua->user->nama_lengkap ?? 'N/A' }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <small class="text-muted d-block mb-1">Username</small>
                                <strong>{{ $orangtua->user->username ?? 'N/A' }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <small class="text-muted d-block mb-1">Email</small>
                                <strong>{{ $orangtua->user->email ?? 'N/A' }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <small class="text-muted d-block mb-1">Nama Siswa (Anak)</small>
                                <strong>{{ $orangtua->siswa->nama_siswa ?? 'N/A' }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <small class="text-muted d-block mb-1">Hubungan</small>
                                <strong>{{ $orangtua->hubungan ?? '-' }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <small class="text-muted d-block mb-1">No Telepon</small>
                                <strong>{{ $orangtua->no_telepon ?? '-' }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <small class="text-muted d-block mb-1">Pendidikan</small>
                                <strong>{{ $orangtua->pendidikan ?? '-' }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <small class="text-muted d-block mb-1">Pekerjaan</small>
                                <strong>{{ $orangtua->pekerjaan ?? '-' }}</strong>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="detail-item">
                                <small class="text-muted d-block mb-1">Alamat</small>
                                <strong>{{ $orangtua->alamat ?? '-' }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.orangtua.edit', $orangtua) }}" class="btn btn-warning">
                        <i class="fa-solid fa-pencil-alt me-2"></i>Edit Data
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection
