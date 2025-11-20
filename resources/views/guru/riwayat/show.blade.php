@extends('guru.layouts.app')

@section('title', 'Detail Riwayat Laporan')

@push('styles')
    @vite('resources/css/guru/riwayat.css')
@endpush

@section('content')
<div class="container-fluid">
    
    <div class="page-header">
        <h1 class="page-title">Detail Riwayat Laporan</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('guru.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('guru.riwayat.index') }}">Riwayat Laporanku</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">
                <i class="fa-solid fa-info-circle me-2"></i>
                Informasi Laporan
            </h5>
            <div>
                @if($riwayat->status_verifikasi == 'menunggu')
                <span class="badge bg-warning">Menunggu Verifikasi</span>
                @elseif($riwayat->status_verifikasi == 'diverifikasi')
                <span class="badge bg-success">Disetujui</span>
                @else
                <span class="badge bg-danger">Ditolak</span>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="200">Tanggal Kejadian</th>
                            <td>{{ \Carbon\Carbon::parse($riwayat->tanggal)->format('d F Y, H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Nama Siswa</th>
                            <td>{{ $riwayat->siswa->nama_siswa }}</td>
                        </tr>
                        <tr>
                            <th>NIS</th>
                            <td>{{ $riwayat->siswa->nis }}</td>
                        </tr>
                        <tr>
                            <th>Kelas</th>
                            <td>{{ $riwayat->siswa->kelas->nama_kelas ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="200">Kategori</th>
                            <td>{{ $riwayat->jenisPelanggaran->kategori->nama_kategori }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Pelanggaran</th>
                            <td>{{ $riwayat->jenisPelanggaran->nama_pelanggaran }}</td>
                        </tr>
                        <tr>
                            <th>Poin</th>
                            <td><span class="badge bg-danger">{{ $riwayat->poin }}</span></td>
                        </tr>
                        <tr>
                            <th>Pelapor</th>
                            <td>{{ $riwayat->pencatat->nama_lengkap }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <hr>

            <div class="mb-3">
                <h6><strong>Keterangan Kejadian:</strong></h6>
                <p class="text-muted">{{ $riwayat->keterangan }}</p>
            </div>

            @if($riwayat->foto_bukti)
            <div class="mb-3">
                <h6><strong>Foto Bukti:</strong></h6>
                <img src="{{ asset('storage/' . $riwayat->foto_bukti) }}" alt="Foto Bukti" class="img-thumbnail" style="max-width: 400px;">
            </div>
            @endif

            @if($riwayat->status_verifikasi == 'ditolak' && $riwayat->catatan_verifikasi)
            <div class="alert alert-danger">
                <h6><strong>Alasan Penolakan:</strong></h6>
                <p class="mb-0">{{ $riwayat->catatan_verifikasi }}</p>
            </div>
            @endif

            @if($riwayat->status_verifikasi == 'diverifikasi' && $riwayat->catatan_verifikasi)
            <div class="alert alert-success">
                <h6><strong>Catatan Verifikasi:</strong></h6>
                <p class="mb-0">{{ $riwayat->catatan_verifikasi }}</p>
            </div>
            @endif

            <div class="mt-4">
                <a href="{{ route('guru.riwayat.index') }}" class="btn btn-secondary">
                    <i class="fa-solid fa-arrow-left me-1"></i>
                    Kembali
                </a>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
    @vite('resources/js/guru/riwayat.js')
@endpush
