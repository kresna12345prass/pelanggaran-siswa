@extends('bk.layouts.app')

@section('title', 'Profil BK')

@push('styles')
    <link rel="stylesheet" href="{{ asset('bk/profile.css') }}">
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Profil Saya</h1>
        <a href="{{ route('bk.dashboard') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama_lengkap) }}&size=150&background=0d6efd&color=fff" 
                         alt="Avatar" class="rounded-circle mb-3">
                    <h5>{{ Auth::user()->nama_lengkap }}</h5>
                    <p class="text-muted">{{ Auth::user()->email }}</p>
                    <span class="badge bg-primary">{{ strtoupper(Auth::user()->level) }}</span>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="fa-solid fa-user-circle"></i> Informasi Akun</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%"><i class="fa-solid fa-user"></i> Username</th>
                            <td>{{ Auth::user()->username }}</td>
                        </tr>
                        <tr>
                            <th><i class="fa-solid fa-id-card"></i> Nama Lengkap</th>
                            <td>{{ Auth::user()->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <th><i class="fa-solid fa-envelope"></i> Email</th>
                            <td>{{ Auth::user()->email }}</td>
                        </tr>
                        <tr>
                            <th><i class="fa-solid fa-shield-alt"></i> Level</th>
                            <td><span class="badge bg-primary">{{ strtoupper(Auth::user()->level) }}</span></td>
                        </tr>
                        <tr>
                            <th><i class="fa-solid fa-briefcase"></i> Spesialisasi</th>
                            <td>{{ Auth::user()->spesialisasi ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('bk/profile.js') }}" defer></script>
@endpush
