@extends('kepsek.layouts.app')

@section('title', 'Profil Saya')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Profil Saya</h1>
        <a href="{{ route('kepsek.dashboard') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-body text-center">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama_lengkap ?? 'User') }}&size=150&background=0d6efd&color=fff" 
                         alt="Avatar" 
                         class="rounded-circle mb-3"
                         style="width: 150px; height: 150px;">
                    <h4 class="mb-1">{{ Auth::user()->nama_lengkap }}</h4>
                    <p class="text-muted mb-3">
                        <span class="badge bg-primary">{{ strtoupper(Auth::user()->level) }}</span>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Akun</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong><i class="fa-solid fa-user me-2"></i>Nama Lengkap</strong>
                        </div>
                        <div class="col-sm-8">
                            {{ Auth::user()->nama_lengkap ?? '-' }}
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong><i class="fa-solid fa-at me-2"></i>Username</strong>
                        </div>
                        <div class="col-sm-8">
                            {{ Auth::user()->username }}
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong><i class="fa-solid fa-envelope me-2"></i>Email</strong>
                        </div>
                        <div class="col-sm-8">
                            {{ Auth::user()->email ?? '-' }}
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong><i class="fa-solid fa-shield-halved me-2"></i>Role</strong>
                        </div>
                        <div class="col-sm-8">
                            <span class="badge bg-primary">{{ strtoupper(Auth::user()->level) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
