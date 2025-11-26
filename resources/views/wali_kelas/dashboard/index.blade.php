@extends('wali_kelas.layouts.app')

@section('title', 'Dashboard Wali Kelas')

@push('styles')
    <link rel="stylesheet" href="{{ asset('wali_kelas/dashboard.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    
    <div class="page-header">
        <h1 class="page-title">Dashboard Wali Kelas</h1>
        <p class="page-subtitle">Selamat datang, {{ Auth::user()->nama_lengkap }} - Wali Kelas {{ $kelas ? $kelas->nama_kelas : '-' }}</p>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-card-content">
                        <h5>Total Siswa</h5>
                        <div class="stat-number">{{ $totalSiswa }}</div>
                    </div>
                    <div class="stat-card-icon icon-primary">
                        <i class="fa-solid fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-card-content">
                        <h5>Total Pelanggaran</h5>
                        <div class="stat-number">{{ $totalPelanggaran }}</div>
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
                        <h5>Total Prestasi</h5>
                        <div class="stat-number">{{ $totalPrestasi }}</div>
                    </div>
                    <div class="stat-card-icon icon-success">
                        <i class="fa-solid fa-trophy"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-card-content">
                        <h5>Total Sanksi</h5>
                        <div class="stat-number">{{ $totalSanksi }}</div>
                    </div>
                    <div class="stat-card-icon icon-warning">
                        <i class="fa-solid fa-gavel"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-card-content">
                        <h5>Siswa Aman</h5>
                        <div class="stat-number">{{ $siswaAman }}</div>
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
                        <h5>Siswa Lampu Kuning</h5>
                        <div class="stat-number">{{ $siswaLampuKuning }}</div>
                    </div>
                    <div class="stat-card-icon icon-warning">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-card-content">
                        <h5>Siswa Kritis</h5>
                        <div class="stat-number">{{ $siswaKritis }}</div>
                    </div>
                    <div class="stat-card-icon icon-danger">
                        <i class="fa-solid fa-circle-exclamation"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-card-content">
                        <h5>Laporan Baru</h5>
                        <div class="stat-number">{{ $laporanBaru }}</div>
                    </div>
                    <div class="stat-card-icon icon-info">
                        <i class="fa-solid fa-bell"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="fa-solid fa-chart-pie me-2"></i>
                        Status Siswa Kelas
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="statusSiswaChart" width="400" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="fa-solid fa-chart-bar me-2"></i>
                        Pelanggaran per Kategori
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="pelanggaranKategoriChart" width="400" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const statusSiswaCtx = document.getElementById('statusSiswaChart').getContext('2d');
        const statusSiswaChart = new Chart(statusSiswaCtx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($chartStatusSiswa['labels']) !!},
                datasets: [{
                    data: {!! json_encode($chartStatusSiswa['data']) !!},
                    backgroundColor: {!! json_encode($chartStatusSiswa['colors']) !!},
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.parsed / total) * 100).toFixed(1);
                                return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });

        const pelanggaranKategoriCtx = document.getElementById('pelanggaranKategoriChart').getContext('2d');
        const pelanggaranKategoriChart = new Chart(pelanggaranKategoriCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartPelanggaranKategori['labels']) !!},
                datasets: [{
                    label: 'Jumlah Pelanggaran',
                    data: {!! json_encode($chartPelanggaranKategori['data']) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.8)',
                    borderColor: 'rgba(54, 162, 235, 1)',
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
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
    <script src="{{ asset('wali_kelas/dashboard.js') }}" defer></script>
@endpush
