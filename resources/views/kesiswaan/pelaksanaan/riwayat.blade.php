@extends('kesiswaan.layouts.app')
@section('title', 'Riwayat Pelaksanaan Sanksi')

{{-- Menggunakan CSS yang sama dengan halaman Update Pelaksanaan --}}
@push('styles')
    <link rel="stylesheet" href="{{ asset('kesiswaan/pelaksanaan.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h3 class="mb-1">📜 Riwayat Pelaksanaan Sanksi</h3>
    </div>

    <div class="card shadow-sm mb-4 border-0">
        {{-- Header Putih Minimalis --}}
        <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-dark"><i class="fa-solid fa-clock-rotate-left me-2"></i> Data Riwayat</h6>
            <a href="{{ route('kesiswaan.pelaksanaan.riwayat.export') }}" class="btn btn-success btn-sm shadow-sm">
                <i class="fa-solid fa-file-excel me-2"></i>
                <span class="d-none d-sm-inline">Export Excel</span>
                <span class="d-inline d-sm-none">Excel</span>
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive p-2 p-md-3">
                {{-- Gunakan class 'pelaksanaan-table' agar font kecil & rapi --}}
                <table class="table pelaksanaan-table table-hover" id="tableRiwayat" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Nama Siswa</th>
                            <th class="text-center">Kelas</th>
                            <th>Jenis Sanksi</th>
                            <th>Tanggal Pelaksanaan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayatPelaksanaan as $pelaksanaan)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td><strong>{{ $pelaksanaan->dataSanksi->pelanggaran->siswa->nama_siswa }}</strong></td>
                            <td class="text-center"><span class="badge bg-info">{{ $pelaksanaan->dataSanksi->pelanggaran->siswa->kelas->nama_kelas ?? '-' }}</span></td>
                            <td>{{ $pelaksanaan->dataSanksi->jenis_sanksi }}</td>
                            <td>{{ \Carbon\Carbon::parse($pelaksanaan->tanggal_pelaksanaan)->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <div class="action-buttons">
                                    <a href="{{ route('kesiswaan.pelaksanaan.riwayat.show', $pelaksanaan->id) }}" class="btn btn-info btn-sm" title="Detail">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('kesiswaan.pelaksanaan.cetak-berita-acara', $pelaksanaan->id) }}" class="btn btn-danger btn-sm" title="Cetak PDF" target="_blank">
                                        <i class="fa-solid fa-file-pdf"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada riwayat pelaksanaan sanksi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- Menggunakan JS yang sama dengan halaman Update Pelaksanaan --}}
@push('scripts')
    <script src="{{ asset('kesiswaan/pelaksanaan.js') }}" defer></script>
@endpush
