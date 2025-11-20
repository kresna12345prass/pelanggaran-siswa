@extends('bk.layouts.app')

@section('title', 'Data Konseling')

@push('styles')
    @vite('resources/css/bk/konseling.css')
@endpush

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h3 class="mb-1">Data Konseling</h3>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if($rekomendasi->count() > 0)
    <div class="card shadow-sm border-0 mb-4 border-start border-warning border-4">
        <div class="card-header py-3 bg-warning bg-opacity-10">
            <h6 class="m-0 fw-bold text-warning">
                <i class="fa-solid fa-exclamation-triangle me-2"></i>
                Rekomendasi Konseling dari Sanksi ({{ $rekomendasi->count() }})
            </h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive p-2 p-md-3">
                <table class="table table-hover mb-0" style="font-size: 1.15rem;">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 25%;">Siswa</th>
                            <th style="width: 20%;">Jenis Sanksi</th>
                            <th style="width: 30%;">Deskripsi</th>
                            <th style="width: 10%;">Tanggal</th>
                            <th class="text-center" style="width: 10%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rekomendasi as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $item->pelanggaran->siswa->nama_siswa }}</strong><br>
                                <small class="text-muted">{{ $item->pelanggaran->siswa->kelas->nama_kelas ?? '-' }}</small>
                            </td>
                            <td>
                                <span class="badge bg-danger">{{ $item->jenis_sanksi }}</span>
                            </td>
                            <td><small>{{ Str::limit($item->deskripsi_hukuman, 50) }}</small></td>
                            <td><small>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d/m/Y') }}</small></td>
                            <td class="text-center">
                                <a href="{{ route('bk.konseling.create', ['sanksi_id' => $item->id]) }}" 
                                   class="btn btn-sm btn-primary" 
                                   title="Buat Konseling">
                                    <i class="fa-solid fa-plus me-1"></i> Konseling
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-dark"><i class="fa-solid fa-list me-2"></i>Daftar Konseling</h6>
            <div class="d-flex gap-2">
                <a href="{{ route('bk.konseling.export') }}" class="btn btn-success btn-sm shadow-sm">
                    <i class="fa-solid fa-file-excel me-2"></i>
                    <span class="d-none d-sm-inline">Export Excel</span>
                    <span class="d-inline d-sm-none">Excel</span>
                </a>
                <a href="{{ route('bk.konseling.create') }}" class="btn btn-primary btn-sm shadow-sm">
                    <i class="fa-solid fa-plus me-2"></i>
                    <span class="d-none d-sm-inline">Tambah Konseling</span>
                    <span class="d-inline d-sm-none">Tambah</span>
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive p-2 p-md-3">
                <table id="konselingTable" class="table table-hover" style="width:100%; font-size: 1.15rem;">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 3%;"></th>
                            <th class="text-center" style="width: 5%;">No</th>
                            <th style="width: 30%;">Siswa</th>
                            <th style="width: 37%;">Topik</th>
                            <th class="text-center" style="width: 10%;">Status</th>
                            <th class="text-center" style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($konseling as $index => $item)
                        <tr>
                            <td class="text-center"></td>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td><strong>{{ $item->siswa->nama_siswa }}</strong></td>
                            <td>{{ $item->topik }}</td>
                            <td class="text-center">
                                <span class="badge bg-{{ $item->status == 'selesai' ? 'success' : ($item->status == 'aktif' ? 'warning' : 'info') }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('bk.konseling.show', $item->id) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('bk.konseling.edit', $item->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fa-solid fa-edit"></i>
                                </a>
                                <form action="{{ route('bk.konseling.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')" title="Hapus">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    @vite('resources/js/bk/konseling.js')
@endpush
