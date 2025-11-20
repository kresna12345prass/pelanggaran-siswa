@extends('admin.layouts.app')

@section('title', 'Detail Kelas: ' . $kelas->nama_kelas)

@push('styles')
    @vite('resources/css/admin/kelas.css')
@endpush

@section('content')
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Kelas</h1>
        <a href="{{ route('admin.kelas.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fa-solid fa-arrow-left me-2"></i>
            Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card kelas-detail-card shadow-sm h-100">
                <div class="card-header py-3 bg-light">
                    <h6 class="m-0 fw-bold text-primary"><i class="fa-solid fa-school me-2"></i>Informasi Kelas</h6>
                </div>
                <div class="card-body p-4">
                    <div class="detail-item mb-3">
                        <small class="text-muted d-block mb-1">Nama Kelas</small>
                        <strong class="fs-5">{{ $kelas->nama_kelas }}</strong>
                    </div>
                    <div class="detail-item mb-3">
                        <small class="text-muted d-block mb-1">Jurusan</small>
                        <strong>{{ $kelas->jurusan?->nama_jurusan ?? '-' }}</strong>
                    </div>
                    <div class="detail-item mb-3">
                        <small class="text-muted d-block mb-1">Kapasitas</small>
                        <strong>{{ $kelas->kapasitas ?? '-' }} Siswa</strong>
                    </div>
                    <div class="detail-item mb-3">
                        <small class="text-muted d-block mb-1">Wali Kelas</small>
                        <strong>{{ $kelas->waliKelas->first()?->guru?->nama_guru ?? '-' }}</strong>
                    </div>
                    <div class="detail-item">
                        <small class="text-muted d-block mb-1">Jumlah Siswa Saat Ini</small>
                        <strong class="fs-5 text-success">{{ $kelas->siswa->count() }} Siswa</strong>
                    </div>
                </div>
                <div class="card-footer bg-light d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.kelas.edit', $kelas) }}" class="btn btn-warning">
                        <i class="fa-solid fa-pencil-alt me-2"></i>Edit Kelas
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-8 mb-4">
            <div class="card kelas-detail-card shadow-sm h-100">
                <div class="card-header py-3 bg-light">
                    <h6 class="m-0 fw-bold text-primary"><i class="fa-solid fa-users me-2"></i>Daftar Siswa di Kelas Ini</h6>
                </div>
                <div class="card-body p-2">
                    @if($kelas->siswa->isEmpty())
                        <div class="alert alert-info m-3">
                            <i class="fa-solid fa-info-circle me-2"></i>
                            Belum ada siswa yang terdaftar di kelas ini.
                        </div>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($kelas->siswa as $siswa)
                                <a href="{{ route('admin.siswa.show', $siswa) }}" class="list-group-item list-group-item-action student-list-item">
                                    @if($siswa->foto)
                                        <img src="{{ Storage::url($siswa->foto) }}" alt="{{ $siswa->nama_siswa }}">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($siswa->nama_siswa) }}&background=198754&color=fff" alt="{{ $siswa->nama_siswa }}">
                                    @endif
                                    <div>
                                        <div class="nama">{{ $siswa->nama_siswa }}</div>
                                        <div class="nis">NIS: {{ $siswa->nis }} | NISN: {{ $siswa->nisn }}</div>
                                    </div>
                                    <i class="fa-solid fa-chevron-right ms-auto text-muted"></i>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection