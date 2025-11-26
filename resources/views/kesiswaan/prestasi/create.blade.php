@extends('kesiswaan.layouts.app')
@section('title', 'Tambah Prestasi')

@push('styles')
    <link rel="stylesheet" href="{{ asset('kesiswaan/prestasi.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">🏆 Tambah Prestasi</h3>
        <a href="{{ route('kesiswaan.prestasi.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('kesiswaan.prestasi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Siswa <span class="text-danger">*</span></label>
                            <select name="siswa_id" class="form-select @error('siswa_id') is-invalid @enderror" required>
                                <option value="">Pilih Siswa</option>
                                @foreach($siswa as $s)
                                    <option value="{{ $s->id }}" {{ old('siswa_id') == $s->id ? 'selected' : '' }}>
                                        {{ $s->nama_siswa }} - {{ $s->kelas->nama_kelas ?? '-' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('siswa_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Jenis Prestasi <span class="text-danger">*</span></label>
                            <select name="jenis_prestasi_id" class="form-select @error('jenis_prestasi_id') is-invalid @enderror" required>
                                <option value="">Pilih Jenis Prestasi</option>
                                @foreach($jenisPrestasi as $jp)
                                    <option value="{{ $jp->id }}" {{ old('jenis_prestasi_id') == $jp->id ? 'selected' : '' }}>
                                        {{ $jp->nama_prestasi }} ({{ $jp->poin }} poin)
                                    </option>
                                @endforeach
                            </select>
                            @error('jenis_prestasi_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Tahun Ajaran <span class="text-danger">*</span></label>
                            <select name="tahun_ajaran_id" class="form-select @error('tahun_ajaran_id') is-invalid @enderror" required>
                                <option value="">Pilih Tahun Ajaran</option>
                                @foreach($tahunAjaran as $ta)
                                    <option value="{{ $ta->id }}" {{ old('tahun_ajaran_id') == $ta->id ? 'selected' : '' }}>
                                        {{ $ta->tahun_ajaran }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tahun_ajaran_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal') }}" required>
                            @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Tingkat <span class="text-danger">*</span></label>
                            <select name="tingkat" class="form-select @error('tingkat') is-invalid @enderror" required>
                                <option value="">Pilih Tingkat</option>
                                <option value="Sekolah" {{ old('tingkat') == 'Sekolah' ? 'selected' : '' }}>Sekolah</option>
                                <option value="Kecamatan" {{ old('tingkat') == 'Kecamatan' ? 'selected' : '' }}>Kecamatan</option>
                                <option value="Kabupaten/Kota" {{ old('tingkat') == 'Kabupaten/Kota' ? 'selected' : '' }}>Kabupaten/Kota</option>
                                <option value="Provinsi" {{ old('tingkat') == 'Provinsi' ? 'selected' : '' }}>Provinsi</option>
                                <option value="Nasional" {{ old('tingkat') == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                                <option value="Internasional" {{ old('tingkat') == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                            </select>
                            @error('tingkat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Penghargaan</label>
                            <input type="text" name="penghargaan" class="form-control @error('penghargaan') is-invalid @enderror" value="{{ old('penghargaan') }}">
                            @error('penghargaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Bukti Dokumen (PDF/JPG/PNG, Max 2MB)</label>
                            <input type="file" name="bukti_dokumen" class="form-control @error('bukti_dokumen') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
                            @error('bukti_dokumen') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="3">{{ old('keterangan') }}</textarea>
                    @error('keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('kesiswaan.prestasi.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
