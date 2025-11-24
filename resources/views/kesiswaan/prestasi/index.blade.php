@extends('kesiswaan.layouts.app')
@section('title', 'Data Prestasi')

@push('styles')
    @vite('resources/css/kesiswaan/prestasi.css')
@endpush

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h3 class="mb-1">🏆 Data Prestasi</h3>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm mb-4 border-0">
        <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-dark"><i class="fa-solid fa-trophy me-2"></i> Daftar Prestasi</h6>
            <div class="d-flex gap-2">
                <a href="{{ route('kesiswaan.prestasi.export') }}" class="btn btn-success btn-sm shadow-sm">
                    <i class="fa-solid fa-file-excel me-2"></i>
                    <span class="d-none d-sm-inline">Export Excel</span>
                    <span class="d-inline d-sm-none">Excel</span>
                </a>
                <a href="{{ route('kesiswaan.prestasi.create') }}" class="btn btn-primary btn-sm shadow-sm">
                    <i class="fa-solid fa-plus me-2"></i>
                    <span class="d-none d-sm-inline">Tambah Prestasi</span>
                    <span class="d-inline d-sm-none">Tambah</span>
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive p-2 p-md-3">
                {{-- Gunakan class prestasi-table --}}
                <table class="table prestasi-table table-hover" id="prestasiTable" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th>Nama Siswa</th>
                            <th class="text-center">Kelas</th>
                            <th>Jenis Prestasi</th>
                            <th class="text-center">Tingkat</th>
                            <th class="text-center">Poin</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($prestasis as $index => $p)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td><strong>{{ $p->siswa->nama_siswa }}</strong></td>
                            <td class="text-center"><span class="badge bg-info">{{ $p->siswa->kelas->nama_kelas ?? '-' }}</span></td>
                            <td>{{ $p->jenisPrestasi->nama_prestasi }}</td>
                            <td class="text-center"><span class="badge bg-secondary">{{ $p->tingkat }}</span></td>
                            <td class="text-center"><span class="badge bg-success">+{{ $p->poin }}</span></td>
                            <td class="text-center">
                                <div class="action-buttons">
                                    <a href="{{ route('kesiswaan.prestasi.show', $p->id) }}" class="btn btn-info btn-sm" title="Detail">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('kesiswaan.prestasi.edit', $p->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fa-solid fa-edit"></i>
                                    </a>
                                    <button class="btn btn-danger btn-sm" 
                                            title="Hapus" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deletePrestasiModal"
                                            data-siswa-name="{{ $p->siswa->nama_siswa }}"
                                            data-delete-url="{{ route('kesiswaan.prestasi.destroy', $p->id) }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Belum ada data prestasi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deletePrestasiModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-body text-center p-5">
                    <div class="mb-4">
                        <div class="delete-icon-wrapper mx-auto mb-3">
                            <i class="fa-solid fa-trash-can text-danger" style="font-size: 3rem;"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-2">Hapus Data Prestasi?</h4>
                        <p class="text-muted mb-0">Data prestasi siswa <strong class="text-danger" id="siswaNameToDelete"></strong> akan dihapus permanen.</p>
                        <p class="text-muted small">Tindakan ini tidak dapat dibatalkan!</p>
                    </div>
                    
                    <div class="d-flex gap-3 justify-content-center">
                        <button type="button" class="btn btn-light px-4 py-2" data-bs-dismiss="modal">
                            <i class="fa-solid fa-times me-2"></i>Batal
                        </button>
                        <form id="deletePrestasiForm" method="POST" action="" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger px-4 py-2">
                                <i class="fa-solid fa-trash me-2"></i>Ya, Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    @vite('resources/js/kesiswaan/prestasi.js')
@endpush