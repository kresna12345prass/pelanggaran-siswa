@extends('wali_kelas.layouts.app')

@section('title', 'Detail Pelanggaran')

@push('styles')
    <link rel="stylesheet" href="{{ asset('wali_kelas/laporan.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h3 class="mb-1">Detail Pelanggaran</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('wali_kelas.pelanggaran_kelas.index') }}">Data Pelanggaran</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
        </nav>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 fw-bold text-dark"><i class="fa-solid fa-info-circle me-2"></i>Informasi Pelanggaran</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Tanggal</th>
                            <td>{{ \Carbon\Carbon::parse($pelanggaran->tanggal)->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Nama Siswa</th>
                            <td>{{ $pelanggaran->siswa->nama_siswa }}</td>
                        </tr>
                        <tr>
                            <th>NIS</th>
                            <td>{{ $pelanggaran->siswa->nis }}</td>
                        </tr>
                        <tr>
                            <th>Kelas</th>
                            <td>{{ $pelanggaran->siswa->kelas->nama_kelas ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Jenis Pelanggaran</th>
                            <td>{{ $pelanggaran->jenisPelanggaran->nama_pelanggaran }}</td>
                        </tr>
                        <tr>
                            <th>Poin</th>
                            <td><span class="badge bg-danger">{{ $pelanggaran->poin }}</span></td>
                        </tr>
                        <tr>
                            <th>Pelapor</th>
                            <td>{{ $pelanggaran->userPencatat->guru->nama_guru ?? $pelanggaran->userPencatat->nama_lengkap ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($pelanggaran->status_verifikasi == 'menunggu')
                                    <span class="badge bg-warning">Menunggu</span>
                                @elseif($pelanggaran->status_verifikasi == 'diverifikasi')
                                    <span class="badge bg-success">Disetujui</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <h6 class="fw-bold">Keterangan:</h6>
                    <p>{{ $pelanggaran->keterangan ?? '-' }}</p>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('wali_kelas.pelanggaran_kelas.index') }}" class="btn btn-secondary">
                    <i class="fa-solid fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
