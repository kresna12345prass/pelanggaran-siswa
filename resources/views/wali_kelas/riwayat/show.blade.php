@extends('wali_kelas.layouts.app')

@section('title', 'Detail Riwayat')

@push('styles')
    @vite('resources/css/wali_kelas/riwayat.css')
@endpush

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h3 class="mb-1">Detail Riwayat Laporan</h3>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fa-solid fa-info-circle me-2"></i>Informasi Laporan</h5>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Siswa</div>
                <div class="col-md-9">{{ $riwayat->siswa->nama_siswa }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Tanggal Kejadian</div>
                <div class="col-md-9">{{ \Carbon\Carbon::parse($riwayat->tanggal)->format('d F Y, H:i') }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Jenis Pelanggaran</div>
                <div class="col-md-9">{{ $riwayat->jenisPelanggaran->nama_pelanggaran }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Kategori</div>
                <div class="col-md-9">{{ $riwayat->jenisPelanggaran->kategori->nama_kategori ?? '-' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Poin Pelanggaran</div>
                <div class="col-md-9"><span class="badge bg-danger fs-6">{{ $riwayat->poin }} Poin</span></div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Keterangan</div>
                <div class="col-md-9">{{ $riwayat->keterangan ?? '-' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Status Verifikasi</div>
                <div class="col-md-9">
                    @if($riwayat->status_verifikasi == 'diverifikasi')
                        <span class="badge bg-success fs-6">Disetujui</span>
                    @else
                        <span class="badge bg-danger fs-6">Ditolak</span>
                    @endif
                </div>
            </div>
            @if($riwayat->catatan_verifikasi)
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Catatan Verifikasi</div>
                <div class="col-md-9">{{ $riwayat->catatan_verifikasi }}</div>
            </div>
            @endif
        </div>
    </div>

    @if($riwayat->foto_bukti)
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0"><i class="fa-solid fa-camera me-2"></i>Foto Bukti</h5>
        </div>
        <div class="card-body text-center">
            <img src="{{ asset('storage/' . $riwayat->foto_bukti) }}" alt="Bukti" class="img-fluid rounded" style="max-height: 400px;">
        </div>
    </div>
    @endif

    <div class="mb-4">
        <a href="{{ route('wali_kelas.riwayat.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>
@endsection

@push('scripts')
    @vite('resources/js/wali_kelas/riwayat.js')
@endpush
