@extends('admin.layouts.app')

@section('title', 'Tambah Tahun Ajaran')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/tahun_ajaran.css') }}">
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Tahun Ajaran</h1>
        <a href="{{ route('admin.tahun_ajaran.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fa-solid fa-arrow-left me-2"></i>
            Kembali
        </a>
    </div>

    <div class="card ta-form-card shadow-sm mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 fw-bold"><i class="fa-solid fa-plus me-2"></i>Formulir Tahun Ajaran Baru</h6>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.tahun_ajaran.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tahun_ajaran" class="form-label">Tahun Ajaran <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('tahun_ajaran') is-invalid @enderror" 
                                   id="tahun_ajaran" name="tahun_ajaran" value="{{ old('tahun_ajaran') }}" 
                                   placeholder="Contoh: 2024/2025" required>
                            @error('tahun_ajaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="semester" class="form-label">Semester <span class="text-danger">*</span></label>
                            <select class="form-select @error('semester') is-invalid @enderror" id="semester" name="semester" required>
                                <option value="" disabled selected>-- Pilih Semester --</option>
                                <option value="Ganjil" {{ old('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                <option value="Genap" {{ old('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
                            </select>
                            @error('semester')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="kode_ajaran" class="form-label">Kode Ajaran <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('kode_ajaran') is-invalid @enderror" 
                                   id="kode_ajaran" name="kode_ajaran" value="{{ old('kode_ajaran') }}" 
                                   placeholder="Contoh: 20241 (2024 Ganjil)" required>
                            @error('kode_ajaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai (Opsional)</label>
                            <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror" 
                                   id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}">
                            @error('tanggal_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tanggal_selesai" class="form-label">Tanggal Selesai (Opsional)</label>
                            <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror" 
                                   id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}">
                            @error('tanggal_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-12">
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" role="switch" value="1" id="status_aktif" name="status_aktif" {{ old('status_aktif') ? 'checked' : '' }}>
                            <label class="form-check-label" for="status_aktif">
                                Jadikan Tahun Ajaran Aktif?
                                <small class="d-block text-muted">Jika dicentang, tahun ajaran lain yang aktif akan otomatis non-aktif.</small>
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('admin.tahun_ajaran.index') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-times me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-primary" style="background-color: #6c757d; border-color: #6c757d;">
                        <i class="fa-solid fa-save me-2"></i>Simpan Tahun Ajaran
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
