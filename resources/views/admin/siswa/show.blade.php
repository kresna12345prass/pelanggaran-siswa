@extends('admin.layouts.app')

@section('title', 'Detail Siswa: ' . $siswa->nama_siswa)

@push('styles')
    @vite('resources/css/admin/siswa.css')
@endpush

@section('content')
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Siswa</h1>
        <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fa-solid fa-arrow-left me-2"></i>
            Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card siswa-detail-card shadow-sm h-100">
                <div class="card-body text-center p-4">
                    @if($siswa->foto)
                        <img src="{{ Storage::url($siswa->foto) }}" alt="{{ $siswa->nama_siswa }}" class="rounded-circle mb-3 shadow-sm"
                             style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                         <img src="https://ui-avatars.com/api/?name={{ urlencode($siswa->nama_siswa) }}&background=198754&color=fff&size=150" 
                             alt="{{ $siswa->nama_siswa }}" class="rounded-circle mb-3 shadow-sm"
                             style="width: 150px; height: 150px;">
                    @endif
                    
                    <h4 class="fw-bold mb-2">{{ $siswa->nama_siswa }}</h4>
                    <p class="text-muted mb-1"><i class="fa-solid fa-id-card me-2"></i>NIS: {{ $siswa->nis }}</p>
                    <p class="text-primary mb-3"><i class="fa-solid fa-id-badge me-2"></i>NISN: {{ $siswa->nisn }}</p>
                    
                    <span class="badge fs-6 bg-success px-3 py-2">{{ $siswa->kelas->nama_kelas ?? 'N/A' }}</span>
                </div>
            </div>
        </div>

        <div class="col-lg-8 mb-4">
            <div class="card siswa-detail-card shadow-sm h-100">
                <div class="card-header py-3 bg-light">
                    <h6 class="m-0 fw-bold text-primary"><i class="fa-solid fa-info-circle me-2"></i>Informasi Data Siswa</h6>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="detail-item">
                                <small class="text-muted d-block mb-1">Nama Lengkap</small>
                                <strong>{{ $siswa->nama_siswa }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <small class="text-muted d-block mb-1">Kelas</small>
                                <strong>{{ $siswa->kelas->nama_kelas ?? 'N/A' }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <small class="text-muted d-block mb-1">NIS</small>
                                <strong>{{ $siswa->nis }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <small class="text-muted d-block mb-1">NISN</small>
                                <strong>{{ $siswa->nisn }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <small class="text-muted d-block mb-1">Tempat, Tanggal Lahir</small>
                                <strong>{{ $siswa->tempat_lahir ?? '-' }}, {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d M Y') : '-' }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <small class="text-muted d-block mb-1">Jenis Kelamin</small>
                                <strong>
                                    @if($siswa->jenis_kelamin == 'L') Laki-laki
                                    @elseif($siswa->jenis_kelamin == 'P') Perempuan
                                    @else -
                                    @endif
                                </strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <small class="text-muted d-block mb-1">Agama</small>
                                <strong>{{ $siswa->agama ?? '-' }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <small class="text-muted d-block mb-1">No. Telepon</small>
                                <strong>{{ $siswa->no_telepon ?? '-' }}</strong>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="detail-item">
                                <small class="text-muted d-block mb-1">Alamat</small>
                                <strong>{{ $siswa->alamat ?? '-' }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.siswa.edit', $siswa) }}" class="btn btn-warning">
                        <i class="fa-solid fa-pencil-alt me-2"></i>Edit Siswa
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection