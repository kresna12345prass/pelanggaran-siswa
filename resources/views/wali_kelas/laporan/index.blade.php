@extends('wali_kelas.layouts.app')

@section('title', 'Laporan Pelanggaran')

@push('styles')
    @vite('resources/css/wali_kelas/laporan.css')
@endpush

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h3 class="mb-1">Laporan Pelanggaran</h3>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-dark"><i class="fa-solid fa-list me-2"></i></h6>
            <div class="d-flex gap-2">
                <a href="{{ route('wali_kelas.laporan.create') }}" class="btn btn-primary btn-sm shadow-sm">
                    <i class="fa-solid fa-plus me-2"></i>
                    <span class="d-none d-sm-inline">Buat Laporan</span>
                    <span class="d-inline d-sm-none">Tambah</span>
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive p-2 p-md-3">
                <table id="laporanTable" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 3%;"></th>
                            <th class="text-center" style="width: 5%;">No</th>
                            <th style="width: 12%;">Tanggal</th>
                            <th style="width: 20%;">Siswa</th>
                            <th style="width: 30%;">Pelanggaran</th>
                            <th class="text-center" style="width: 8%;">Poin</th>
                            <th class="text-center" style="width: 10%;">Status</th>
                            <th class="text-center" style="width: 12%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporan as $index => $item)
                        <tr>
                            <td class="text-center"></td>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y H:i') }}</td>
                            <td><strong>{{ $item->siswa->nama_siswa }}</strong></td>
                            <td>{{ $item->jenisPelanggaran->nama_pelanggaran }}</td>
                            <td class="text-center"><span class="badge bg-danger">{{ $item->poin }}</span></td>
                            <td class="text-center">
                                @if($item->status_verifikasi == 'menunggu')
                                    <span class="badge bg-warning">Menunggu</span>
                                @elseif($item->status_verifikasi == 'diverifikasi')
                                    <span class="badge bg-success">Disetujui</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('wali_kelas.laporan.show', $item->id) }}" class="btn btn-sm btn-info" title="Detail">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                @if($item->status_verifikasi == 'menunggu')
                                <a href="{{ route('wali_kelas.laporan.edit', $item->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fa-solid fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}" title="Hapus">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Belum ada laporan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@foreach($laporan as $item)
<div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fa-solid fa-trash me-2"></i>Konfirmasi Hapus</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Apakah Anda yakin ingin menghapus laporan pelanggaran siswa <strong>{{ $item->siswa->nama_siswa }}</strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('wali_kelas.laporan.destroy', $item->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection

@push('scripts')
    @vite('resources/js/wali_kelas/laporan.js')
@endpush
