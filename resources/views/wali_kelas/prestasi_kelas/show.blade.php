@extends('wali_kelas.layouts.app')

@section('title', 'Detail Prestasi')

@push('styles')
    @vite('resources/css/wali_kelas/laporan.css')
@endpush

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h3 class="mb-1">Detail Prestasi</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('wali_kelas.prestasi_kelas.index') }}">Data Prestasi</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
        </nav>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 fw-bold text-dark"><i class="fa-solid fa-info-circle me-2"></i>Informasi Prestasi</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Tanggal</th>
                            <td>{{ \Carbon\Carbon::parse($prestasi->tanggal)->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <th>Nama Siswa</th>
                            <td>{{ $prestasi->siswa->nama_siswa }}</td>
                        </tr>
                        <tr>
                            <th>NIS</th>
                            <td>{{ $prestasi->siswa->nis }}</td>
                        </tr>
                        <tr>
                            <th>Kelas</th>
                            <td>{{ $prestasi->siswa->kelas->nama_kelas ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Jenis Prestasi</th>
                            <td>{{ $prestasi->jenisPrestasi->nama_prestasi }}</td>
                        </tr>
                        <tr>
                            <th>Tingkat</th>
                            <td><span class="badge bg-primary">{{ ucfirst($prestasi->tingkat) }}</span></td>
                        </tr>
                        <tr>
                            <th>Peringkat</th>
                            <td><span class="badge bg-success">{{ $prestasi->peringkat }}</span></td>
                        </tr>
                        <tr>
                            <th>Bukti Dokumen</th>
                            <td>
                                @if($prestasi->bukti_dokumen)
                                    <a href="{{ asset('storage/' . $prestasi->bukti_dokumen) }}" target="_blank" class="btn btn-sm btn-primary">
                                        <i class="fa-solid fa-download"></i> Lihat Dokumen
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <h6 class="fw-bold">Keterangan:</h6>
                    <p>{{ $prestasi->keterangan ?? '-' }}</p>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('wali_kelas.prestasi_kelas.index') }}" class="btn btn-secondary">
                    <i class="fa-solid fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
