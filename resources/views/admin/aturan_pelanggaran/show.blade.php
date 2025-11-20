@extends('admin.layouts.app')

@section('title', 'Detail Aturan Pelanggaran')

@push('styles')
    @vite('resources/css/admin/aturan_pelanggaran.css')
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Aturan</h1>
        <a href="{{ route('admin.aturan_pelanggaran.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fa-solid fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <div class="card aturan-detail-card shadow-sm mb-4">
        <div class="card-header py-3 bg-light d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-primary"><i class="fa-solid fa-gavel me-2"></i>{{ $aturan->nama_pelanggaran }}</h6>
            <span class="badge poin-badge">{{ $aturan->poin }} Poin</span>
        </div>
        <div class="card-body p-4">
             <div class="row g-3">
                <div class="col-12">
                    <div class="detail-item">
                        <small class="text-muted d-block mb-1">Nama Pelanggaran</small>
                        <strong>{{ $aturan->nama_pelanggaran }}</strong>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="detail-item">
                        <small class="text-muted d-block mb-1">Poin</small>
                        <strong class="text-danger fs-5">{{ $aturan->poin }}</strong>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="detail-item">
                        <small class="text-muted d-block mb-1">Kategori Induk</small>
                        <strong>{{ $aturan->kategori?->kategori_induk ?? '-' }}</strong>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="detail-item">
                        <small class="text-muted d-block mb-1">Kategori</small>
                        <strong>{{ $aturan->kategori?->nama_kategori ?? '-' }}</strong>
                    </div>
                </div>
                <div class="col-12">
                    <div class="detail-item">
                        <small class="text-muted d-block mb-1">Sanksi Rekomendasi</small>
                        <strong>{{ $aturan->sanksi ?? '-' }}</strong>
                    </div>
                </div>
                <div class="col-12">
                    <div class="detail-item">
                        <small class="text-muted d-block mb-1">Keterangan</small>
                        <p class="mb-0">{{ $aturan->keterangan ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer bg-light d-flex justify-content-end gap-2">
            <a href="{{ route('admin.aturan_pelanggaran.edit', $aturan) }}" class="btn btn-warning">
                <i class="fa-solid fa-pencil-alt me-2"></i>Edit
            </a>
        </div>
    </div>
@endsection