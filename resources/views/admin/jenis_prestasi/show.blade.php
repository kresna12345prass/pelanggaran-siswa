@extends('admin.layouts.app')

@section('title', 'Detail Jenis Prestasi')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/jenis_prestasi.css') }}">
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Jenis Prestasi</h1>
        <a href="{{ route('admin.jenis_prestasi.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fa-solid fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-primary"><i class="fa-solid fa-trophy me-2"></i>{{ $jenisPrestasi->nama_prestasi }}</h6>
            <span class="badge bg-success">{{ $jenisPrestasi->poin }} Poin</span>
        </div>
        <div class="card-body p-4">
             <div class="row g-3">
                <div class="col-md-6">
                    <div class="detail-item">
                        <small class="text-muted d-block mb-1">Nama Prestasi</small>
                        <strong>{{ $jenisPrestasi->nama_prestasi }}</strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-item">
                        <small class="text-muted d-block mb-1">Kategori</small>
                        <strong>{{ $jenisPrestasi->kategori }}</strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-item">
                        <small class="text-muted d-block mb-1">Poin</small>
                        <strong>{{ $jenisPrestasi->poin }}</strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-item">
                        <small class="text-muted d-block mb-1">Penghargaan</small>
                        <strong>{{ $jenisPrestasi->penghargaan ?? '-' }}</strong>
                    </div>
                </div>
                <div class="col-12">
                    <div class="detail-item">
                        <small class="text-muted d-block mb-1">Keterangan</small>
                        <strong>{{ $jenisPrestasi->keterangan ?? '-' }}</strong>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end gap-2">
            <a href="{{ route('admin.jenis_prestasi.edit', $jenisPrestasi) }}" class="btn btn-warning">
                <i class="fa-solid fa-pencil-alt me-2"></i>Edit
            </a>
        </div>
    </div>
@endsection
