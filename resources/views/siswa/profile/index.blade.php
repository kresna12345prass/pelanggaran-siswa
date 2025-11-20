@extends('siswa.layouts.app')

@section('title', 'Profil Siswa')

@push('styles')
    @vite('resources/css/siswa/profile.css')
@endpush

@section('content')
<div class="container-fluid">
    
    <div class="page-header d-flex justify-content-between align-items-center">
        <h1 class="page-title">👤 Profil Siswa</h1>
        <a href="{{ route('siswa.dashboard') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    @if($siswa->foto)
                        <img src="{{ asset('storage/'.$siswa->foto) }}" alt="Foto" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($siswa->nama_siswa) }}&size=150&background=0d6efd&color=fff" alt="Avatar" class="img-fluid rounded-circle mb-3">
                    @endif
                    <h4>{{ $siswa->nama_siswa }}</h4>
                    <p class="text-muted">{{ $siswa->nis }}</p>
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
                            <td><strong>Tempat, Tanggal Lahir</strong></td>
                            <td>: {{ $siswa->tempat_lahir }}, {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d/m/Y') : '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Jenis Kelamin</strong></td>
                            <td>: {{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Agama</strong></td>
                            <td>: {{ $siswa->agama }}</td>
                        </tr>
                        <tr>
                            <td><strong>Alamat</strong></td>
                            <td>: {{ $siswa->alamat }}</td>
                        </tr>
                        <tr>
                            <td><strong>No. Telepon</strong></td>
                            <td>: {{ $siswa->no_telepon }}</td>
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
    @vite('resources/js/siswa/profile.js')
@endpush
