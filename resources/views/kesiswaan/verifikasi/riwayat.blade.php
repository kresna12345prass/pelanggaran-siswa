@extends('kesiswaan.layouts.app')
@section('title', 'Riwayat Verifikasi')

@push('styles')
    <link rel="stylesheet" href="{{ asset('kesiswaan/verifikasi.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h3 class="mb-1">📜 Riwayat Verifikasi</h3>
    </div>

    <div class="card shadow-sm mb-4 border-0">
        {{-- Header Putih Minimalis --}}
        <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-dark"><i class="fa-solid fa-clock-rotate-left me-2"></i> Data Riwayat</h6>
            <a href="{{ route('kesiswaan.verifikasi.riwayat.export') }}" class="btn btn-success btn-sm shadow-sm">
                <i class="fa-solid fa-file-excel me-2"></i>
                <span class="d-none d-sm-inline">Export Excel</span>
                <span class="d-inline d-sm-none">Excel</span>
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive p-2 p-md-3">
                {{-- Gunakan class verifikasi-table --}}
                <table class="table verifikasi-table table-hover" id="riwayatTable" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Nama Siswa</th>
                            <th class="text-center">Kelas</th>
                            <th>Jenis Pelanggaran</th>
                            <th class="text-center">Poin</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pelanggarans as $p)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td><strong>{{ $p->siswa->nama_siswa }}</strong></td>
                            <td class="text-center"><span class="badge bg-info">{{ $p->siswa->kelas->nama_kelas ?? '-' }}</span></td>
                            <td>{{ $p->jenisPelanggaran->nama_pelanggaran }}</td>
                            <td class="text-center"><span class="badge bg-danger">{{ $p->poin }}</span></td>
                            <td class="text-center">
                                @if($p->status_verifikasi == 'diverifikasi')
                                    <span class="badge bg-success">Diverifikasi</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('kesiswaan.verifikasi.show', $p->id) }}" class="btn btn-info btn-sm" title="Detail">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Belum ada riwayat verifikasi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('kesiswaan/verifikasi.js') }}" defer></script>
@endpush
