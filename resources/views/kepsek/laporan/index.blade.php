@extends('kepsek.layouts.app')

@section('title', 'Dashboard Pemantauan Sekolah')

@push('styles')
    @vite('resources/css/kepsek/simple-dashboard.css')
@endpush

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Pemantauan</h1>
    </div>
    
    <!-- Simplified Navigation -->
    <ul class="nav nav-tabs mb-4" id="laporanTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab">
                <i class="fa-solid fa-tachometer-alt me-2"></i>Ringkasan Sekolah
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="laporan-tab" data-bs-toggle="tab" data-bs-target="#laporan" type="button" role="tab">
                <i class="fa-solid fa-download me-2"></i>Laporan & Export
            </button>
        </li>
    </ul>
    
    <div class="tab-content" id="laporanTabContent">
        <!-- Ringkasan Sekolah Tab -->
        <div class="tab-pane fade show active" id="overview" role="tabpanel">
            
            <!-- Key Metrics -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card border-left-danger shadow h-100 py-2 stat-card">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Pelanggaran</div>
                                    <div class="h4 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['total_pelanggaran']) }}</div>
                                    <small class="text-muted">{{ $stats['pelanggaran_bulan_ini'] }} bulan ini</small>
                                </div>
                                <div class="col-auto">
                                    <i class="fa-solid fa-exclamation-triangle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card border-left-warning shadow h-100 py-2 stat-card">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Siswa Bermasalah</div>
                                    <div class="h4 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['total_siswa_bermasalah']) }}</div>
                                    <small class="text-muted">Perlu perhatian</small>
                                </div>
                                <div class="col-auto">
                                    <i class="fa-solid fa-user-slash fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card border-left-primary shadow h-100 py-2 stat-card">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Monitoring Aktif</div>
                                    <div class="h4 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['monitoring_aktif']) }}</div>
                                    <small class="text-muted">Dalam pengawasan</small>
                                </div>
                                <div class="col-auto">
                                    <i class="fa-solid fa-eye fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card border-left-success shadow h-100 py-2 stat-card">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Konseling Selesai</div>
                                    <div class="h4 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['konseling_selesai']) }}</div>
                                    <small class="text-muted">Pembinaan berhasil</small>
                                </div>
                                <div class="col-auto">
                                    <i class="fa-solid fa-check-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <!-- Tren & Top Siswa -->
                <div class="col-lg-8">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Tren Pelanggaran (6 Bulan Terakhir)</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-container" style="height: 250px;">
                                <canvas id="trendChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Siswa Prioritas -->
                <div class="col-lg-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-danger">Siswa Prioritas Tinggi</h6>
                        </div>
                        <div class="card-body p-2">
                            @foreach($chartData['top_siswa']->take(5) as $siswa)
                            <div class="alert-item p-2 mb-2 bg-light rounded">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong class="small">{{ $siswa->nama_siswa }}</strong><br>
                                        <small class="text-muted">{{ $siswa->kelas->nama_kelas ?? '-' }}</small>
                                    </div>
                                    <span class="badge bg-danger">{{ $siswa->total_poin }}</span>
                                </div>
                            </div>
                            @endforeach
                            <div class="text-center mt-2">
                                <a href="{{ route('kepsek.siswa_bermasalah.index') }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fa-solid fa-eye me-1"></i>Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Kategori & Monitoring Status -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Kategori Pelanggaran Terbanyak</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($chartData['kategori_data']->take(4) as $kategori)
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="text-center p-3 border rounded">
                                        <div class="h4 text-primary mb-1">{{ $kategori->total }}</div>
                                        <div class="small font-weight-bold">{{ $kategori->nama_kategori }}</div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-success">Status Monitoring</h6>
                        </div>
                        <div class="card-body">
                            <div class="row text-center mb-3">
                                <div class="col-6">
                                    <div class="border-left-success p-2">
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['monitoring_aktif'] }}</div>
                                        <small class="text-muted">Monitoring</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="border-left-warning p-2">
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['konseling_selesai'] }}</div>
                                        <small class="text-muted">Konseling</small>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <a href="{{ route('kepsek.monitoring.index') }}" class="btn btn-sm btn-outline-success w-100">
                                    <i class="fa-solid fa-clipboard-check me-1"></i>Detail Monitoring
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Laporan & Export Tab -->
        <div class="tab-pane fade" id="laporan" role="tabpanel">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Generate Laporan</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('kepsek.laporan.show') }}" method="GET" id="laporanForm">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Jenis Laporan</label>
                                        <select name="jenis" class="form-select" required>
                                            <option value="pelanggaran_siswa">Data Pelanggaran Siswa</option>
                                            <option value="rekapitulasi_kelas">Rekapitulasi per Kelas</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Kelas</label>
                                        <select name="kelas_id" class="form-select">
                                            <option value="">Semua Kelas</option>
                                            @foreach($kelas as $k)
                                                <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Periode</label>
                                        <select name="periode" class="form-select">
                                            <option value="">Semua Data</option>
                                            <option value="bulan_ini">Bulan Ini</option>
                                            <option value="3_bulan">3 Bulan Terakhir</option>
                                            <option value="semester">Semester Ini</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Tanggal Mulai (Opsional)</label>
                                        <input type="date" name="tanggal_mulai" class="form-control">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Tanggal Selesai (Opsional)</label>
                                        <input type="date" name="tanggal_selesai" class="form-control">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">&nbsp;</label>
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fa-solid fa-eye me-2"></i>Lihat Laporan
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-success">Laporan Cepat</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('kepsek.laporan.show', ['jenis' => 'pelanggaran_siswa', 'periode' => 'bulan_ini']) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fa-solid fa-calendar-day me-1"></i>Pelanggaran Bulan Ini
                                </a>
                                <a href="{{ route('kepsek.laporan.show', ['jenis' => 'rekapitulasi_kelas']) }}" class="btn btn-outline-success btn-sm">
                                    <i class="fa-solid fa-users me-1"></i>Rekapitulasi Semua Kelas
                                </a>
                                <a href="{{ route('kepsek.siswa_bermasalah.index') }}" class="btn btn-outline-warning btn-sm">
                                    <i class="fa-solid fa-exclamation-triangle me-1"></i>Siswa Bermasalah
                                </a>
                                <a href="{{ route('kepsek.monitoring_sanksi.index') }}" class="btn btn-outline-info btn-sm">
                                    <i class="fa-solid fa-gavel me-1"></i>Monitoring Sanksi
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-info">Export Data</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button onclick="exportData('pelanggaran_siswa')" class="btn btn-success btn-sm">
                                    <i class="fa-solid fa-download me-1"></i>Export Excel - Pelanggaran
                                </button>
                                <button onclick="exportData('rekapitulasi_kelas')" class="btn btn-success btn-sm">
                                    <i class="fa-solid fa-download me-1"></i>Export Excel - Rekapitulasi
                                </button>
                                <a href="{{ route('kepsek.monitoring_sanksi.export') }}" class="btn btn-success btn-sm">
                                    <i class="fa-solid fa-download me-1"></i>Export Excel - Monitoring Sanksi
                                </a>
                            </div>
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
        // Initialize Bootstrap tabs
        var triggerTabList = [].slice.call(document.querySelectorAll('#laporanTabs button'))
        triggerTabList.forEach(function (triggerEl) {
            var tabTrigger = new bootstrap.Tab(triggerEl)
            
            triggerEl.addEventListener('click', function (event) {
                event.preventDefault()
                tabTrigger.show()
            })
        })
        
        // Tren Chart
        const trendCtx = document.getElementById('trendChart').getContext('2d');
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartData['trend_data']->pluck('bulan')) !!},
                datasets: [{
                    label: 'Jumlah Pelanggaran',
                    data: {!! json_encode($chartData['trend_data']->pluck('total')) !!},
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        
        // Export function
        function exportData(jenis) {
            const form = document.getElementById('laporanForm');
            const formData = new FormData(form);
            formData.set('jenis', jenis);
            
            const params = new URLSearchParams(formData).toString();
            window.open('{{ route("kepsek.laporan.export") }}?' + params, '_blank');
        }
        

    </script>
    @vite('resources/js/kepsek/laporan.js')
@endpush
