@extends('admin.layouts.app')

@section('title', 'Edit Kelas')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/kelas.css') }}">
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Kelas</h1>
        <a href="{{ route('admin.kelas.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fa-solid fa-arrow-left me-2"></i>
            Kembali
        </a>
    </div>

    <div class="card kelas-form-card shadow-sm mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 fw-bold">Edit: {{ $kelas->nama_kelas }}</h6>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.kelas.update', $kelas) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama_kelas" class="form-label">Nama Kelas <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_kelas') is-invalid @enderror" 
                                   id="nama_kelas" name="nama_kelas" value="{{ old('nama_kelas', $kelas->nama_kelas) }}" required>
                            @error('nama_kelas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="jurusan_id" class="form-label">Jurusan</label>
                            <select class="form-select @error('jurusan_id') is-invalid @enderror" id="jurusan_id" name="jurusan_id">
                                <option value="">-- Pilih Jurusan --</option>
                                @foreach($jurusan as $j)
                                    <option value="{{ $j->id }}" {{ old('jurusan_id', $kelas->jurusan_id) == $j->id ? 'selected' : '' }}>{{ $j->nama_jurusan }}</option>
                                @endforeach
                            </select>
                            @error('jurusan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="kapasitas" class="form-label">Kapasitas (Opsional)</label>
                            <input type="number" class="form-control @error('kapasitas') is-invalid @enderror" 
                                   id="kapasitas" name="kapasitas" value="{{ old('kapasitas', $kelas->kapasitas) }}" min="0">
                            @error('kapasitas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>
                
                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('admin.kelas.index') }}" class="btn btn-secondary">
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

@push('scripts')
    <script src="{{ asset('admin/kelas.js') }}" defer></script>
@endpush
