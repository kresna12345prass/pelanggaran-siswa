@extends('guru.layouts.app')

@section('title', 'Dashboard Guru')

@push('styles')
    @vite('resources/css/guru/dashboard.css')
@endpush

@section('content')
<div class="container-fluid">
    
    <div class="page-header">
        <h1 class="page-title">Dashboard Guru</h1>
        <p class="page-subtitle">Selamat datang, {{ Auth::user()->nama_lengkap }}</p>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-card-content">
                        <h5>Total Laporan</h5>
                        <div class="stat-number">{{ $totalLaporan }}</div>
                    </div>
                    <div class="stat-card-icon icon-primary">
                        <i class="fa-solid fa-file-lines"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-card-content">
                        <h5>Menunggu Verifikasi</h5>
                        <div class="stat-number">{{ $laporanMenunggu }}</div>
                    </div>
                    <div class="stat-card-icon icon-warning">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-card-content">
                        <h5>Disetujui</h5>
                        <div class="stat-number">{{ $laporanDisetujui }}</div>
                    </div>
                    <div class="stat-card-icon icon-success">
                        <i class="fa-solid fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-card-content">
                        <h5>Ditolak</h5>
                        <div class="stat-number">{{ $laporanDitolak }}</div>
                    </div>
                    <div class="stat-card-icon icon-danger">
                        <i class="fa-solid fa-times-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="fa-solid fa-calendar-check me-2"></i>
                        Statistik Bulan Ini
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fa-solid fa-info-circle me-2"></i>
                        Anda telah melaporkan <strong>{{ $laporanBulanIni }}</strong> pelanggaran pada bulan {{ date('F Y') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
    @vite('resources/js/guru/dashboard.js')
@endpush
