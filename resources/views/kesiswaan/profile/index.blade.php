@extends('kesiswaan.layouts.app')
@section('title', 'Profil Saya')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">👤 Profil Saya</h3>
        <a href="{{ route('kesiswaan.dashboard.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama_lengkap) }}&size=150&background=0d6efd&color=fff" class="rounded-circle mb-3" alt="Avatar">
                    <h5>{{ Auth::user()->nama_lengkap }}</h5>
                    <p class="text-muted">{{ Auth::user()->email }}</p>
                    <span class="badge bg-primary">{{ strtoupper(Auth::user()->level) }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Informasi Akun</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th width="200">Username</th>
                            <td>{{ Auth::user()->username }}</td>
                        </tr>
                        <tr>
                            <th>Nama Lengkap</th>
                            <td>{{ Auth::user()->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ Auth::user()->email }}</td>
                        </tr>
                        <tr>
                            <th>Level</th>
                            <td><span class="badge bg-primary">{{ strtoupper(Auth::user()->level) }}</span></td>
                        </tr>
                        <tr>
                            <th>Spesialisasi</th>
                            <td>{{ Auth::user()->spesialisasi ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Terdaftar Sejak</th>
                            <td>{{ \Carbon\Carbon::parse(Auth::user()->created_at)->format('d F Y') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
