@extends('ortu.layouts.app')

@section('title', 'Dashboard Orang Tua')

@push('styles')
    @vite('resources/css/ortu/dashboard.css')
@endpush

@section('content')
<div class="container-fluid">
    
    <div class="page-header">
        <h1 class="page-title">👪 Dashboard Orang Tua</h1>
        <p class="page-subtitle">Selamat datang, {{ Auth::user()->nama_lengkap }}</p>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-card-content">
                        <h5>Total Poin Pelanggaran</h5>
                        <div class="stat-number">{{ $totalPoin }}</div>
                    </div>
                    <div class="stat-card-icon icon-danger">
                        <i class="fa-solid fa-exclamation-circle"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-card-content">
                        <h5>Jumlah Pelanggaran</h5>
                        <div class="stat-number">{{ $jumlahPelanggaran }}</div>
                    </div>
                    <div class="stat-card-icon icon-warning">
                        <i class="fa-solid fa-list"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-card-content">
                        <h5>Total Poin Prestasi</h5>
                        <div class="stat-number">{{ $totalPoinPrestasi }}</div>
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
                        <h5>Jumlah Prestasi</h5>
                        <div class="stat-number">{{ $jumlahPrestasi }}</div>
                    </div>
                    <div class="stat-card-icon icon-primary">
                        <i class="fa-solid fa-star"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-card-content">
                        <h5>Sanksi Aktif</h5>
                        <div class="stat-number">{{ $sanksiAktif }}</div>
                    </div>
                    <div class="stat-card-icon icon-info">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-card-content">
                        <h5>Sanksi Selesai</h5>
                        <div class="stat-number">{{ $sanksiSelesai }}</div>
                    </div>
                    <div class="stat-card-icon icon-success">
                        <i class="fa-solid fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fa-solid fa-user me-2"></i>Informasi Anak</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td width="150"><strong>NIS</strong></td>
                            <td>: {{ $siswa->nis }}</td>
                        </tr>
                        <tr>
                            <td><strong>NISN</strong></td>
                            <td>: {{ $siswa->nisn }}</td>
                        </tr>
                        <tr>
                            <td><strong>Nama</strong></td>
                            <td>: {{ $siswa->nama_siswa }}</td>
                        </tr>
                        <tr>
                            <td><strong>Kelas</strong></td>
                            <td>: {{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Jurusan</strong></td>
                            <td>: {{ $siswa->kelas->jurusan->nama_jurusan ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fa-solid fa-info-circle me-2"></i>Informasi Penting</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fa-solid fa-lightbulb me-2"></i>
                        <strong>Catatan:</strong> Anda dapat memantau perilaku anak secara real-time melalui sistem ini.
                    </div>
                    @if($sanksiAktif > 0)
                    <div class="alert alert-warning">
                        <i class="fa-solid fa-exclamation-triangle me-2"></i>
                        <strong>Perhatian:</strong> Anak Anda memiliki {{ $sanksiAktif }} sanksi aktif. Mohon bimbing anak di rumah.
                    </div>
                    @endif
                    @if($totalPoin >= 90)
                    <div class="alert alert-danger">
                        <i class="fa-solid fa-times-circle me-2"></i>
                        <strong>Peringatan Keras:</strong> Total poin pelanggaran anak sudah mencapai {{ $totalPoin }}. Segera lakukan pembinaan!
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>



</div>
@endsection

@push('scripts')
    @vite('resources/js/ortu/dashboard.js')
@endpush
