@extends('kesiswaan.layouts.app')
@section('title', 'Data Sanksi')

@push('styles')
    <link rel="stylesheet" href="{{ asset('kesiswaan/sanksi.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h3 class="mb-1">⚖️ Data Sanksi</h3>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm mb-4 border-0">
        <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-dark"><i class="fa-solid fa-list me-2"></i> Daftar Sanksi</h6>
            <div class="d-flex gap-2">
                <a href="{{ route('kesiswaan.sanksi.export') }}" class="btn btn-success btn-sm shadow-sm">
                    <i class="fa-solid fa-file-excel me-2"></i>
                    <span class="d-none d-sm-inline">Export Excel</span>
                    <span class="d-inline d-sm-none">Excel</span>
                </a>
                <a href="{{ route('kesiswaan.sanksi.create') }}" class="btn btn-primary btn-sm shadow-sm">
                    <i class="fa-solid fa-plus me-2"></i>
                    <span class="d-none d-sm-inline">Tetapkan Sanksi</span>
                    <span class="d-inline d-sm-none">Tambah</span>
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive p-2 p-md-3">
                {{-- Tabel Index --}}
                <table class="table sanksi-table table-hover" id="sanksiTable" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Siswa</th>
                            <th class="text-center">Kelas</th>
                            <th>Jenis Sanksi</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sanksis as $sanksi)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td><strong>{{ $sanksi->pelanggaran->siswa->nama_siswa }}</strong></td>
                            <td class="text-center"><span class="badge bg-info">{{ $sanksi->pelanggaran->siswa->kelas->nama_kelas ?? '-' }}</span></td>
                            <td>{{ $sanksi->jenis_sanksi }}</td>
                            <td class="text-center">
                                @if($sanksi->status_sanksi == 'berjalan')
                                    <span class="badge bg-warning">Berjalan</span>
                                @elseif($sanksi->status_sanksi == 'selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @elseif($sanksi->status_sanksi == 'terlambat')
                                    <span class="badge bg-danger">Terlambat</span>
                                @else
                                    <span class="badge bg-secondary">Pending</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="action-buttons">
                                    <a href="{{ route('kesiswaan.sanksi.show', $sanksi->id) }}" class="btn btn-info btn-sm" title="Detail">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('kesiswaan.sanksi.edit', $sanksi->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fa-solid fa-pencil-alt"></i>
                                    </a>
                                    <div class="btn-group">
                                        <button class="btn btn-danger btn-sm dropdown-toggle" data-bs-toggle="dropdown" title="Cetak">
                                            <i class="fa-solid fa-file-pdf"></i>
                                        </button>
                                        <ul class="dropdown-menu shadow-sm">
                                            <li><a class="dropdown-item" href="{{ route('kesiswaan.sanksi.cetak-peringatan', $sanksi->id) }}" target="_blank">Surat Peringatan</a></li>
                                            <li><a class="dropdown-item" href="{{ route('kesiswaan.sanksi.cetak-panggilan', $sanksi->id) }}" target="_blank">Surat Panggilan</a></li>
                                            <li><a class="dropdown-item" href="{{ route('kesiswaan.sanksi.cetak-skorsing', $sanksi->id) }}" target="_blank">Surat Skorsing</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada data sanksi</td>
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
    <script src="{{ asset('kesiswaan/sanksi.js') }}" defer></script>
@endpush