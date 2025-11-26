@extends('kepsek.layouts.app')

@section('title', 'Monitoring Kasus Berat')

@push('styles')
    <link rel="stylesheet" href="{{ asset('kepsek/monitoring.css') }}">
@endpush

@section('content')

    <div class="mb-4">
        <h3 class="mb-1">Monitoring Kasus Berat</h3>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-dark"><i class="fa-solid fa-list me-2"></i></h6>
            <div class="d-flex gap-2">
                <a href="{{ route('kepsek.monitoring.create') }}" class="btn btn-primary btn-sm shadow-sm">
                    <i class="fa-solid fa-plus me-2"></i>
                    <span class="d-none d-sm-inline">Tambah Monitoring</span>
                    <span class="d-inline d-sm-none">Tambah</span>
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive p-2 p-md-3">
                <table class="table table-hover" id="monitoringTable" style="width:100%;">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 3%;"></th>
                            <th class="text-center" style="width: 5%;">No</th>
                            <th style="width: 20%;">Siswa</th>
                            <th style="width: 25%;">Pelanggaran</th>
                            <th class="text-center" style="width: 8%;">Poin</th>
                            <th class="text-center" style="width: 12%;">Status</th>
                            <th style="width: 12%;">Tanggal</th>
                            <th class="text-center" style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($monitoring as $index => $item)
                            <tr>
                                <td class="text-center"></td>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td><strong>{{ $item->pelanggaran->siswa->nama_siswa ?? '-' }}</strong></td>
                                <td>{{ $item->pelanggaran->jenisPelanggaran->nama_pelanggaran ?? '-' }}</td>
                                <td class="text-center"><span class="badge bg-danger">{{ $item->pelanggaran->poin }}</span></td>
                                <td class="text-center"><span class="badge bg-info">{{ $item->status_monitoring }}</span></td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_monitoring)->format('d/m/Y') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('kepsek.monitoring.show', $item->id) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('kepsek.monitoring.edit', $item->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fa-solid fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}" title="Hapus">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Belum ada data monitoring</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@foreach($monitoring as $item)
<div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fa-solid fa-trash me-2"></i>Konfirmasi Hapus</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Apakah Anda yakin ingin menghapus data monitoring untuk siswa <strong>{{ $item->pelanggaran->siswa->nama_siswa ?? '-' }}</strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('kepsek.monitoring.destroy', $item->id) }}" method="POST" class="d-inline">
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
    <script src="{{ asset('kepsek/monitoring.js') }}" defer></script>
@endpush
