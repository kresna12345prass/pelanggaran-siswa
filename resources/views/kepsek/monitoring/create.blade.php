@extends('kepsek.layouts.app')

@section('title', 'Tambah Monitoring')

@push('styles')
    <link rel="stylesheet" href="{{ asset('kepsek/monitoring.css') }}">
@endpush

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Tambah Monitoring Kasus Berat</h1>
        <a href="{{ route('kepsek.monitoring.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('kepsek.monitoring.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label">Pilih Pelanggaran Berat</label>
                    <select name="pelanggaran_id" class="form-select @error('pelanggaran_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Pelanggaran --</option>
                        @foreach($pelanggaranBerat as $p)
                            <option value="{{ $p->id }}">
                                {{ $p->siswa->nama_siswa }} - {{ $p->jenisPelanggaran->nama_pelanggaran }} ({{ $p->poin }} poin)
                            </option>
                        @endforeach
                    </select>
                    @error('pelanggaran_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Status Monitoring</label>
                    <input type="text" name="status_monitoring" class="form-control @error('status_monitoring') is-invalid @enderror" value="{{ old('status_monitoring') }}" required>
                    @error('status_monitoring')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Catatan Monitoring</label>
                    <textarea name="catatan_monitoring" class="form-control @error('catatan_monitoring') is-invalid @enderror" rows="4" required>{{ old('catatan_monitoring') }}</textarea>
                    @error('catatan_monitoring')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Monitoring</label>
                    <input type="date" name="tanggal_monitoring" class="form-control @error('tanggal_monitoring') is-invalid @enderror" value="{{ old('tanggal_monitoring', date('Y-m-d')) }}" required>
                    @error('tanggal_monitoring')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Tindak Lanjut</label>
                    <textarea name="tindak_lanjut" class="form-control @error('tindak_lanjut') is-invalid @enderror" rows="3">{{ old('tindak_lanjut') }}</textarea>
                    @error('tindak_lanjut')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-save me-2"></i>Simpan
                </button>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('kepsek/monitoring.js') }}" defer></script>
@endpush
