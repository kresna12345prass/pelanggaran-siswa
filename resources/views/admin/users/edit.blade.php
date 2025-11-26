@extends('admin.layouts.app')

@section('title', 'Edit Pengguna')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/users.css') }}">
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Pengguna</h1>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fa-solid fa-arrow-left me-2"></i>
            Kembali
        </a>
    </div>

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card user-form-card shadow-sm mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-primary">Edit: {{ $user->nama_lengkap }}</h6>
            <span class="badge bg-info">{{ ucfirst($user->level) }}</span>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT') <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required>
                            @error('nama_lengkap')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username', $user->username) }}" required>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="level" class="form-label">Level (Peran) <span class="text-danger">*</span></label>
                            <select class="form-select @error('level') is-invalid @enderror" id="level" name="level" required>
                                <option value="admin" {{ old('level', $user->level) == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="kepsek" {{ old('level', $user->level) == 'kepsek' ? 'selected' : '' }}>Kepala Sekolah</option>
                                <option value="bk" {{ old('level', $user->level) == 'bk' ? 'selected' : '' }}>BK</option>
                                <option value="kesiswaan" {{ old('level', $user->level) == 'kesiswaan' ? 'selected' : '' }}>Kesiswaan</option>
                                <option value="wali_kelas" {{ old('level', $user->level) == 'wali_kelas' ? 'selected' : '' }}>Wali Kelas</option>
                                <option value="guru" {{ old('level', $user->level) == 'guru' ? 'selected' : '' }}>Guru</option>
                                <option value="siswa" {{ old('level', $user->level) == 'siswa' ? 'selected' : '' }}>Siswa</option>
                                <option value="ortu" {{ old('level', $user->level) == 'ortu' ? 'selected' : '' }}>Orang Tua</option>
                            </select>
                            @error('level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                         <div class="mb-3">
                            <label for="spesialisasi" class="form-label">Spesialisasi (Opsional)</label>
                            <input type="text" class="form-control @error('spesialisasi') is-invalid @enderror" id="spesialisasi" name="spesialisasi" value="{{ old('spesialisasi', $user->spesialisasi) }}" placeholder="Contoh: BK, Kesiswaan">
                            @error('spesialisasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password Baru (Opsional)</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Kosongkan jika tidak ingin diubah">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                         <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" value="1" id="can_verify" name="can_verify" {{ old('can_verify', $user->can_verify) ? 'checked' : '' }}>
                            <label class="form-check-label" for="can_verify">
                                Izinkan pengguna ini melakukan verifikasi data?
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-times me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-warning">
                        <i class="fa-solid fa-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection