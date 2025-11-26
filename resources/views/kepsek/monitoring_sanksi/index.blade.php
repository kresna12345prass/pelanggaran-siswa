@extends('kepsek.layouts.app')

@section('title', 'Monitoring Sanksi')

@push('styles')
    <link rel="stylesheet" href="{{ asset('kepsek/monitoring_sanksi.css') }}">
@endpush

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1 text-gray-800">Monitoring Sanksi</h1>
        <p class="text-muted mb-0 small">Status pelaksanaan sanksi siswa</p>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pending'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Berjalan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['berjalan'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hourglass-half fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Selesai</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['selesai'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-dark"><i class="fa-solid fa-list me-2"></i></h6>
            <div class="d-flex gap-2">
                <a href="{{ route('kepsek.monitoring_sanksi.export', ['status' => $status]) }}" class="btn btn-success btn-sm shadow-sm">
                    <i class="fa-solid fa-file-excel me-2"></i>
                    <span class="d-none d-sm-inline">Export Excel</span>
                    <span class="d-inline d-sm-none">Excel</span>
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="p-2 p-md-3 pb-0">
                <form method="GET" action="{{ route('kepsek.monitoring_sanksi.index') }}">
                    <div class="row">
                        <div class="col-md-3">
                            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="all" {{ $status == 'all' ? 'selected' : '' }}>Semua Status</option>
                                <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="berjalan" {{ $status == 'berjalan' ? 'selected' : '' }}>Berjalan</option>
                                <option value="selesai" {{ $status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="table-responsive p-2 p-md-3 pt-2">
                <table class="table table-hover" id="sanksiTable" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 3%;"></th>
                            <th class="text-center" style="width: 5%;">No</th>
                            <th style="width: 10%;">Tanggal</th>
                            <th style="width: 10%;">NIS</th>
                            <th style="width: 20%;">Nama Siswa</th>
                            <th style="width: 10%;">Kelas</th>
                            <th style="width: 20%;">Jenis Pelanggaran</th>
                            <th style="width: 10%;">Jenis Sanksi</th>
                            <th class="text-center" style="width: 12%;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sanksi as $index => $s)
                            <tr>
                                <td class="text-center"></td>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($s->tanggal_mulai)->format('d/m/Y') }}</td>
                                <td>{{ $s->pelanggaran->siswa->nis ?? '-' }}</td>
                                <td><strong>{{ $s->pelanggaran->siswa->nama_siswa ?? '-' }}</strong></td>
                                <td><span class="badge bg-info">{{ $s->pelanggaran->siswa->kelas->nama_kelas ?? '-' }}</span></td>
                                <td>{{ $s->pelanggaran->jenisPelanggaran->nama_pelanggaran ?? '-' }}</td>
                                <td>{{ $s->jenis_sanksi ?? '-' }}</td>
                                <td class="text-center">
                                    @if($s->status_sanksi == 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif($s->status_sanksi == 'berjalan')
                                        <span class="badge bg-info">Berjalan</span>
                                    @elseif($s->status_sanksi == 'selesai')
                                        <span class="badge bg-success">Selesai</span>
                                    @else
                                        <span class="badge bg-danger">Terlambat</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">Tidak ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('kepsek/monitoring_sanksi.js') }}" defer></script>
@endpush