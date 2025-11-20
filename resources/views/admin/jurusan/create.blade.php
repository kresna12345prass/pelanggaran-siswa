@extends('admin.layouts.app')

@section('title', 'Tambah Jurusan')

@push('styles')
    @vite('resources/css/admin/jurusan.css')
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Jurusan</h1>
        <a href="{{ route('admin.jurusan.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fa-solid fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 fw-bold"><i class="fa-solid fa-plus me-2"></i>Formulir Jurusan Baru</h6>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.jurusan.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="kode_jurusan" class="form-label">Kode Jurusan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('kode_jurusan') is-invalid @enderror" id="kode_jurusan" name="kode_jurusan" value="{{ old('kode_jurusan') }}" required>
                            @error('kode_jurusan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama_jurusan" class="form-label">Nama Jurusan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_jurusan') is-invalid @enderror" id="nama_jurusan" name="nama_jurusan" value="{{ old('nama_jurusan') }}" required>
                            @error('nama_jurusan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('admin.jurusan.index') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-times me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-save me-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
