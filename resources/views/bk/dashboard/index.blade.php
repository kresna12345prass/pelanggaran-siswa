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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        window.addEventListener('load', function() {
            // Grafik Pelanggaran
            const ctx = document.getElementById('pelanggaranChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                        datasets: [{
                            label: 'Jumlah Pelanggaran',
                            data: @json($chartData),
                            backgroundColor: 'rgba(220, 53, 69, 0.8)',
                            borderColor: 'rgba(220, 53, 69, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });
            }

            // Grafik Jenis Pelanggaran
            const jenisPelanggaranCtx = document.getElementById('jenisPelanggaranChart');
            if (jenisPelanggaranCtx) {
                new Chart(jenisPelanggaranCtx, {
                    type: 'pie',
                    data: {
                        labels: @json($jenisPelanggaranLabels),
                        datasets: [{
                            label: 'Jumlah Pelanggaran',
                            data: @json($jenisPelanggaranCounts),
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.6)',
                                'rgba(54, 162, 235, 0.6)',
                                'rgba(255, 206, 86, 0.6)',
                                'rgba(75, 192, 192, 0.6)',
                                'rgba(153, 102, 255, 0.6)',
                                'rgba(255, 159, 64, 0.6)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                            }
                        }
                    }
                });
            }

            // Grafik Konseling
            const konselingCtx = document.getElementById('konselingChart');
            if (konselingCtx) {
                new Chart(konselingCtx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                        datasets: [{
                            label: 'Jumlah Konseling',
                            data: @json($konselingChartData),
                            backgroundColor: 'rgba(40, 167, 69, 0.2)',
                            borderColor: 'rgba(40, 167, 69, 1)',
                            borderWidth: 2,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
@endpush
