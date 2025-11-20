@extends('admin.layouts.app')

@section('title', 'Tambah Tata Tertib')

@push('styles')
    @vite('resources/css/admin/tata_tertib.css')
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Tata Tertib</h1>
        <a href="{{ route('admin.tata_tertib.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fa-solid fa-arrow-left me-2"></i>
            Kembali
        </a>
    </div>

    <div class="card aturan-form-card shadow-sm mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 fw-bold"><i class="fa-solid fa-plus me-2"></i>Formulir Tata Tertib Baru</h6>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.tata_tertib.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="pasal" class="form-label">Pasal <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('pasal') is-invalid @enderror" id="pasal" name="pasal" value="{{ old('pasal') }}" placeholder="Contoh: Pasal 1" required>
                            @error('pasal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tipe" class="form-label">Tipe <span class="text-danger">*</span></label>
                            <select class="form-select @error('tipe') is-invalid @enderror" id="tipe" name="tipe" required>
                                <option value="">Pilih Tipe</option>
                                <option value="pasal" {{ old('tipe') == 'pasal' ? 'selected' : '' }}>Pasal</option>
                                <option value="ayat" {{ old('tipe') == 'ayat' ? 'selected' : '' }}>Ayat</option>
                                <option value="poin" {{ old('tipe') == 'poin' ? 'selected' : '' }}>Poin</option>
                            </select>
                            @error('tipe') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul') }}" required>
                    @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="urutan" class="form-label">Urutan <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('urutan') is-invalid @enderror" id="urutan" name="urutan" value="{{ old('urutan', 0) }}" required>
                    @error('urutan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="konten_teks" class="form-label">Konten Teks (Opsional)</label>
                    <textarea class="form-control @error('konten_teks') is-invalid @enderror" id="konten_teks" name="konten_teks" rows="5">{{ old('konten_teks') }}</textarea>
                    @error('konten_teks') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('admin.tata_tertib.index') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-times me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-danger">
                        <i class="fa-solid fa-save me-2"></i>Simpan Tata Tertib
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
