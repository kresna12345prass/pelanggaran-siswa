@extends('admin.layouts.app')

@section('title', 'Tambah Siswa Baru')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/siswa.css') }}">
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Siswa Baru</h1>
        <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fa-solid fa-arrow-left me-2"></i>
            Kembali
        </a>
    </div>

    <div class="card siswa-form-card shadow-sm mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 fw-bold"><i class="fa-solid fa-user-plus me-2"></i>Formulir Siswa Baru</h6>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.siswa.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama_siswa" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_siswa') is-invalid @enderror" id="nama_siswa" name="nama_siswa" value="{{ old('nama_siswa') }}" required>
                            @error('nama_siswa') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username') }}" required>
                            @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="nis" class="form-label">NIS <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nis') is-invalid @enderror" id="nis" name="nis" value="{{ old('nis') }}" required>
                            @error('nis') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="nisn" class="form-label">NISN <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nisn') is-invalid @enderror" id="nisn" name="nisn" value="{{ old('nisn') }}" required>
                            @error('nisn') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="kelas_id" class="form-label">Kelas <span class="text-danger">*</span></label>
                            <select class="form-select @error('kelas_id') is-invalid @enderror" id="kelas_id" name="kelas_id" required>
                                <option value="" disabled selected>-- Pilih Kelas --</option>
                                @foreach($kelas as $k)
                                    <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                            @error('kelas_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="no_telepon" class="form-label">No. Telepon (Opsional)</label>
                            <input type="text" class="form-control @error('no_telepon') is-invalid @enderror" id="no_telepon" name="no_telepon" value="{{ old('no_telepon') }}">
                            @error('no_telepon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tempat_lahir" class="form-label">Tempat Lahir (Opsional)</label>
                            <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}">
                            @error('tempat_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir (Opsional)</label>
                            <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                            @error('tanggal_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin (Opsional)</label>
                            <select class="form-select @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin">
                                <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="agama" class="form-label">Agama (Opsional)</label>
                            <input type="text" class="form-control @error('agama') is-invalid @enderror" id="agama" name="agama" value="{{ old('agama') }}">
                            @error('agama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="foto" class="form-label">Upload Foto (Opsional)</label>
                            <input class="form-control @error('foto') is-invalid @enderror" type="file" id="foto" name="foto">
                            @error('foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat (Opsional)</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3">{{ old('alamat') }}</textarea>
                            @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-times me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fa-solid fa-save me-2"></i>Simpan Siswa
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
