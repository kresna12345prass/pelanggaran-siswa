@extends('kepsek.layouts.app')

@section('title', 'Monitoring Real-time')

@push('styles')
    <link rel="stylesheet" href="{{ asset('kepsek/laporan.css') }}">
    <style>
        .status-aktif { border-left: 4px solid #28a745; }
        .status-proses { border-left: 4px solid #ffc107; }
        .status-pending { border-left: 4px solid #dc3545; }
        .refresh-btn { animation: spin 2s linear infinite; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        .priority-high { background-color: #f8d7da; }
        .priority-medium { background-color: #fff3cd; }
        .priority-low { background-color: #d4edda; }
    </style>
@endpush

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Monitoring Real-time</h1>
        <div class="btn-group">
            <button class="btn btn-primary btn-sm" onclick="refreshData()">
                <i class="fa-solid fa-refresh me-1" id="refreshIcon"></i>Refresh
            </button>
            <a href="{{ route('kepsek.laporan.index') }}" class="btn btn-secondary btn-sm">
                <i class="fa-solid fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Alert Summary -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Monitoring Aktif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $monitoringAktif->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-eye fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Konseling Berjalan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $konselingBerjalan->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Sanksi Pending</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $sansiBelumSelesai->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Monitoring Aktif -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-success">Monitoring Aktif</h6>
                    <span class="badge bg-success">{{ $monitoringAktif->count() }} siswa</span>
                </div>
                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                    @forelse($monitoringAktif as $monitoring)
                    <div class="card mb-2 status-aktif">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">{{ $monitoring->pelanggaran->siswa->nama_siswa ?? 'N/A' }}</h6>
                                    <p class="text-muted small mb-1">{{ $monitoring->pelanggaran->siswa->kelas->nama_kelas ?? '-' }}</p>
                                    <p class="small mb-0">{{ Str::limit($monitoring->catatan_monitoring ?? 'Tidak ada catatan', 50) }}</p>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-success">{{ $monitoring->status_monitoring ?? 'Aktif' }}</span>
                                    <br><small class="text-muted">Kepsek</small>
                                </div>
                            </div>
                            <div class="mt-2">
                                <small class="text-muted">
                                    <i class="fa-solid fa-calendar"></i> 
                                    {{ \Carbon\Carbon::parse($monitoring->created_at)->diffForHumans() }}
                                </small>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">
                        <i class="fa-solid fa-eye-slash fa-3x mb-3"></i>
                        <p>Tidak ada monitoring aktif</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Konseling Berjalan -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-warning">Konseling Berjalan</h6>
                    <span class="badge bg-warning">{{ $konselingBerjalan->count() }} sesi</span>
                </div>
                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                    @forelse($konselingBerjalan as $konseling)
                    <div class="card mb-2 status-proses">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">{{ $konseling->siswa->nama_siswa }}</h6>
                                    <p class="text-muted small mb-1">{{ $konseling->siswa->kelas->nama_kelas ?? '-' }}</p>
                                    <p class="small mb-0">{{ Str::limit($konseling->masalah, 50) }}</p>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-warning">Proses</span>
                                    <br><small class="text-muted">{{ \Carbon\Carbon::parse($konseling->tanggal_konseling)->format('d/m/Y') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">
                        <i class="fa-solid fa-comments-slash fa-3x mb-3"></i>
                        <p>Tidak ada konseling berjalan</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Sanksi Belum Selesai -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-danger">Sanksi Belum Selesai</h6>
            <span class="badge bg-danger">{{ $sansiBelumSelesai->count() }} sanksi</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Siswa</th>
                            <th>Kelas</th>
                            <th>Jenis Sanksi</th>
                            <th>Tanggal Mulai</th>
                            <th>Status</th>
                            <th>Prioritas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sansiBelumSelesai as $sanksi)
                        @php
                            $daysPassed = \Carbon\Carbon::parse($sanksi->tanggal_mulai)->diffInDays(now());
                            $priority = $daysPassed > 30 ? 'high' : ($daysPassed > 14 ? 'medium' : 'low');
                        @endphp
                        <tr class="priority-{{ $priority }}">
                            <td><strong>{{ $sanksi->siswa->nama_siswa }}</strong></td>
                            <td><span class="badge bg-info">{{ $sanksi->siswa->kelas->nama_kelas ?? '-' }}</span></td>
                            <td>{{ $sanksi->sanksi->nama_sanksi ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($sanksi->tanggal_mulai)->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $sanksi->status == 'proses' ? 'warning' : 'secondary' }}">
                                    {{ ucfirst($sanksi->status) }}
                                </span>
                            </td>
                            <td>
                                @if($priority == 'high')
                                    <span class="badge bg-danger">Tinggi</span>
                                @elseif($priority == 'medium')
                                    <span class="badge bg-warning">Sedang</span>
                                @else
                                    <span class="badge bg-success">Rendah</span>
                                @endif
                                <br><small class="text-muted">{{ $daysPassed }} hari</small>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-info btn-sm" onclick="lihatDetail({{ $sanksi->id }})">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                    <button class="btn btn-warning btn-sm" onclick="followUp({{ $sanksi->id }})">
                                        <i class="fa-solid fa-bell"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fa-solid fa-check-circle fa-3x mb-3"></i>
                                <p>Semua sanksi telah selesai</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        function refreshData() {
            const icon = document.getElementById('refreshIcon');
            icon.classList.add('refresh-btn');
            
            setTimeout(() => {
                location.reload();
            }, 1000);
        }
        
        function lihatDetail(sanksiId) {
            // Redirect ke detail sanksi
            window.location.href = `/kepsek/sanksi/${sanksiId}`;
        }
        
        function followUp(sanksiId) {
            if(confirm('Kirim reminder untuk sanksi ini?')) {
                // Ajax call untuk follow up
                fetch(`/kepsek/sanksi/${sanksiId}/follow-up`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        alert('Reminder berhasil dikirim');
                    }
                });
            }
        }
        
        // Auto refresh setiap 5 menit
        setInterval(() => {
            refreshData();
        }, 300000);
    </script>
    <script src="{{ asset('kepsek/laporan.js') }}" defer></script>
@endpush
