@extends('admin.layouts.app')

@section('title', 'Detail Pengguna: ' . $user->nama_lengkap)

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/users.css') }}">
@endpush

@section('content')
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Pengguna</h1>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fa-solid fa-arrow-left me-2"></i>
            Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card user-detail-card shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->nama_lengkap) }}&background=0d6efd&color=fff&size=150" 
                         alt="{{ $user->nama_lengkap }}" class="rounded-circle mb-3 shadow-sm"
                         style="width: 150px; height: 150px;">
                    <h4 class="fw-bold mb-2">{{ $user->nama_lengkap }}</h4>
                    <p class="text-muted mb-1"><i class="fa-solid fa-user me-2"></i>{{ $user->username }}</p>
                    <p class="text-primary mb-3"><i class="fa-solid fa-envelope me-2"></i>{{ $user->email }}</p>
                    
                    @php
                        $badgeClass = 'bg-level-unknown';
                        if ($user->level == 'admin') $badgeClass = 'bg-level-admin';
                        if ($user->level == 'kepsek') $badgeClass = 'bg-level-kepsek';
                        if ($user->level == 'guru') $badgeClass = 'bg-level-guru';
                        if ($user->level == 'siswa') $badgeClass = 'bg-level-siswa';
                        if ($user->level == 'ortu') $badgeClass = 'bg-level-ortu';
                    @endphp
                    <span class="badge {{ $badgeClass }} px-3 py-2">{{ ucfirst($user->level) }}</span>
                </div>
            </div>
        </div>

        <div class="col-lg-8 mb-4">
            <div class="card user-detail-card shadow-sm h-100">
                <div class="card-header py-3 bg-light">
                    <h6 class="m-0 fw-bold text-primary"><i class="fa-solid fa-info-circle me-2"></i>Informasi Akun</h6>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="detail-item">
                                <small class="text-muted d-block mb-1">Nama Lengkap</small>
                                <strong>{{ $user->nama_lengkap }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <small class="text-muted d-block mb-1">Username</small>
                                <strong>{{ $user->username }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <small class="text-muted d-block mb-1">Email</small>
                                <strong>{{ $user->email }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <small class="text-muted d-block mb-1">Level (Peran)</small>
                                <strong>{{ ucfirst($user->level) }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <small class="text-muted d-block mb-1">Spesialisasi</small>
                                <strong>{{ $user->spesialisasi ?? '-' }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <small class="text-muted d-block mb-1">Hak Verifikasi</small>
                                @if($user->can_verify)
                                    <span class="badge bg-success">Ya</span>
                                @else
                                    <span class="badge bg-secondary">Tidak</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <small class="text-muted d-block mb-1">Akun Dibuat</small>
                                <strong>{{ $user->created_at->format('d M Y, H:i') }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <small class="text-muted d-block mb-1">Terakhir Diperbarui</small>
                                <strong>{{ $user->updated_at->format('d M Y, H:i') }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
                        <i class="fa-solid fa-pencil-alt me-2"></i>Edit Pengguna
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection