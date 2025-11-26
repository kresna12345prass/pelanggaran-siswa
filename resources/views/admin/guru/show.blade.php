@extends('admin.layouts.app')

@section('title', 'Detail Guru')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/guru.css') }}">
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Guru</h1>
        <a href="{{ route('admin.guru.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fa-solid fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header py-3 bg-light d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-primary"><i class="fa-solid fa-chalkboard-user me-2"></i>{{ $guru->nama_guru }}</h6>
            <span class="badge bg-success">{{ $guru->status ?? 'Aktif' }}</span>
        </div>
        <div class="card-body p-4">
             <div class="row g-3">
                <div class="col-md-6">
                    <div class="detail-item">
                        <small class="text-muted d-block mb-1">NIP</small>
                        <strong>{{ $guru->nip }}</strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-item">
                        <small class="text-muted d-block mb-1">Nama Guru</small>
                        <strong>{{ $guru->nama_guru }}</strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-item">
                        <small class="text-muted d-block mb-1">Jenis Kelamin</small>
                        <strong>{{ $guru->jenis_kelamin ?? '-' }}</strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-item">
                        <small class="text-muted d-block mb-1">Bidang Studi</small>
                        <strong>{{ $guru->bidang_studi ?? '-' }}</strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-item">
                        <small class="text-muted d-block mb-1">Status</small>
                        <strong>{{ $guru->status ?? 'Aktif' }}</strong>
                    </div>
                </div>
                <div class="col-12">
                    <div class="detail-item">
                        <small class="text-muted d-block mb-1">No. Telepon</small>
                        <strong>{{ $guru->no_telepon ?? '-' }}</strong>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer bg-light d-flex justify-content-end gap-2">
            <a href="{{ route('admin.guru.edit', $guru) }}" class="btn btn-warning">
                <i class="fa-solid fa-pencil-alt me-2"></i>Edit
            </a>
        </div>
    </div>
@endsection
