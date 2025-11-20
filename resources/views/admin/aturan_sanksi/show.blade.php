@extends('admin.layouts.app')

@section('title', 'Detail Aturan Sanksi')

@push('styles')
    @vite('resources/css/admin/aturan_sanksi.css')
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Aturan Sanksi</h1>
        <a href="{{ route('admin.aturan_sanksi.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fa-solid fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <div class="card aturan-detail-card shadow-sm mb-4">
        <div class="card-header py-3 bg-light d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-primary"><i class="fa-solid fa-scale-balanced me-2"></i>{{ $sanksi->nama_sanksi }}</h6>
            <span class="badge poin-badge">{{ $sanksi->poin_minimal }} - {{ $sanksi->poin_maksimal }} Poin</span>
        </div>
        <div class="card-body p-4">
             <div class="row g-3">
                <div class="col-md-6">
                    <div class="detail-item">
                        <small class="text-muted d-block mb-1">Kategori</small>
                        <span class="badge bg-primary fs-6">{{ $sanksi->kategori ?? 'Umum' }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-item">
                        <small class="text-muted d-block mb-1">Nama Sanksi</small>
                        <strong>{{ $sanksi->nama_sanksi }}</strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-item">
                        <small class="text-muted d-block mb-1">Poin Minimal</small>
                        <strong class="text-danger fs-5">{{ $sanksi->poin_minimal }}</strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-item">
                        <small class="text-muted d-block mb-1">Poin Maksimal</small>
                        <strong class="text-danger fs-5">{{ $sanksi->poin_maksimal }}</strong>
                    </div>
                </div>
                <div class="col-12">
                    <div class="detail-item">
                        <small class="text-muted d-block mb-1">Deskripsi Tindakan</small>
                        <p class="mb-0">{{ $sanksi->deskripsi_tindakan ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer bg-light d-flex justify-content-end gap-2">
            <a href="{{ route('admin.aturan_sanksi.edit', $sanksi) }}" class="btn btn-warning">
                <i class="fa-solid fa-pencil-alt me-2"></i>Edit
            </a>
        </div>
    </div>
@endsection
