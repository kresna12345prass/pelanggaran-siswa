@extends('bk.layouts.app')

@section('title', 'Update Tindak Lanjut')

@push('styles')
    <link rel="stylesheet" href="{{ asset('bk/tindak_lanjut.css') }}">
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Update Tindak Lanjut</h1>
        <a href="{{ route('bk.tindak_lanjut.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('bk.tindak_lanjut.update', $konseling->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label class="form-label">Siswa</label>
                    <input type="text" class="form-control" value="{{ $konseling->siswa->nama_siswa }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Topik</label>
                    <input type="text" class="form-control" value="{{ $konseling->topik }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Tindak Lanjut <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_tindak_lanjut" class="form-control @error('tanggal_tindak_lanjut') is-invalid @enderror" value="{{ old('tanggal_tindak_lanjut', $konseling->tanggal_tindak_lanjut) }}" required>
                    @error('tanggal_tindak_lanjut')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Hasil Evaluasi <span class="text-danger">*</span></label>
                    <textarea name="hasil_evaluasi" class="form-control @error('hasil_evaluasi') is-invalid @enderror" rows="5" required>{{ old('hasil_evaluasi', $konseling->hasil_evaluasi) }}</textarea>
                    @error('hasil_evaluasi')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

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

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('bk.tindak_lanjut.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('bk/tindak_lanjut.js') }}" defer></script>
@endpush
