@extends('admin.layouts.app')

@section('title', 'Manajemen Wali Kelas')

@push('styles')
    {{-- Cukup panggil vite saja, import datatables sudah ada di dalam file css --}}
    @vite('resources/css/admin/wali_kelas.css')
@endpush

@section('content')
    
    <div class="mb-4">
        <h1 class="h3 mb-1 text-gray-800">Manajemen Wali Kelas</h1>
        <p class="text-muted mb-0 small">Kelola penugasan wali kelas per tahun ajaran</p>
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
            <h6 class="m-0 fw-bold text-dark"><i class="fa-solid fa-chalkboard-user me-2"></i></h6>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.wali_kelas.export') }}" class="btn btn-success btn-sm shadow-sm">
                    <i class="fa-solid fa-file-excel me-2"></i>
                    <span class="d-none d-sm-inline">Export Excel</span>
                    <span class="d-inline d-sm-none">Excel</span>
                </a>
                <a href="{{ route('admin.wali_kelas.create') }}" class="btn btn-primary btn-sm shadow-sm">
                    <i class="fa-solid fa-plus me-2"></i>
                    <span class="d-none d-sm-inline">Tambah Wali Kelas</span>
                    <span class="d-inline d-sm-none">Tambah</span>
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive p-2 p-md-3">
                
                {{-- PERUBAHAN DISINI: Tambahkan class 'wk-table' dan hapus inline style font-size --}}
                <table class="table wk-table table-hover" id="waliKelasTable" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th>Wali Kelas</th>
                            <th class="text-center">Kelas</th>
                            <th class="text-center">Jurusan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($waliKelas as $wk)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $wk->guru->nama_guru }}</td>
                                <td class="text-center"><span class="badge bg-primary">{{ $wk->kelas->nama_kelas }}</span></td>
                                <td class="text-center">{{ $wk->kelas->jurusan?->nama_jurusan ?? '-' }}</td>
                                <td class="text-center">
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.wali_kelas.show', $wk) }}" class="btn btn-info btn-sm" title="Lihat Detail">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.wali_kelas.edit', $wk) }}" class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fa-solid fa-pencil-alt"></i>
                                        </a>
                                        <button class="btn btn-danger btn-sm" 
                                                title="Hapus" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteWaliKelasModal"
                                                data-wali-kelas-name="{{ $wk->guru->nama_guru }} - {{ $wk->kelas->nama_kelas }}"
                                                data-delete-url="{{ route('admin.wali_kelas.destroy', $wk) }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data wali kelas ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade" id="deleteWaliKelasModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Hapus Wali Kelas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="modal-body-text">Apakah Anda yakin? Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteWaliKelasForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    {{-- JS juga disamakan cara panggilnya, import library via file JS --}}
    @vite('resources/js/admin/wali_kelas.js')
@endpush