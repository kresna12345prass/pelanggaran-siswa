@extends('guru.layouts.app')

@section('title', 'Detail Laporan Pelanggaran')

@push('styles')
    <link rel="stylesheet" href="{{ asset('guru/laporan.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    
    <div class="page-header">
        <h1 class="page-title">Detail Laporan Pelanggaran</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('guru.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('guru.laporan.index') }}">Lapor Pelanggaran</a></li>
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
                @if($laporan->status_verifikasi == 'menunggu')
                <span class="badge bg-warning">Menunggu Verifikasi</span>
                @elseif($laporan->status_verifikasi == 'diverifikasi')
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
                            <td>{{ \Carbon\Carbon::parse($laporan->tanggal)->format('d F Y, H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Nama Siswa</th>
                            <td>{{ $laporan->siswa->nama_siswa }}</td>
                        </tr>
                        <tr>
                            <th>NIS</th>
                            <td>{{ $laporan->siswa->nis }}</td>
                        </tr>
                        <tr>
                            <th>Kelas</th>
                            <td>{{ $laporan->siswa->kelas->nama_kelas ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="200">Kategori</th>
                            <td>{{ $laporan->jenisPelanggaran->kategori->nama_kategori }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Pelanggaran</th>
                            <td>{{ $laporan->jenisPelanggaran->nama_pelanggaran }}</td>
                        </tr>
                        <tr>
                            <th>Poin</th>
                            <td><span class="badge bg-danger">{{ $laporan->poin }}</span></td>
                        </tr>
                        <tr>
                            <th>Pelapor</th>
                            <td>{{ $laporan->pencatat->nama_lengkap }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <hr>

            <div class="mb-3">
                <h6><strong>Keterangan Kejadian:</strong></h6>
                <p class="text-muted">{{ $laporan->keterangan }}</p>
            </div>

            @if($laporan->foto_bukti)
            <div class="mb-3">
                <h6><strong>Foto Bukti:</strong></h6>
                <img src="{{ asset('storage/' . $laporan->foto_bukti) }}" alt="Foto Bukti" class="img-thumbnail" style="max-width: 400px;">
            </div>
            @endif

            @if($laporan->status_verifikasi == 'ditolak' && $laporan->catatan_verifikasi)
            <div class="alert alert-danger">
                <h6><strong>Alasan Penolakan:</strong></h6>
                <p class="mb-0">{{ $laporan->catatan_verifikasi }}</p>
            </div>
            @endif

            @if($laporan->status_verifikasi == 'diverifikasi' && $laporan->catatan_verifikasi)
            <div class="alert alert-success">
                <h6><strong>Catatan Verifikasi:</strong></h6>
                <p class="mb-0">{{ $laporan->catatan_verifikasi }}</p>
            </div>
            @endif

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('guru.laporan.index') }}" class="btn btn-secondary">
                    <i class="fa-solid fa-arrow-left me-1"></i>
                    Kembali
                </a>
                @if($laporan->status_verifikasi == 'menunggu')
                <div>
                    <a href="{{ route('guru.laporan.edit', $laporan->id) }}" class="btn btn-warning">
                        <i class="fa-solid fa-edit me-1"></i>
                        Edit
                    </a>
                    <form action="{{ route('guru.laporan.destroy', $laporan->id) }}" method="POST" class="d-inline delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fa-solid fa-trash me-1"></i>
                            Hapus
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
    <script src="{{ asset('guru/laporan.js') }}" defer></script>
@endpush
