@extends('wali_kelas.layouts.app')

@section('title', 'Detail Sanksi')

@push('styles')
    <link rel="stylesheet" href="{{ asset('wali_kelas/laporan.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h3 class="mb-1">Detail Sanksi</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('wali_kelas.sanksi_kelas.index') }}">Data Sanksi</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
        </nav>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 fw-bold text-dark"><i class="fa-solid fa-info-circle me-2"></i>Informasi Sanksi</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Tanggal Mulai</th>
                            <td>{{ $sanksi->tanggal_mulai ? \Carbon\Carbon::parse($sanksi->tanggal_mulai)->format('d/m/Y') : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Selesai</th>
                            <td>{{ $sanksi->tanggal_selesai ? \Carbon\Carbon::parse($sanksi->tanggal_selesai)->format('d/m/Y') : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Nama Siswa</th>
                            <td>{{ $sanksi->pelanggaran->siswa->nama_siswa ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>NIS</th>
                            <td>{{ $sanksi->pelanggaran->siswa->nis ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Kelas</th>
                            <td>{{ $sanksi->pelanggaran->siswa->kelas->nama_kelas ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Jenis Sanksi</th>
                            <td>{{ $sanksi->jenis_sanksi }}</td>
                        </tr>
                        <tr>
                            <th>Poin Pelanggaran</th>
                            <td><span class="badge bg-danger">{{ $sanksi->pelanggaran->poin ?? 0 }}</span></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($sanksi->status_sanksi == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($sanksi->status_sanksi == 'selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @elseif($sanksi->status_sanksi == 'berjalan')
                                    <span class="badge bg-info">Berjalan</span>
                                @else
                                    <span class="badge bg-danger">Terlambat</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Jumlah Pelaksanaan</th>
                            <td>{{ $sanksi->pelaksanaan ? $sanksi->pelaksanaan->count() : 0 }} kali</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <h6 class="fw-bold">Deskripsi Hukuman:</h6>
                    <p>{{ $sanksi->deskripsi_hukuman ?? '-' }}</p>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('wali_kelas.sanksi_kelas.index') }}" class="btn btn-secondary">
                    <i class="fa-solid fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
