@extends('wali_kelas.layouts.app')

@section('title', 'Edit Laporan')

@push('styles')
    <link rel="stylesheet" href="{{ asset('wali_kelas/laporan.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <h1 class="page-title">Edit Laporan Pelanggaran</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('wali_kelas.laporan.update', $laporan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label class="form-label">Siswa</label>
                    <select name="siswa_id" class="form-select @error('siswa_id') is-invalid @enderror" required>
                        <option value="">Pilih Siswa</option>
                        @foreach($siswa as $s)
                        <option value="{{ $s->id }}" {{ $laporan->siswa_id == $s->id ? 'selected' : '' }}>{{ $s->nama_siswa }} - {{ $s->nis }}</option>
                        @endforeach
                    </select>
                    @error('siswa_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Pelanggaran</label>
                    <select name="jenis_pelanggaran_id" class="form-select @error('jenis_pelanggaran_id') is-invalid @enderror" required>
                        <option value="">Pilih Pelanggaran</option>
                        @foreach($jenisPelanggaran as $jp)
                        <option value="{{ $jp->id }}" {{ $laporan->jenis_pelanggaran_id == $jp->id ? 'selected' : '' }}>{{ $jp->nama_pelanggaran }} ({{ $jp->poin }} poin)</option>
                        @endforeach
                    </select>
                    @error('jenis_pelanggaran_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', \Carbon\Carbon::parse($laporan->tanggal)->format('Y-m-d')) }}" required>
                    @error('tanggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="3">{{ old('keterangan', $laporan->keterangan) }}</textarea>
                    @error('keterangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Foto Bukti (Opsional)</label>
                    <input type="file" name="foto_bukti" class="form-control @error('foto_bukti') is-invalid @enderror" accept="image/*">
                    @error('foto_bukti')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('wali_kelas.laporan.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('wali_kelas/laporan.js') }}" defer></script>
@endpush
