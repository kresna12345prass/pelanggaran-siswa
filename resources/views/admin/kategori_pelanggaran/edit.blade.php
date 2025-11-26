@extends('admin.layouts.app')

@section('title', 'Edit Kategori Pelanggaran')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/kategori_pelanggaran.css') }}">
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Kategori Pelanggaran</h1>
        <a href="{{ route('admin.kategori_pelanggaran.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fa-solid fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 fw-bold">Edit: {{ $kategori->nama_kategori }}</h6>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.kategori_pelanggaran.update', $kategori) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="nama_kategori" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror" id="nama_kategori" name="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required>
                    @error('nama_kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="kategori_induk" class="form-label">Kategori Induk</label>
                    <select class="form-select @error('kategori_induk') is-invalid @enderror" id="kategori_induk" name="kategori_induk">
                        <option value="">-- Pilih Kategori Induk --</option>
                        @foreach($kategoriInduk as $induk)
                            <option value="{{ $induk }}" {{ old('kategori_induk', $kategori->kategori_induk) == $induk ? 'selected' : '' }}>{{ $induk }}</option>
                        @endforeach
                    </select>
                    <small class="text-muted">Atau ketik baru: <input type="text" class="form-control form-control-sm mt-1" id="kategori_induk_baru" placeholder="Kategori induk baru"></small>
                    @error('kategori_induk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('admin.kategori_pelanggaran.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-warning">
                        <i class="fa-solid fa-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('admin/kategori_pelanggaran.js') }}" defer></script>
@endpush
