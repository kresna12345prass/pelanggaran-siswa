@extends('bk.layouts.app')

@section('title', 'Tambah Konseling')

@push('styles')
    <link rel="stylesheet" href="{{ asset('bk/konseling.css') }}">
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Data Konseling</h1>
        <a href="{{ route('bk.konseling.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    @if($sanksi)
    <div class="alert alert-info mb-4">
        <i class="fa-solid fa-info-circle me-2"></i>
        <strong>Konseling dari Rekomendasi Sanksi:</strong> {{ $sanksi->jenis_sanksi }} - {{ $sanksi->pelanggaran->siswa->nama_siswa }}
    </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('bk.konseling.store') }}" method="POST">
                @csrf
                <input type="hidden" name="data_sanksi_id" value="{{ $sanksi->id ?? '' }}">
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Siswa <span class="text-danger">*</span></label>
                            <select name="siswa_id" class="form-select @error('siswa_id') is-invalid @enderror" required {{ $sanksi ? 'readonly' : '' }}>
                                <option value="">Pilih Siswa</option>
                                @foreach($siswa as $s)
                                <option value="{{ $s->id }}" {{ (old('siswa_id', $sanksi->pelanggaran->siswa_id ?? '') == $s->id) ? 'selected' : '' }}>
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
                            <input type="date" name="tanggal_konseling" class="form-control @error('tanggal_konseling') is-invalid @enderror" value="{{ old('tanggal_konseling', date('Y-m-d')) }}" required>
                            @error('tanggal_konseling')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <input type="hidden" name="tahun_ajaran_id" value="{{ $tahunAjaran->id ?? '' }}">

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Sumber Rujukan <span class="text-danger">*</span></label>
                            <select name="sumber_rujukan" class="form-select @error('sumber_rujukan') is-invalid @enderror" required>
                                <option value="mandiri" {{ old('sumber_rujukan', $sanksi ? 'sanksi' : 'mandiri') == 'mandiri' ? 'selected' : '' }}>Mandiri</option>
                                <option value="sanksi" {{ old('sumber_rujukan', $sanksi ? 'sanksi' : '') == 'sanksi' ? 'selected' : '' }}>Sanksi</option>
                                <option value="guru" {{ old('sumber_rujukan') == 'guru' ? 'selected' : '' }}>Guru</option>
                                <option value="wali_kelas" {{ old('sumber_rujukan') == 'wali_kelas' ? 'selected' : '' }}>Wali Kelas</option>
                                <option value="ortu" {{ old('sumber_rujukan') == 'ortu' ? 'selected' : '' }}>Orang Tua</option>
                            </select>
                            @error('sumber_rujukan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Jenis Layanan</label>
                            <input type="text" name="jenis_layanan" class="form-control @error('jenis_layanan') is-invalid @enderror" value="{{ old('jenis_layanan', 'Konseling Individual') }}" placeholder="Konseling Individual/Kelompok">
                            @error('jenis_layanan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Topik <span class="text-danger">*</span></label>
                    <input type="text" name="topik" class="form-control @error('topik') is-invalid @enderror" value="{{ old('topik', $sanksi ? 'Konseling Terkait Sanksi: ' . $sanksi->jenis_sanksi : '') }}" required>
                    @error('topik')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Keluhan/Masalah <span class="text-danger">*</span></label>
                    <textarea name="keluhan_masalah" class="form-control @error('keluhan_masalah') is-invalid @enderror" rows="4" required>{{ old('keluhan_masalah', $sanksi ? 'Siswa mendapat sanksi: ' . $sanksi->jenis_sanksi . ' dengan deskripsi: ' . $sanksi->deskripsi_hukuman : '') }}</textarea>
                    @error('keluhan_masalah')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Tindakan/Solusi <span class="text-danger">*</span></label>
                    <textarea name="tindakan_solusi" class="form-control @error('tindakan_solusi') is-invalid @enderror" rows="4" required>{{ old('tindakan_solusi') }}</textarea>
                    @error('tindakan_solusi')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="tindak_lanjut" {{ old('status') == 'tindak_lanjut' ? 'selected' : '' }}>Tindak Lanjut</option>
                                <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Hasil Evaluasi</label>
                    <textarea name="hasil_evaluasi" class="form-control @error('hasil_evaluasi') is-invalid @enderror" rows="3">{{ old('hasil_evaluasi') }}</textarea>
                    @error('hasil_evaluasi')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('bk.konseling.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('bk/konseling.js') }}" defer></script>
@endpush
