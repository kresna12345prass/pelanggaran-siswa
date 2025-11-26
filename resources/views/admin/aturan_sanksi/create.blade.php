@extends('admin.layouts.app')

@section('title', 'Tambah Aturan Sanksi')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/aturan_sanksi.css') }}">
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Aturan Sanksi</h1>
        <a href="{{ route('admin.aturan_sanksi.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fa-solid fa-arrow-left me-2"></i>
            Kembali
        </a>
    </div>

    <div class="card aturan-form-card shadow-sm mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 fw-bold"><i class="fa-solid fa-plus me-2"></i>Formulir Sanksi Baru</h6>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.aturan_sanksi.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                    <select class="form-select @error('kategori') is-invalid @enderror" id="kategori" name="kategori" required>
                        <option value="">Pilih Kategori</option>
                        <option value="Ringan" {{ old('kategori') == 'Ringan' ? 'selected' : '' }}>Ringan</option>
                        <option value="Sedang" {{ old('kategori') == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                        <option value="Berat" {{ old('kategori') == 'Berat' ? 'selected' : '' }}>Berat</option>
                    </select>
                    @error('kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="nama_sanksi" class="form-label">Nama Sanksi <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama_sanksi') is-invalid @enderror" id="nama_sanksi" name="nama_sanksi" value="{{ old('nama_sanksi') }}" required>
                    @error('nama_sanksi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="poin_minimal" class="form-label">Poin Minimal <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('poin_minimal') is-invalid @enderror" id="poin_minimal" name="poin_minimal" value="{{ old('poin_minimal') }}" required>
                            @error('poin_minimal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="poin_maksimal" class="form-label">Poin Maksimal <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('poin_maksimal') is-invalid @enderror" id="poin_maksimal" name="poin_maksimal" value="{{ old('poin_maksimal') }}" required>
                            @error('poin_maksimal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="deskripsi_tindakan" class="form-label">Deskripsi Tindakan (Opsional)</label>
                    <textarea class="form-control @error('deskripsi_tindakan') is-invalid @enderror" id="deskripsi_tindakan" name="deskripsi_tindakan" rows="3">{{ old('deskripsi_tindakan') }}</textarea>
                    @error('deskripsi_tindakan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('admin.aturan_sanksi.index') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-times me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-danger">
                        <i class="fa-solid fa-save me-2"></i>Simpan Sanksi
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
