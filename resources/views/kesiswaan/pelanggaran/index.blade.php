@extends('kesiswaan.layouts.app')
@section('title', 'Data Pelanggaran')

@push('styles')
    @vite('resources/css/kesiswaan/pelanggaran.css')
@endpush

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h3 class="mb-1">📝 Data Pelanggaran</h3>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm mb-4 border-0">
        <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-dark"><i class="fa-solid fa-list me-2"></i>Daftar Pelanggaran</h6>
            <div class="d-flex gap-2">
                <a href="{{ route('kesiswaan.pelanggaran.export') }}" class="btn btn-success btn-sm shadow-sm">
                    <i class="fa-solid fa-file-excel me-2"></i>
                    <span class="d-none d-sm-inline">Export Excel</span>
                    <span class="d-inline d-sm-none">Excel</span>
                </a>
                <a href="{{ route('kesiswaan.pelanggaran.create') }}" class="btn btn-primary btn-sm shadow-sm">
                    <i class="fa-solid fa-plus me-2"></i>
                    <span class="d-none d-sm-inline">Tambah Pelanggaran</span>
                    <span class="d-inline d-sm-none">Tambah</span>
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive p-2 p-md-3">
                <table class="table table-hover align-middle" id="pelanggaranTable" style="width:100%; font-size: 0.875rem;">
                    <thead class="table-light">
                        <tr style="font-size: 0.813rem;">
                            <th style="width: 5%;">No</th>
                            <th style="width: 20%;">Siswa</th>
                            <th style="width: 10%;">Kelas</th>
                            <th style="width: 35%;">Pelanggaran</th>
                            <th class="text-center" style="width: 10%;">Tanggal</th>
                            <th class="text-center" style="width: 8%;">Poin</th>
                            <th class="text-center" style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pelanggarans as $p)
                        <tr>
                            <td style="font-size: 0.813rem;">{{ $loop->iteration }}</td>
                            <td style="font-size: 0.813rem;"><strong>{{ $p->siswa->nama_siswa }}</strong></td>
                            <td><span class="badge bg-info" style="font-size: 0.75rem;">{{ $p->siswa->kelas->nama_kelas ?? '-' }}</span></td>
                            <td style="font-size: 0.813rem;">{{ $p->jenisPelanggaran->nama_pelanggaran }}</td>
                            <td class="text-center" style="font-size: 0.813rem;">{{ \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y') }}</td>
                            <td class="text-center"><span class="badge bg-danger" style="font-size: 0.75rem;">{{ $p->poin }}</span></td>
                            <td class="text-center">
                                <a href="{{ route('kesiswaan.pelanggaran.show', $p->id) }}" class="btn btn-sm btn-info" style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('kesiswaan.pelanggaran.edit', $p->id) }}" class="btn btn-sm btn-warning" style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">
                                    <i class="fa-solid fa-edit"></i>
                                </a>
                                <a href="{{ route('kesiswaan.pelanggaran.exportPdf', $p->id) }}" class="btn btn-sm btn-secondary" style="font-size: 0.75rem; padding: 0.25rem 0.5rem;" title="Export PDF">
                                    <i class="fa-solid fa-file-pdf"></i>
                                </a>
                                <form action="{{ route('kesiswaan.pelanggaran.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted" style="font-size: 0.875rem;">Belum ada data pelanggaran</td>
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
    @vite('resources/js/kesiswaan/pelanggaran.js')
@endpush
