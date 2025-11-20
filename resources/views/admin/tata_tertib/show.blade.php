@extends('admin.layouts.app')

@section('title', 'Detail Tata Tertib')

@push('styles')
    @vite('resources/css/admin/tata_tertib.css')
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Tata Tertib</h1>
        <a href="{{ route('admin.tata_tertib.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fa-solid fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <div class="card aturan-detail-card shadow-sm mb-4">
        <div class="card-header py-3 bg-light d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-primary"><i class="fa-solid fa-book-open me-2"></i>{{ $tataTertib->pasal }}</h6>
            <span class="badge bg-info">{{ ucfirst($tataTertib->tipe) }}</span>
        </div>
        <div class="card-body p-4">
             <div class="row g-3">
                <div class="col-md-6">
                    <div class="detail-item">
                        <small class="text-muted d-block mb-1">Pasal</small>
                        <strong>{{ $tataTertib->pasal }}</strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-item">
                        <small class="text-muted d-block mb-1">Tipe</small>
                        <strong>{{ ucfirst($tataTertib->tipe) }}</strong>
                    </div>
                </div>
                <div class="col-12">
                    <div class="detail-item">
                        <small class="text-muted d-block mb-1">Judul</small>
                        <strong>{{ $tataTertib->judul }}</strong>
                    </div>
                </div>
                <div class="col-12">
                    <div class="detail-item">
                        <small class="text-muted d-block mb-1">Urutan</small>
                        <strong>{{ $tataTertib->urutan }}</strong>
                    </div>
                </div>
                <div class="col-12">
                    <div class="detail-item">
                        <small class="text-muted d-block mb-1">Konten Teks</small>
                        <p class="mb-0">{{ $tataTertib->konten_teks ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer bg-light d-flex justify-content-end gap-2">
            <a href="{{ route('admin.tata_tertib.edit', $tataTertib) }}" class="btn btn-warning">
                <i class="fa-solid fa-pencil-alt me-2"></i>Edit
            </a>
        </div>
    </div>
@endsection
