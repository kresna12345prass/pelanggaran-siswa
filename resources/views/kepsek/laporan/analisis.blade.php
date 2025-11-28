@extends('kepsek.layouts.app')

@section('title', 'Analisis Mendalam')

@push('styles')
    <link rel="stylesheet" href="{{ asset('kepsek/laporan.css') }}">
    <style>
        .metric-card { border-left: 4px solid #007bff; }
        .trend-up { color: #28a745; }
        .trend-down { color: #dc3545; }
        .risk-high { background-color: #f8d7da; }
        .risk-medium { background-color: #fff3cd; }
        .risk-low { background-color: #d1edff; }
    </style>
@endpush

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Analisis Mendalam</h1>
        <a href="{{ route('kepsek.laporan.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <!-- Tren Bulanan -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tren Pelanggaran 12 Bulan Terakhir</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Periode</th>
                            <th>Total Kasus</th>
                            <th>Total Poin</th>
                            <th>Rata-rata Poin</th>
                            <th>Tren</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trenBulanan as $index => $tren)
                        <tr>
                            <td>{{ \Carbon\Carbon::createFromFormat('Y-m', $tren->periode)->format('F Y') }}</td>
                            <td>{{ number_format($tren->total_kasus) }}</td>
                            <td>{{ number_format($tren->total_poin) }}</td>
                            <td>{{ number_format($tren->rata_poin, 2) }}</td>
                            <td>
                                @if($index > 0)
                                    @php
                                        $prev = $trenBulanan[$index - 1];
                                        $change = $tren->total_kasus - $prev->total_kasus;
                                    @endphp
                                    @if($change > 0)
                                        <span class="trend-up"><i class="fa-solid fa-arrow-up"></i> +{{ $change }}</span>
                                    @elseif($change < 0)
                                        <span class="trend-down"><i class="fa-solid fa-arrow-down"></i> {{ $change }}</span>
                                    @else
                                        <span class="text-muted"><i class="fa-solid fa-minus"></i> 0</span>
                                    @endif
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Efektivitas Sanksi -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Efektivitas Sanksi</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Jenis Sanksi</th>
                                    <th>Total</th>
                                    <th>Selesai</th>
                                    <th>%</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($efektivitasSanksi as $sanksi)
                                <tr>
                                    <td>{{ $sanksi->nama_sanksi }}</td>
                                    <td>{{ $sanksi->total_pelaksanaan }}</td>
                                    <td>{{ $sanksi->selesai }}</td>
                                    <td>
                                        <span class="badge bg-{{ $sanksi->persentase_selesai >= 80 ? 'success' : ($sanksi->persentase_selesai >= 60 ? 'warning' : 'danger') }}">
                                            {{ $sanksi->persentase_selesai }}%
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kelas Bermasalah -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Analisis Kelas Bermasalah</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Kelas</th>
                                    <th>Siswa</th>
                                    <th>Pelanggaran</th>
                                    <th>Rata-rata</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kelasBermasalah->take(10) as $kelas)
                                <tr class="{{ $kelas->rata_pelanggaran_per_siswa >= 3 ? 'risk-high' : ($kelas->rata_pelanggaran_per_siswa >= 2 ? 'risk-medium' : 'risk-low') }}">
                                    <td><strong>{{ $kelas->nama_kelas }}</strong></td>
                                    <td>{{ $kelas->total_siswa }}</td>
                                    <td>{{ $kelas->total_pelanggaran }}</td>
                                    <td>{{ $kelas->rata_pelanggaran_per_siswa }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Siswa Berisiko Tinggi -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-danger">Siswa Berisiko Tinggi (≥30 Poin)</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Total Pelanggaran</th>
                            <th>Total Poin</th>
                            <th>Pelanggaran Terakhir</th>
                            <th>Status Risiko</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($siswaBerisiko as $siswa)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $siswa->nis }}</td>
                            <td><strong>{{ $siswa->nama_siswa }}</strong></td>
                            <td><span class="badge bg-info">{{ $siswa->nama_kelas }}</span></td>
                            <td>{{ $siswa->total_pelanggaran }}</td>
                            <td>
                                <span class="badge bg-{{ $siswa->total_poin >= 80 ? 'danger' : ($siswa->total_poin >= 50 ? 'warning' : 'secondary') }}">
                                    {{ $siswa->total_poin }}
                                </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($siswa->pelanggaran_terakhir)->format('d/m/Y') }}</td>
                            <td>
                                @if($siswa->total_poin >= 80)
                                    <span class="badge bg-danger">Kritis</span>
                                @elseif($siswa->total_poin >= 50)
                                    <span class="badge bg-warning">Tinggi</span>
                                @else
                                    <span class="badge bg-secondary">Sedang</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('kepsek.siswa_bermasalah.show', $siswa->id) }}" class="btn btn-info btn-sm">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <button class="btn btn-warning btn-sm" onclick="buatMonitoring({{ $siswa->id }})">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        function buatMonitoring(siswaId) {
            if(confirm('Buat monitoring khusus untuk siswa ini?')) {
                // Redirect ke form monitoring
                window.location.href = `/kepsek/monitoring/create?siswa_id=${siswaId}`;
            }
        }
    </script>
    <script src="{{ asset('kepsek/laporan.js') }}" defer></script>
@endpush
