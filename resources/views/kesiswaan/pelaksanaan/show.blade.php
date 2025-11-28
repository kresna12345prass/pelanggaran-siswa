@extends('kesiswaan.layouts.app')
@section('title', 'Detail Pelaksanaan Sanksi')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">📋 Detail Pelaksanaan Sanksi</h3>
        <div>
            <a href="{{ route('kesiswaan.pelaksanaan.cetak-berita-acara', $pelaksanaan->id) }}" class="btn btn-danger" target="_blank">
                <i class="fa-solid fa-file-pdf"></i> Cetak Berita Acara
            </a>
            <a href="{{ route('kesiswaan.pelaksanaan.riwayat') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Data Siswa -->
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fa-solid fa-user me-2"></i>Data Siswa</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless table-dark-mode">
                        <tr>
                            <th width="150">NIS</th>
                            <td>{{ $pelaksanaan->dataSanksi->pelanggaran->siswa->nis }}</td>
                        </tr>
                        <tr>
                            <th>Nama Lengkap</th>
                            <td><strong>{{ $pelaksanaan->dataSanksi->pelanggaran->siswa->nama_siswa }}</strong></td>
                        </tr>
                        <tr>
                            <th>Kelas</th>
                            <td><span class="badge bg-info fs-6">{{ $pelaksanaan->dataSanksi->pelanggaran->siswa->kelas->nama_kelas ?? '-' }}</span></td>
                        </tr>
                        <tr>
                            <th>Jurusan</th>
                            <td>{{ $pelaksanaan->dataSanksi->pelanggaran->siswa->kelas->jurusan->nama_jurusan ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Data Pelanggaran -->
            <div class="card mb-3">
                <div class="card-header bg-warning">
                    <h5 class="mb-0"><i class="fa-solid fa-exclamation-triangle me-2"></i>Data Pelanggaran</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless table-dark-mode">
                        <tr>
                            <th width="150">Jenis Pelanggaran</th>
                            <td>{{ $pelaksanaan->dataSanksi->pelanggaran->jenisPelanggaran->nama_pelanggaran }}</td>
                        </tr>
                        <tr>
                            <th>Poin</th>
                            <td><span class="badge bg-danger fs-6">{{ $pelaksanaan->dataSanksi->pelanggaran->poin }} Poin</span></td>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <td>{{ \Carbon\Carbon::parse($pelaksanaan->dataSanksi->pelanggaran->tanggal)->format('d F Y') }}</td>
                        </tr>
                        <tr>
                            <th>Keterangan</th>
                            <td>{{ $pelaksanaan->dataSanksi->pelanggaran->keterangan ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Data Sanksi & Pelaksanaan -->
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0"><i class="fa-solid fa-gavel me-2"></i>Data Sanksi</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless table-dark-mode">
                        <tr>
                            <th width="150">Jenis Sanksi</th>
                            <td><strong>{{ $pelaksanaan->dataSanksi->jenis_sanksi }}</strong></td>
                        </tr>
                        <tr>
                            <th>Deskripsi</th>
                            <td>{{ $pelaksanaan->dataSanksi->deskripsi_hukuman }}</td>
                        </tr>
                        <tr>
                            <th>Periode Sanksi</th>
                            <td>
                                {{ \Carbon\Carbon::parse($pelaksanaan->dataSanksi->tanggal_mulai)->format('d/m/Y') }}
                                @if($pelaksanaan->dataSanksi->tanggal_selesai)
                                    s/d {{ \Carbon\Carbon::parse($pelaksanaan->dataSanksi->tanggal_selesai)->format('d/m/Y') }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Penetap Sanksi</th>
                            <td>{{ $pelaksanaan->dataSanksi->userPenetap->nama_lengkap ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Status Sanksi</th>
                            <td><span class="badge bg-success fs-6">{{ strtoupper($pelaksanaan->dataSanksi->status_sanksi) }}</span></td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Data Pelaksanaan -->
            <div class="card mb-3">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fa-solid fa-check-circle me-2"></i>Data Pelaksanaan</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless table-dark-mode">
                        <tr>
                            <th width="150">Tanggal Pelaksanaan</th>
                            <td><strong>{{ \Carbon\Carbon::parse($pelaksanaan->tanggal_pelaksanaan)->format('d F Y, H:i') }} WIB</strong></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td><span class="badge bg-success fs-6">{{ strtoupper($pelaksanaan->status) }}</span></td>
                        </tr>
                        <tr>
                            <th>Catatan</th>
                            <td>{{ $pelaksanaan->catatan ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Bukti Foto -->
    @if($pelaksanaan->bukti_foto)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fa-solid fa-camera me-2"></i>Bukti Foto Pelaksanaan</h5>
                </div>
                <div class="card-body text-center">
                    <img src="{{ asset('storage/' . $pelaksanaan->bukti_foto) }}" class="img-fluid rounded shadow" alt="Bukti Pelaksanaan" style="max-height: 500px;">
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
