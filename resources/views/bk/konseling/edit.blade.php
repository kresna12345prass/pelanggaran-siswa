@extends('bk.layouts.app')

@section('title', 'Edit Konseling')

@push('styles')
    @vite('resources/css/bk/konseling.css')
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Data Konseling</h1>
        <a href="{{ route('bk.konseling.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('bk.konseling.update', $konseling->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Siswa <span class="text-danger">*</span></label>
                            <select name="siswa_id" class="form-select @error('siswa_id') is-invalid @enderror" required>
                                <option value="">Pilih Siswa</option>
                                @foreach($siswa as $s)
                                <option value="{{ $s->id }}" {{ old('siswa_id', $konseling->siswa_id) == $s->id ? 'selected' : '' }}>
                                    {{ $s->nis }} - {{ $s->nama_siswa }} ({{ $s->kelas->nama_kelas ?? '-' }})
                                </option>
                                @endforeach
                            </select>
                            @error('siswa_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Tanggal Konseling <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_konseling" class="form-control @error('tanggal_konseling') is-invalid @enderror" value="{{ old('tanggal_konseling', $konseling->tanggal_konseling) }}" required>
                            @error('tanggal_konseling')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Tahun Ajaran <span class="text-danger">*</span></label>
                            <select name="tahun_ajaran_id" class="form-select @error('tahun_ajaran_id') is-invalid @enderror" required>
                                @foreach($tahunAjaran as $ta)
                                <option value="{{ $ta->id }}" {{ old('tahun_ajaran_id', $konseling->tahun_ajaran_id) == $ta->id ? 'selected' : '' }}>
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
                            <label class="form-label">Jenis Layanan</label>
                            <input type="text" name="jenis_layanan" class="form-control @error('jenis_layanan') is-invalid @enderror" value="{{ old('jenis_layanan', $konseling->jenis_layanan) }}">
                            @error('jenis_layanan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Topik <span class="text-danger">*</span></label>
                    <input type="text" name="topik" class="form-control @error('topik') is-invalid @enderror" value="{{ old('topik', $konseling->topik) }}" required>
                    @error('topik')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Keluhan/Masalah <span class="text-danger">*</span></label>
                    <textarea name="keluhan_masalah" class="form-control @error('keluhan_masalah') is-invalid @enderror" rows="4" required>{{ old('keluhan_masalah', $konseling->keluhan_masalah) }}</textarea>
                    @error('keluhan_masalah')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Tindakan/Solusi <span class="text-danger">*</span></label>
                    <textarea name="tindakan_solusi" class="form-control @error('tindakan_solusi') is-invalid @enderror" rows="4" required>{{ old('tindakan_solusi', $konseling->tindakan_solusi) }}</textarea>
                    @error('tindakan_solusi')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="aktif" {{ old('status', $konseling->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="tindak_lanjut" {{ old('status', $konseling->status) == 'tindak_lanjut' ? 'selected' : '' }}>Tindak Lanjut</option>
                                <option value="selesai" {{ old('status', $konseling->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Hasil Evaluasi</label>
                    <textarea name="hasil_evaluasi" class="form-control @error('hasil_evaluasi') is-invalid @enderror" rows="3">{{ old('hasil_evaluasi', $konseling->hasil_evaluasi) }}</textarea>
                    @error('hasil_evaluasi')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('bk.konseling.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/bk/konseling.js')
@endpush
