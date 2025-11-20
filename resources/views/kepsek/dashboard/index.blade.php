@extends('kepsek.layouts.app')

@section('title', 'Dashboard Kepala Sekolah')

@push('styles')
    @vite('resources/css/kepsek/dashboard.css')
@endpush

@section('content')

    <h1 class="h3 mb-4 text-gray-800">Dashboard Eksekutif - Kepala Sekolah</h1>

    <div class="row">
        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-card-content">
                        <h5>Total Pelanggaran</h5>
                        <div class="stat-number">{{ $stats['total_pelanggaran'] }}</div>
                    </div>
                    <div class="stat-card-icon icon-danger">
                        <i class="fa-solid fa-exclamation-triangle"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-card-content">
                        <h5>Siswa Bermasalah</h5>
                        <div class="stat-number">{{ $stats['total_siswa_bermasalah'] }}</div>
                    </div>
                    <div class="stat-card-icon icon-warning">
                        <i class="fa-solid fa-user-slash"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-card-content">
                        <h5>Kasus Berat</h5>
                        <div class="stat-number">{{ $stats['kasus_berat'] }}</div>
                    </div>
                    <div class="stat-card-icon icon-dark">
                        <i class="fa-solid fa-gavel"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-card-content">
                        <h5>Total Monitoring</h5>
                        <div class="stat-number">{{ $stats['total_monitoring'] }}</div>
                    </div>
                    <div class="stat-card-icon icon-info">
                        <i class="fa-solid fa-clipboard-check"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-lg-6 col-md-6">
            <div class="chart-container">
                <h5 class="card-title fw-bold">Tren Pelanggaran (6 Bulan Terakhir)</h5>
                <div style="height: 300px;">
                    <canvas id="trendChart" 
                            data-labels="{{ $charts['trend_labels'] }}" 
                            data-data="{{ $charts['trend_data'] }}">
                    </canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="chart-container">
                <h5 class="card-title fw-bold">Kategori Pelanggaran Terbanyak</h5>
                <div style="height: 300px;">
                    <canvas id="kategoriChart"
                            data-labels="{{ $charts['kategori_labels'] }}"
                            data-data="{{ $charts['kategori_data'] }}">
                    </canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-lg-6 col-md-6">
            <div class="chart-container">
                <h5 class="card-title fw-bold">Pelanggaran per Kelas</h5>
                <div style="height: 300px;">
                    <canvas id="kelasChart" 
                            data-labels="{{ $charts['kelas_labels'] }}" 
                            data-data="{{ $charts['kelas_data'] }}">
                    </canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="chart-container">
                <h5 class="card-title fw-bold">Status Verifikasi</h5>
                <div style="height: 300px;">
                    <canvas id="statusChart"
                            data-labels="{{ $charts['status_labels'] }}"
                            data-data="{{ $charts['status_data'] }}">
                    </canvas>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    @vite('resources/js/kepsek/dashboard.js')
@endpush
