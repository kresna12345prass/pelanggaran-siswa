@extends('kesiswaan.layouts.app')
@section('title', 'Dashboard Kesiswaan')

@push('styles')
    @vite('resources/css/kesiswaan/dashboard.css')
@endpush

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <h1 class="page-title">Dashboard Kesiswaan</h1>
        <p class="page-subtitle">Selamat datang, {{ Auth::user()->nama_lengkap }}</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-card-content">
                        <h5>Menunggu Verifikasi</h5>
                        <div class="stat-number">{{ $stats['menunggu'] }}</div>
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
                        <h5>Terverifikasi</h5>
                        <div class="stat-number">{{ $stats['diverifikasi'] }}</div>
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
                        <h5>Sanksi Berjalan</h5>
                        <div class="stat-number">{{ $stats['sanksi_berjalan'] }}</div>
                    </div>
                    <div class="stat-card-icon icon-danger">
                        <i class="fa-solid fa-gavel"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-card-content">
                        <h5>Sanksi Selesai</h5>
                        <div class="stat-number">{{ $stats['sanksi_selesai'] }}</div>
                    </div>
                    <div class="stat-card-icon icon-info">
                        <i class="fa-solid fa-check-double"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-card-content">
                        <h5>Total Prestasi</h5>
                        <div class="stat-number">{{ $stats['total_prestasi'] }}</div>
                    </div>
                    <div class="stat-card-icon icon-success">
                        <i class="fa-solid fa-trophy"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="chart-container">
                <h5 class="card-title fw-bold">Status Verifikasi</h5>
                <div style="height: 300px;">
                    <canvas id="verifikasiChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="chart-container">
                <h5 class="card-title fw-bold">Status Sanksi</h5>
                <div style="height: 300px;">
                    <canvas id="sanksiChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    @vite('resources/js/kesiswaan/dashboard.js')
@endpush
