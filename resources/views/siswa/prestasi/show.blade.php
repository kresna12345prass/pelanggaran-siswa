@extends('siswa.layouts.app')

@section('title', 'Detail Prestasi')

@push('styles')
    @vite('resources/css/siswa/prestasi.css')
@endpush

@section('content')
<div class="container-fluid">
    
    <div class="mb-4">
        <h3 class="mb-1">🏆 Detail Prestasi</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('siswa.prestasi.index') }}">Data Prestasi</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
        </nav>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 fw-bold text-dark"><i class="fa-solid fa-trophy me-2"></i>Informasi Prestasi</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td width="150"><strong>Tanggal</strong></td>
                            <td>: {{ \Carbon\Carbon::parse($prestasi->tanggal)->format('d F Y') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Jenis Prestasi</strong></td>
                            <td>: {{ $prestasi->jenisPrestasi->nama_prestasi ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tingkat</strong></td>
                            <td>: 
                                <span class="badge 
                                    @if($prestasi->tingkat == 'Internasional') bg-danger
                                    @elseif($prestasi->tingkat == 'Nasional') bg-warning
                                    @elseif($prestasi->tingkat == 'Provinsi') bg-info
                                    @elseif($prestasi->tingkat == 'Kabupaten/Kota') bg-primary
                                    @else bg-success
                                    @endif">
                                    {{ $prestasi->tingkat }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Poin</strong></td>
                            <td>: {{ $prestasi->poin ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td width="150"><strong>Penghargaan</strong></td>
                            <td>: {{ $prestasi->penghargaan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tahun Ajaran</strong></td>
                            <td>: {{ $prestasi->tahunAjaran->tahun_ajaran ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Pencatat</strong></td>
                            <td>: {{ $prestasi->pencatat->nama_lengkap ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal Input</strong></td>
                            <td>: {{ $prestasi->created_at->format('d F Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            @if($prestasi->keterangan)
            <div class="row mt-3">
                <div class="col-12">
                    <h6><strong>Keterangan:</strong></h6>
                    <p class="text-muted">{{ $prestasi->keterangan }}</p>
                </div>
            </div>
            @endif

            @if($prestasi->bukti_dokumen)
            <div class="row mt-3">
                <div class="col-12">
                    <h6><strong>Bukti Dokumen:</strong></h6>
                    <a href="{{ asset('storage/' . $prestasi->bukti_dokumen) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                        <i class="fa-solid fa-file-pdf me-1"></i> Lihat Dokumen
                    </a>
                </div>
            </div>
            @endif

            <div class="row mt-4">
                <div class="col-12">
                    <a href="{{ route('siswa.prestasi.index') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
    @vite('resources/js/siswa/prestasi.js')
@endpush