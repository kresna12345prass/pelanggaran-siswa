@extends('kesiswaan.layouts.app')
@section('title', 'Edit Sanksi')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">✏️ Edit Sanksi</h3>
        <a href="{{ route('kesiswaan.sanksi.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('kesiswaan.sanksi.update', $sanksi->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label class="form-label">Siswa</label>
                    <input type="text" class="form-control" value="{{ $sanksi->pelanggaran->siswa->nama_siswa }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Sanksi <span class="text-danger">*</span></label>
                    <input type="text" name="jenis_sanksi" class="form-control @error('jenis_sanksi') is-invalid @enderror" value="{{ old('jenis_sanksi', $sanksi->jenis_sanksi) }}" required>
                    @error('jenis_sanksi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi Hukuman <span class="text-danger">*</span></label>
                    <textarea name="deskripsi_hukuman" class="form-control @error('deskripsi_hukuman') is-invalid @enderror" rows="4" required>{{ old('deskripsi_hukuman', $sanksi->deskripsi_hukuman) }}</textarea>
                    @error('deskripsi_hukuman')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror" value="{{ old('tanggal_mulai', $sanksi->tanggal_mulai) }}" required>
                            @error('tanggal_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" class="form-control @error('tanggal_selesai') is-invalid @enderror" value="{{ old('tanggal_selesai', $sanksi->tanggal_selesai) }}">
                            @error('tanggal_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status Sanksi <span class="text-danger">*</span></label>
                    <select name="status_sanksi" class="form-select @error('status_sanksi') is-invalid @enderror" required>
                        <option value="pending" {{ $sanksi->status_sanksi == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="berjalan" {{ $sanksi->status_sanksi == 'berjalan' ? 'selected' : '' }}>Berjalan</option>
                        <option value="selesai" {{ $sanksi->status_sanksi == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="terlambat" {{ $sanksi->status_sanksi == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                    </select>
                    @error('status_sanksi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-save"></i> Update
                    </button>
                    <a href="{{ route('kesiswaan.sanksi.index') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
