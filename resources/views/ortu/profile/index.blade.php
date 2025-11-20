@extends('ortu.layouts.app')

@section('title', 'Profil Orang Tua')

@push('styles')
    @vite('resources/css/ortu/profile.css')
@endpush

@section('content')
<div class="container-fluid">
    
    <div class="page-header d-flex justify-content-between align-items-center">
        <h1 class="page-title">👤 Profil Orang Tua</h1>
        <a href="{{ route('ortu.dashboard') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->nama_lengkap) }}&size=150&background=0d6efd&color=fff" alt="Avatar" class="img-fluid rounded-circle mb-3">
                    <h4>{{ $user->nama_lengkap }}</h4>
                    <p class="text-muted">Orang Tua</p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fa-solid fa-user me-2"></i>Data Pribadi</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td width="200"><strong>Nama Lengkap</strong></td>
                            <td>: {{ $user->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <td><strong>Hubungan</strong></td>
                            <td>: {{ $orangtua->hubungan }}</td>
                        </tr>
                        <tr>
                            <td><strong>No Telepon</strong></td>
                            <td>: {{ $orangtua->no_telepon ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Pendidikan</strong></td>
                            <td>: {{ $orangtua->pendidikan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Pekerjaan</strong></td>
                            <td>: {{ $orangtua->pekerjaan }}</td>
                        </tr>
                        <tr>
                            <td><strong>Alamat</strong></td>
                            <td>: {{ $orangtua->alamat }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5><i class="fa-solid fa-child me-2"></i>Data Anak</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td width="200"><strong>NIS</strong></td>
                            <td>: {{ $siswa->nis }}</td>
                        </tr>
                        <tr>
                            <td><strong>NISN</strong></td>
                            <td>: {{ $siswa->nisn }}</td>
                        </tr>
                        <tr>
                            <td><strong>Nama Lengkap</strong></td>
                            <td>: {{ $siswa->nama_siswa }}</td>
                        </tr>
                        <tr>
                            <td><strong>Kelas</strong></td>
                            <td>: {{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Jurusan</strong></td>
                            <td>: {{ $siswa->kelas->jurusan->nama_jurusan ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5><i class="fa-solid fa-key me-2"></i>Informasi Akun</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td width="200"><strong>Username</strong></td>
                            <td>: {{ $user->username }}</td>
                        </tr>
                        <tr>
                            <td><strong>Email</strong></td>
                            <td>: {{ $user->email }}</td>
                        </tr>
                        <tr>
                            <td><strong>Level</strong></td>
                            <td>: <span class="badge bg-primary">{{ strtoupper($user->level) }}</span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
    @vite('resources/js/ortu/profile.js')
@endpush
