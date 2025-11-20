@extends('kesiswaan.layouts.app')
@section('title', 'Detail Sanksi')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Detail Sanksi</h3>
        <div>
            <a href="{{ route('kesiswaan.sanksi.edit', $sanksi->id) }}" class="btn btn-warning">
                <i class="fa-solid fa-edit"></i> Edit
            </a>
            <div class="btn-group">
                <button class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fa-solid fa-file-pdf"></i> Cetak
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('kesiswaan.sanksi.cetak-peringatan', $sanksi->id) }}" target="_blank">Surat Peringatan</a></li>
                    <li><a class="dropdown-item" href="{{ route('kesiswaan.sanksi.cetak-panggilan', $sanksi->id) }}" target="_blank">Surat Panggilan</a></li>
                    <li><a class="dropdown-item" href="{{ route('kesiswaan.sanksi.cetak-skorsing', $sanksi->id) }}" target="_blank">Surat Skorsing</a></li>
                </ul>
            </div>
            <a href="{{ route('kesiswaan.sanksi.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Data Siswa</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th width="150">NIS</th>
                            <td>{{ $sanksi->pelanggaran->siswa->nis }}</td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>{{ $sanksi->pelanggaran->siswa->nama_siswa }}</td>
                        </tr>
                        <tr>
                            <th>Kelas</th>
                            <td>{{ $sanksi->pelanggaran->siswa->kelas->nama_kelas ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-warning">
                    <h5 class="mb-0">Pelanggaran Terkait</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th width="150">Jenis</th>
                            <td>{{ $sanksi->pelanggaran->jenisPelanggaran->nama_pelanggaran }}</td>
                        </tr>
                        <tr>
                            <th>Poin</th>
                            <td><span class="badge bg-danger">{{ $sanksi->pelanggaran->poin }}</span></td>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <td>{{ \Carbon\Carbon::parse($sanksi->pelanggaran->tanggal)->format('d F Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Detail Sanksi</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th width="150">Jenis Sanksi</th>
                            <td><strong>{{ $sanksi->jenis_sanksi }}</strong></td>
                        </tr>
                        <tr>
                            <th>Deskripsi</th>
                            <td>{{ $sanksi->deskripsi_hukuman }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Mulai</th>
                            <td>{{ \Carbon\Carbon::parse($sanksi->tanggal_mulai)->format('d F Y') }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Selesai</th>
                            <td>
                                @if($sanksi->tanggal_selesai)
                                    {{ \Carbon\Carbon::parse($sanksi->tanggal_selesai)->format('d F Y') }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($sanksi->status_sanksi == 'berjalan')
                                    <span class="badge bg-warning">Berjalan</span>
                                @elseif($sanksi->status_sanksi == 'selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @elseif($sanksi->status_sanksi == 'terlambat')
                                    <span class="badge bg-danger">Terlambat</span>
                                @else
                                    <span class="badge bg-secondary">Pending</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Penetap</th>
                            <td>{{ $sanksi->userPenetap->nama_lengkap ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
