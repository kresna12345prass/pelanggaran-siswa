@extends('admin.layouts.app')

@section('title', 'Manajemen Siswa')

@push('styles')
    @vite('resources/css/admin/siswa.css')
@endpush

@section('content')
    
    <div class="mb-4">
        <h1 class="h3 mb-1 text-gray-800">Manajemen Siswa</h1>
        <p class="text-muted mb-0 small">Kelola data siswa sekolah</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm mb-4 border-0">
        <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-dark"><i class="fa-solid fa-users me-2"></i>Daftar Siswa</h6>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.siswa.export') }}" class="btn btn-success btn-sm shadow-sm">
                    <i class="fa-solid fa-file-excel me-2"></i>
                    <span class="d-none d-sm-inline">Export Excel</span>
                    <span class="d-inline d-sm-none">Excel</span>
                </a>
                <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary btn-sm shadow-sm">
                    <i class="fa-solid fa-user-plus me-2"></i>
                    <span class="d-none d-sm-inline">Tambah Siswa Baru</span>
                    <span class="d-inline d-sm-none">Tambah</span>
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive p-2 p-md-3">
                
                <table class="table siswa-table table-hover" id="siswaTable" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 5%;">No.</th>
                            <th class="text-center" style="width: 8%;">Foto</th>
                            <th style="width: 12%; padding-right: 30px;">NIS</th>
                            <th style="width: 30%;">Nama Siswa</th>
                            <th style="width: 15%;">Kelas</th>
                            <th class="text-center" style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($siswa as $s)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">
                                    @if($s->foto)
                                        <img src="{{ Storage::url($s->foto) }}" alt="{{ $s->nama_siswa }}" class="siswa-avatar">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($s->nama_siswa) }}&background=198754&color=fff" 
                                             alt="{{ $s->nama_siswa }}" class="siswa-avatar">
                                    @endif
                                </td>
                                <td>{{ $s->nis }}</td>
                                <td><strong>{{ $s->nama_siswa }}</strong></td>
                                <td><span class="badge bg-info">{{ $s->kelas->nama_kelas ?? 'N/A' }}</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.siswa.show', $s) }}" class="btn btn-info btn-sm" title="Lihat Detail">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.siswa.edit', $s) }}" class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fa-solid fa-pencil-alt"></i>
                                        </a>
                                        <button class="btn btn-danger btn-sm" 
                                                title="Hapus" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteSiswaModal"
                                                data-siswa-name="{{ $s->nama_siswa }}"
                                                data-delete-url="{{ route('admin.siswa.destroy', $s) }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data siswa ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Custom Delete Modal -->
    <div class="modal fade" id="deleteSiswaModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-body text-center p-5">
                    <div class="mb-4">
                        <div class="delete-icon-wrapper mx-auto mb-3">
                            <i class="fa-solid fa-trash-can text-danger" style="font-size: 3rem;"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-2">Hapus Data Siswa?</h4>
                        <p class="text-muted mb-0">Data siswa <strong class="text-danger" id="siswaNameToDelete"></strong> akan dihapus permanen.</p>
                        <p class="text-muted small">Tindakan ini tidak dapat dibatalkan!</p>
                    </div>
                    
                    <div class="d-flex gap-3 justify-content-center">
                        <button type="button" class="btn btn-light px-4 py-2" data-bs-dismiss="modal">
                            <i class="fa-solid fa-times me-2"></i>Batal
                        </button>
                        <form id="deleteSiswaForm" method="POST" action="" class="d-inline">
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

@endsection

@push('scripts')
    @vite('resources/js/admin/siswa.js')
@endpush