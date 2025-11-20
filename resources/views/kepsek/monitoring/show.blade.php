@extends('kepsek.layouts.app')

@section('title', 'Detail Monitoring')

@push('styles')
    @vite('resources/css/kepsek/monitoring.css')
@endpush

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Detail Monitoring Kasus Berat</h1>
        <a href="{{ route('kepsek.monitoring.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3"><strong>Siswa:</strong></div>
                <div class="col-md-9">{{ $monitoring->pelanggaran->siswa->nama_siswa ?? '-' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3"><strong>NIS:</strong></div>
                <div class="col-md-9">{{ $monitoring->pelanggaran->siswa->nis ?? '-' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3"><strong>Kelas:</strong></div>
                <div class="col-md-9">{{ $monitoring->pelanggaran->siswa->kelas->nama_kelas ?? '-' }}</div>
            </div>
            <hr>
            <div class="row mb-3">
                <div class="col-md-3"><strong>Pelanggaran:</strong></div>
                <div class="col-md-9">{{ $monitoring->pelanggaran->jenisPelanggaran->nama_pelanggaran ?? '-' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3"><strong>Poin:</strong></div>
                <div class="col-md-9"><span class="badge bg-danger">{{ $monitoring->pelanggaran->poin }}</span></div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3"><strong>Tanggal Pelanggaran:</strong></div>
                <div class="col-md-9">{{ \Carbon\Carbon::parse($monitoring->pelanggaran->tanggal)->format('d/m/Y H:i') }}</div>
            </div>
            <hr>
            <div class="row mb-3">
                <div class="col-md-3"><strong>Status Monitoring:</strong></div>
                <div class="col-md-9"><span class="badge bg-info">{{ $monitoring->status_monitoring }}</span></div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3"><strong>Catatan Monitoring:</strong></div>
                <div class="col-md-9">{{ $monitoring->catatan_monitoring }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3"><strong>Tanggal Monitoring:</strong></div>
                <div class="col-md-9">{{ \Carbon\Carbon::parse($monitoring->tanggal_monitoring)->format('d/m/Y') }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3"><strong>Tindak Lanjut:</strong></div>
                <div class="col-md-9">{{ $monitoring->tindak_lanjut ?? '-' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3"><strong>Dimonitor Oleh:</strong></div>
                <div class="col-md-9">{{ $monitoring->kepalaSekolah->nama_lengkap ?? '-' }}</div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    @vite('resources/js/kepsek/monitoring.js')
@endpush
