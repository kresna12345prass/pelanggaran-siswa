@extends('admin.layouts.app')

@section('title', 'Detail Tahun Ajaran: ' . $tahun_ajaran->tahun_ajaran)

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/tahun_ajaran.css') }}">
@endpush

@section('content')
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Tahun Ajaran</h1>
        <a href="{{ route('admin.tahun_ajaran.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fa-solid fa-arrow-left me-2"></i>
            Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card ta-detail-card shadow-sm h-100">
                <div class="card-header py-3 bg-light d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold text-primary">
                        <i class="fa-solid fa-info-circle me-2"></i>
                        Informasi: {{ $tahun_ajaran->tahun_ajaran }} - {{ $tahun_ajaran->semester }}
                    </h6>
                    @if($tahun_ajaran->status_aktif)
                        <span class="badge badge-status-aktif px-3 py-2">
                            <i class="fa-solid fa-check-circle me-1"></i> TAHUN AJARAN AKTIF
                        </span>
                    @else
                        <span class="badge badge-status-nonaktif px-3 py-2">
                            <i class="fa-solid fa-times-circle me-1"></i> NON-AKTIF
                        </span>
                    @endif
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="detail-item">
                                <small class="text-muted d-block mb-1">Kode Ajaran</small>
                                <strong>{{ $tahun_ajaran->kode_ajaran }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <small class="text-muted d-block mb-1">Tahun Ajaran</small>
                                <strong>{{ $tahun_ajaran->tahun_ajaran }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <small class="text-muted d-block mb-1">Semester</small>
                                <strong>{{ $tahun_ajaran->semester }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <small class="text-muted d-block mb-1">Status</small>
                                <strong>{{ $tahun_ajaran->status_aktif ? 'Aktif' : 'Non-Aktif' }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <small class="text-muted d-block mb-1">Tanggal Mulai</small>
                                <strong>{{ $tahun_ajaran->tanggal_mulai ? \Carbon\Carbon::parse($tahun_ajaran->tanggal_mulai)->format('d M Y') : '-' }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <small class="text-muted d-block mb-1">Tanggal Selesai</small>
                                <strong>{{ $tahun_ajaran->tanggal_selesai ? \Carbon\Carbon::parse($tahun_ajaran->tanggal_selesai)->format('d M Y') : '-' }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.tahun_ajaran.edit', $tahun_ajaran) }}" class="btn btn-warning">
                        <i class="fa-solid fa-pencil-alt me-2"></i>Edit Tahun Ajaran
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection