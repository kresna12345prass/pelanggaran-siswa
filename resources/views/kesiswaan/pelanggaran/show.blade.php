@extends('kesiswaan.layouts.app')
@section('title', 'Detail Pelanggaran')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Detail Pelanggaran</h3>
        <div>
            <a href="{{ route('kesiswaan.pelanggaran.exportPdf', $pelanggaran->id) }}" class="btn btn-danger">
                <i class="fa-solid fa-file-pdf"></i> Ekspor PDF
            </a>
            <a href="{{ route('kesiswaan.pelanggaran.edit', $pelanggaran->id) }}" class="btn btn-warning">
                <i class="fa-solid fa-edit"></i> Edit
            </a>
            <a href="{{ route('kesiswaan.pelanggaran.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Informasi Pelanggaran</h5>
                </div>
                <div class="card-body">
                    <table class="table table-dark-mode">
                        <tr>
                            <th width="200">Siswa</th>
                            <td>{{ $pelanggaran->siswa->nama_siswa }} ({{ $pelanggaran->siswa->nis }})</td>
                        </tr>
                        <tr>
                            <th>Kelas</th>
                            <td>{{ $pelanggaran->siswa->kelas->nama_kelas ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Pelanggaran</th>
                            <td>{{ $pelanggaran->jenisPelanggaran->nama_pelanggaran }}</td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td>{{ $pelanggaran->jenisPelanggaran->kategoriPelanggaran->nama_kategori }}</td>
                        </tr>
                        <tr>
                            <th>Poin</th>
                            <td><span class="badge bg-danger fs-6">{{ $pelanggaran->poin }}</span></td>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <td>{{ \Carbon\Carbon::parse($pelanggaran->tanggal)->format('d F Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Keterangan</th>
                            <td>{{ $pelanggaran->keterangan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Pencatat</th>
                            <td>{{ $pelanggaran->pencatat->nama_lengkap ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($pelanggaran->status_verifikasi == 'menunggu')
                                    <span class="badge bg-warning">Menunggu</span>
                                @elseif($pelanggaran->status_verifikasi == 'diverifikasi')
                                    <span class="badge bg-success">Diverifikasi</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                        @if($pelanggaran->catatan_verifikasi)
                        <tr>
                            <th>Catatan Verifikasi</th>
                            <td>{{ $pelanggaran->catatan_verifikasi }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            @if($pelanggaran->foto_bukti)
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Foto Bukti</h5>
                </div>
                <div class="card-body text-center">
                    <img src="{{ asset('storage/' . $pelanggaran->foto_bukti) }}" class="img-fluid rounded" alt="Bukti">
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
