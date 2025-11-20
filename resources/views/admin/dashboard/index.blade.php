@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')

@push('styles')
    <!-- Panggil CSS khusus untuk halaman ini -->
    @vite('resources/css/admin/dashboard.css')
@endpush

@section('content')

    <h1 class="h3 mb-4 text-gray-800">Dashboard Admin</h1>

    <!-- Statistik Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-card-content">
                        <h5>Users</h5>
                        <div class="stat-number">{{ $stats['total_users'] }}</div>
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
                        <h5>Siswa</h5>
                        <div class="stat-number">{{ $stats['total_siswa'] }}</div>
                    </div>
                    <div class="stat-card-icon icon-success">
                        <i class="fa-solid fa-user-graduate"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-card-content">
                        <h5>Kelas</h5>
                        <div class="stat-number">{{ $stats['total_kelas'] }}</div>
                    </div>
                    <div class="stat-card-icon icon-info">
                        <i class="fa-solid fa-school"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-card-content">
                        <h5>Tahun Ajaran</h5>
                        <div class="stat-number">{{ $stats['total_tahun_ajaran'] }}</div>
                    </div>
                    <div class="stat-card-icon icon-warning">
                        <i class="fa-solid fa-calendar-days"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-card-content">
                        <h5>Orang Tua</h5>
                        <div class="stat-number">{{ $stats['total_orangtua'] }}</div>
                    </div>
                    <div class="stat-card-icon icon-secondary">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-card-content">
                        <h5>Guru</h5>
                        <div class="stat-number">{{ $stats['total_guru'] }}</div>
                    </div>
                    <div class="stat-card-icon icon-purple">
                        <i class="fa-solid fa-chalkboard-user"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-card-content">
                        <h5>Wali Kelas</h5>
                        <div class="stat-number">{{ $stats['total_wali_kelas'] }}</div>
                    </div>
                    <div class="stat-card-icon icon-cyan">
                        <i class="fa-solid fa-user-check"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-card-content">
                        <h5>Jurusan</h5>
                        <div class="stat-number">{{ $stats['total_jurusan'] }}</div>
                    </div>
                    <div class="stat-card-icon icon-teal">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-card-content">
                        <h5>Kategori Pelanggaran</h5>
                        <div class="stat-number">{{ $stats['total_kategori_pelanggaran'] }}</div>
                    </div>
                    <div class="stat-card-icon icon-orange">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-card-content">
                        <h5>Aturan Pelanggaran</h5>
                        <div class="stat-number">{{ $stats['total_aturan_pelanggaran'] }}</div>
                    </div>
                    <div class="stat-card-icon icon-danger">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-card-content">
                        <h5>Aturan Sanksi</h5>
                        <div class="stat-number">{{ $stats['total_aturan_sanksi'] }}</div>
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
                        <h5>Tata Tertib</h5>
                        <div class="stat-number">{{ $stats['total_tata_tertib'] }}</div>
                    </div>
                    <div class="stat-card-icon icon-indigo">
                        <i class="fa-solid fa-book"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-card-content">
                        <h5>Jenis Prestasi</h5>
                        <div class="stat-number">{{ $stats['total_jenis_prestasi'] }}</div>
                    </div>
                    <div class="stat-card-icon icon-success">
                        <i class="fa-solid fa-trophy"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Statistik -->
    <div class="row mb-4">
        <div class="col-lg-6 col-md-6">
            <div class="chart-container">
                <h5 class="card-title fw-bold">Siswa per Kelas</h5>
                <div style="height: 300px;">
                    <canvas id="siswaPerKelasChart" 
                            data-labels="{{ $charts['kelas_labels'] }}" 
                            data-data="{{ $charts['kelas_data'] }}">
                    </canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="chart-container">
                <h5 class="card-title fw-bold">User per Role</h5>
                <div style="height: 300px;">
                    <canvas id="userRoleChart"
                            data-labels="{{ $charts['role_labels'] }}"
                            data-data="{{ $charts['role_data'] }}">
                    </canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-lg-6 col-md-6">
            <div class="chart-container">
                <h5 class="card-title fw-bold">Top Pelanggaran</h5>
                <div style="height: 300px;">
                    <canvas id="pelanggaranChart" 
                            data-labels="{{ $charts['pelanggaran_labels'] }}" 
                            data-data="{{ $charts['pelanggaran_data'] }}">
                    </canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="chart-container">
                <h5 class="card-title fw-bold">Sanksi Bertahap</h5>
                <div style="height: 300px;">
                    <canvas id="sanksiChart"
                            data-labels="{{ $charts['sanksi_labels'] }}"
                            data-data="{{ $charts['sanksi_data'] }}">
                    </canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-lg-6 col-md-6">
            <div class="chart-container">
                <h5 class="card-title fw-bold">Kelas per Jurusan</h5>
                <div style="height: 300px;">
                    <canvas id="kelasJurusanChart"
                            data-labels="{{ $charts['jurusan_labels'] }}"
                            data-data="{{ $charts['jurusan_data'] }}">
                    </canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="chart-container">
                <h5 class="card-title fw-bold">Tahun Ajaran</h5>
                <div style="height: 300px;">
                    <canvas id="tahunAjaranChart"
                            data-labels="{{ $charts['tahun_labels'] }}"
                            data-data="{{ $charts['tahun_data'] }}">
                    </canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-lg-6 col-md-6">
            <div class="chart-container">
                <h5 class="card-title fw-bold">Kategori Pelanggaran</h5>
                <div style="height: 300px;">
                    <canvas id="kategoriPelanggaranChart"
                            data-labels="{{ $charts['kategori_labels'] }}"
                            data-data="{{ $charts['kategori_data'] }}">
                    </canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="chart-container">
                <h5 class="card-title fw-bold">Range Poin Sanksi</h5>
                <div style="height: 300px;">
                    <canvas id="rangePoinChart"
                            data-labels="{{ $charts['range_labels'] }}"
                            data-data="{{ $charts['range_data'] }}">
                    </canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Panggil Chart.js (pastikan sudah di-install: npm install chart.js) -->
    <!-- Panggil JS khusus untuk halaman ini -->
    @vite('resources/js/admin/dashboard.js')
@endpush