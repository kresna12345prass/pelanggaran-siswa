@extends('admin.layouts.app')

@section('title', 'Edit Aturan Pelanggaran')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/aturan_pelanggaran.css') }}">
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Aturan</h1>
        <a href="{{ route('admin.aturan_pelanggaran.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fa-solid fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <div class="card aturan-form-card shadow-sm mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 fw-bold">Edit: {{ $aturan->nama_pelanggaran }}</h6>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.aturan_pelanggaran.update', $aturan) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="nama_pelanggaran" class="form-label">Nama Pelanggaran <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama_pelanggaran') is-invalid @enderror" id="nama_pelanggaran" name="nama_pelanggaran" value="{{ old('nama_pelanggaran', $aturan->nama_pelanggaran) }}" required>
                    @error('nama_pelanggaran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="poin" class="form-label">Poin <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('poin') is-invalid @enderror" id="poin" name="poin" value="{{ old('poin', $aturan->poin) }}" required>
                    @error('poin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="kategori_pelanggaran_id" class="form-label">Kategori</label>
                    <select class="form-select @error('kategori_pelanggaran_id') is-invalid @enderror" id="kategori_pelanggaran_id" name="kategori_pelanggaran_id">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategori as $k)
                            <option value="{{ $k->id }}" {{ old('kategori_pelanggaran_id', $aturan->kategori_pelanggaran_id) == $k->id ? 'selected' : '' }}>{{ $k->kategori_induk }} - {{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                    @error('kategori_pelanggaran_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="sanksi" class="form-label">Sanksi Rekomendasi</label>
                    <select class="form-select @error('sanksi') is-invalid @enderror" id="sanksi" name="sanksi">
                        <option value="">-- Pilih Sanksi --</option>
                        @foreach($sanksi as $s)
                            <option value="{{ $s->nama_sanksi }}" {{ old('sanksi', $aturan->sanksi) == $s->nama_sanksi ? 'selected' : '' }}>
                                {{ $s->nama_sanksi }} ({{ $s->poin_minimal }}-{{ $s->poin_maksimal }} poin)
                            </option>
                        @endforeach
                    </select>
                    @error('sanksi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $aturan->keterangan) }}</textarea>
                    @error('keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('admin.aturan_pelanggaran.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-warning">
                        <i class="fa-solid fa-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection