@extends('admin.layouts.app')

@section('title', 'Detail Jurusan')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/jurusan.css') }}">
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Jurusan</h1>
        <a href="{{ route('admin.jurusan.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fa-solid fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header py-3 bg-light d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-primary"><i class="fa-solid fa-graduation-cap me-2"></i>{{ $jurusan->nama_jurusan }}</h6>
            <span class="badge bg-primary">{{ $jurusan->kode_jurusan }}</span>
        </div>
        <div class="card-body p-4">
             <div class="row g-3">
                <div class="col-md-6">
                    <div class="detail-item">
                        <small class="text-muted d-block mb-1">Kode Jurusan</small>
                        <strong>{{ $jurusan->kode_jurusan }}</strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-item">
                        <small class="text-muted d-block mb-1">Nama Jurusan</small>
                        <strong>{{ $jurusan->nama_jurusan }}</strong>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer bg-light d-flex justify-content-end gap-2">
            <a href="{{ route('admin.jurusan.edit', $jurusan) }}" class="btn btn-warning">
                <i class="fa-solid fa-pencil-alt me-2"></i>Edit
            </a>
        </div>
    </div>
@endsection
