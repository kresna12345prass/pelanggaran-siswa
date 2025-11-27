@extends('bk.layouts.app')

@section('title', 'Dashboard BK')

@push('styles')
    <link rel="stylesheet" href="{{ asset('bk/dashboard.css') }}">
    <style>
        .chart-container {
            position: relative;
            height: 400px;
        }
    </style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <h1 class="page-title">Dashboard BK</h1>
        <p class="page-subtitle">Selamat datang, {{ Auth::user()->nama_lengkap }}</p>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-card-content">
                        <h5>Total Konseling</h5>
                        <div class="stat-number">{{ $stats['total_konseling'] }}</div>
                    </div>
                    <div class="stat-card-icon icon-primary">
                        <i class="fa-solid fa-comments"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-card-content">
                        <h5>Konseling Aktif</h5>
                        <div class="stat-number">{{ $stats['konseling_aktif'] }}</div>
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
                        <h5>Konseling Selesai</h5>
                        <div class="stat-number">{{ $stats['konseling_selesai'] }}</div>
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
                        <h5>Siswa Bermasalah</h5>
                        <div class="stat-number">{{ $stats['siswa_bermasalah'] }}</div>
                    </div>
                    <div class="stat-card-icon icon-danger">
                        <i class="fa-solid fa-exclamation-triangle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Grafik Pelanggaran Tahun {{ date('Y') }}</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="pelanggaranChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Distribusi Jenis Pelanggaran</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="jenisPelanggaranChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Trend Bimbingan Konseling Tahun {{ date('Y') }}</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="konselingChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        window.chartData = @json($chartData);
        window.jenisPelanggaranLabels = @json($jenisPelanggaranLabels);
        window.jenisPelanggaranCounts = @json($jenisPelanggaranCounts);
        window.konselingChartData = @json($konselingChartData);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('bk/dashboard.js') }}"></script>
@endpush
