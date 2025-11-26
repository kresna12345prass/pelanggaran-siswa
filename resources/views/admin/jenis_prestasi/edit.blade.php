@extends('admin.layouts.app')

@section('title', 'Edit Jenis Prestasi')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/jenis_prestasi.css') }}">
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Jenis Prestasi</h1>
        <a href="{{ route('admin.jenis_prestasi.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fa-solid fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 fw-bold">Edit: {{ $jenisPrestasi->nama_prestasi }}</h6>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.jenis_prestasi.update', $jenisPrestasi) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama_prestasi" class="form-label">Nama Prestasi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_prestasi') is-invalid @enderror" id="nama_prestasi" name="nama_prestasi" value="{{ old('nama_prestasi', $jenisPrestasi->nama_prestasi) }}" required>
                            @error('nama_prestasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('kategori') is-invalid @enderror" id="kategori" name="kategori" value="{{ old('kategori', $jenisPrestasi->kategori) }}" required>
                            @error('kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="poin" class="form-label">Poin <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('poin') is-invalid @enderror" id="poin" name="poin" value="{{ old('poin', $jenisPrestasi->poin) }}" min="0" required>
                            @error('poin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="penghargaan" class="form-label">Penghargaan</label>
                            <input type="text" class="form-control @error('penghargaan') is-invalid @enderror" id="penghargaan" name="penghargaan" value="{{ old('penghargaan', $jenisPrestasi->penghargaan) }}">
                            @error('penghargaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $jenisPrestasi->keterangan) }}</textarea>
                    @error('keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('admin.jenis_prestasi.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-warning">
                        <i class="fa-solid fa-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
