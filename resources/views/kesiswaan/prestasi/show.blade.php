@extends('kesiswaan.layouts.app')
@section('title', 'Detail Prestasi')

@push('styles')
    <link rel="stylesheet" href="{{ asset('kesiswaan/prestasi.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">🏆 Detail Prestasi</h3>
        <a href="{{ route('kesiswaan.prestasi.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">{{ $prestasi->jenisPrestasi->nama_prestasi }}</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="detail-item">
                        <small class="text-muted d-block mb-1">Siswa</small>
                        <strong>{{ $prestasi->siswa->nama_siswa }}</strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-item">
                        <small class="text-muted d-block mb-1">Kelas</small>
                        <strong>{{ $prestasi->siswa->kelas->nama_kelas ?? '-' }}</strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-item">
                        <small class="text-muted d-block mb-1">Jenis Prestasi</small>
                        <strong>{{ $prestasi->jenisPrestasi->nama_prestasi }}</strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-item">
                        <small class="text-muted d-block mb-1">Kategori</small>
                        <strong>{{ $prestasi->jenisPrestasi->kategori }}</strong>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="detail-item">
                        <small class="text-muted d-block mb-1">Poin</small>
                        <strong><span class="badge bg-success">{{ $prestasi->poin }}</span></strong>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="detail-item">
                        <small class="text-muted d-block mb-1">Tingkat</small>
                        <strong>{{ $prestasi->tingkat }}</strong>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="detail-item">
                        <small class="text-muted d-block mb-1">Tanggal</small>
                        <strong>{{ \Carbon\Carbon::parse($prestasi->tanggal)->format('d/m/Y') }}</strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-item">
                        <small class="text-muted d-block mb-1">Penghargaan</small>
                        <strong>{{ $prestasi->penghargaan ?? '-' }}</strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-item">
                        <small class="text-muted d-block mb-1">Tahun Ajaran</small>
                        <strong>{{ $prestasi->tahunAjaran->tahun_ajaran }}</strong>
                    </div>
                </div>
                @if($prestasi->bukti_dokumen)
                <div class="col-md-12">
                    <div class="detail-item">
                        <small class="text-muted d-block mb-1">Bukti Dokumen</small>
                        <a href="{{ asset('storage/' . $prestasi->bukti_dokumen) }}" target="_blank" class="btn btn-sm btn-primary">
                            <i class="fa-solid fa-download"></i> Lihat Dokumen
                        </a>
                    </div>
                </div>
                @endif
                <div class="col-12">
                    <div class="detail-item">
                        <small class="text-muted d-block mb-1">Keterangan</small>
                        <strong>{{ $prestasi->keterangan ?? '-' }}</strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-item">
                        <small class="text-muted d-block mb-1">Dicatat Oleh</small>
                        <strong>{{ $prestasi->pencatat->nama_lengkap ?? '-' }}</strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-item">
                        <small class="text-muted d-block mb-1">Tanggal Input</small>
                        <strong>{{ $prestasi->created_at->format('d/m/Y H:i') }}</strong>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end gap-2">
            <a href="{{ route('kesiswaan.prestasi.edit', $prestasi) }}" class="btn btn-warning">
                <i class="fa-solid fa-edit"></i> Edit
            </a>
        </div>
    </div>
</div>
@endsection
