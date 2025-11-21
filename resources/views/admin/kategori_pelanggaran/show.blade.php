@extends('admin.layouts.app')

@section('title', 'Detail Kategori Pelanggaran')

@push('styles')
    @vite('resources/css/admin/kategori_pelanggaran.css')
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Kategori</h1>
        <a href="{{ route('admin.kategori_pelanggaran.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fa-solid fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header py-3 bg-light d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-primary"><i class="fa-solid fa-list me-2"></i>{{ $kategori->nama_kategori }}</h6>
        </div>
        <div class="card-body p-4">
             <div class="row g-3">
                <div class="col-md-6">
                    <div class="detail-item">
                        <small class="text-muted d-block mb-1">Nama Kategori</small>
                        <strong>{{ $kategori->nama_kategori }}</strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-item">
                        <small class="text-muted d-block mb-1">Kategori Induk</small>
                        <strong>{{ $kategori->kategori_induk ?? '-' }}</strong>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer bg-light d-flex justify-content-end gap-2">
            <a href="{{ route('admin.kategori_pelanggaran.edit', $kategori) }}" class="btn btn-warning">
                <i class="fa-solid fa-pencil-alt me-2"></i>Edit
            </a>
        </div>
    </div>
@endsection
