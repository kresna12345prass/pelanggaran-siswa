@extends('admin.layouts.app')

@section('title', 'Tambah Aturan Pelanggaran')

@push('styles')
    @vite('resources/css/admin/aturan_pelanggaran.css')
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Aturan Pelanggaran</h1>
        <a href="{{ route('admin.aturan_pelanggaran.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fa-solid fa-arrow-left me-2"></i>
            Kembali
        </a>
    </div>

    <div class="card aturan-form-card shadow-sm mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 fw-bold"><i class="fa-solid fa-plus me-2"></i>Formulir Aturan Baru</h6>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.aturan_pelanggaran.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nama_pelanggaran" class="form-label">Nama Pelanggaran <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama_pelanggaran') is-invalid @enderror" id="nama_pelanggaran" name="nama_pelanggaran" value="{{ old('nama_pelanggaran') }}" required>
                    @error('nama_pelanggaran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="poin" class="form-label">Poin <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('poin') is-invalid @enderror" id="poin" name="poin" value="{{ old('poin') }}" required>
                    @error('poin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="kategori_induk" class="form-label">Kategori Induk</label>
                            <select class="form-select @error('kategori_induk') is-invalid @enderror" id="kategori_induk" name="kategori_induk">
                                <option value="">-- Pilih Kategori Induk --</option>
                                @foreach($kategoriInduk as $induk)
                                    <option value="{{ $induk }}" {{ old('kategori_induk') == $induk ? 'selected' : '' }}>{{ $induk }}</option>
                                @endforeach
                            </select>
                            @error('kategori_induk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="kategori_pelanggaran_id" class="form-label">Kategori</label>
                            <select class="form-select @error('kategori_pelanggaran_id') is-invalid @enderror" id="kategori_pelanggaran_id" name="kategori_pelanggaran_id">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategori as $k)
                                    <option value="{{ $k->id }}" data-induk="{{ $k->kategori_induk }}" {{ old('kategori_pelanggaran_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                                @endforeach
                            </select>
                            @error('kategori_pelanggaran_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="sanksi" class="form-label">Sanksi Rekomendasi</label>
                    <input type="text" class="form-control @error('sanksi') is-invalid @enderror" id="sanksi" name="sanksi" value="{{ old('sanksi') }}" placeholder="Contoh: Peringatan Lisan">
                    @error('sanksi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="3">{{ old('keterangan') }}</textarea>
                    @error('keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('admin.aturan_pelanggaran.index') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-times me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-danger">
                        <i class="fa-solid fa-save me-2"></i>Simpan Aturan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection