@extends('admin.layouts.app')

@section('title', 'Tambah Wali Kelas')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/wali_kelas.css') }}">
@endpush

@section('content')
    
    <div class="mb-4">
        <h1 class="h3 mb-1 text-gray-800">Tambah Wali Kelas</h1>
        <p class="text-muted mb-0 small">Tambah penugasan wali kelas baru</p>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card wali-kelas-form-card shadow-sm border-0">
        <div class="card-header py-3">
            <h6 class="m-0 fw-bold"><i class="fa-solid fa-plus me-2"></i>Form Tambah Wali Kelas</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.wali_kelas.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tahun_ajaran_id" class="form-label">Tahun Ajaran <span class="text-danger">*</span></label>
                            <select class="form-select @error('tahun_ajaran_id') is-invalid @enderror" 
                                    id="tahun_ajaran_id" 
                                    name="tahun_ajaran_id" 
                                    required>
                                <option value="">Pilih Tahun Ajaran</option>
                                @foreach($tahunAjaran as $ta)
                                    <option value="{{ $ta->id }}" {{ old('tahun_ajaran_id') == $ta->id ? 'selected' : '' }}>
                                        {{ $ta->tahun_ajaran }} - {{ $ta->semester }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tahun_ajaran_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="guru_id" class="form-label">Guru <span class="text-danger">*</span></label>
                            <select class="form-select @error('guru_id') is-invalid @enderror" 
                                    id="guru_id" 
                                    name="guru_id" 
                                    required>
                                <option value="">Pilih Guru</option>
                                @foreach($guru as $g)
                                    <option value="{{ $g->id }}" {{ old('guru_id') == $g->id ? 'selected' : '' }}>
                                        {{ $g->nama_guru }} ({{ $g->nip }})
                                    </option>
                                @endforeach
                            </select>
                            @error('guru_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="kelas_id" class="form-label">Kelas <span class="text-danger">*</span></label>
                            <select class="form-select @error('kelas_id') is-invalid @enderror" 
                                    id="kelas_id" 
                                    name="kelas_id" 
                                    required>
                                <option value="">Pilih Kelas</option>
                                @foreach($kelas as $k)
                                    <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama_kelas }} - {{ $k->jurusan?->nama_jurusan ?? 'Tanpa Jurusan' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kelas_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.wali_kelas.index') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-arrow-left me-2"></i>Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-save me-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection