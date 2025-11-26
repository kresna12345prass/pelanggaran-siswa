@extends('wali_kelas.layouts.app')

@section('title', 'Tambah Laporan Pelanggaran')

@push('styles')
    <link rel="stylesheet" href="{{ asset('wali_kelas/laporan.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    
    <div class="page-header">
        <h1 class="page-title">Tambah Laporan Pelanggaran</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('wali_kelas.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('wali_kelas.laporan.index') }}">Lapor Pelanggaran</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fa-solid fa-file-circle-plus me-2"></i>
                Form Laporan Pelanggaran
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('wali_kelas.laporan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="siswa_id" class="form-label">Pilih Siswa <span class="text-danger">*</span></label>
                        <select name="siswa_id" id="siswa_id" class="form-select @error('siswa_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Siswa --</option>
                            @foreach($siswa as $s)
                            <option value="{{ $s->id }}" {{ old('siswa_id') == $s->id ? 'selected' : '' }}>
                                {{ $s->nama_siswa }} - {{ $s->nis }}
                            </option>
                            @endforeach
                        </select>
                        @error('siswa_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="tanggal" class="form-label">Tanggal Kejadian <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', date('Y-m-d\TH:i')) }}" required>
                        @error('tanggal')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Pelanggaran <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="jenis_pelanggaran_nama" readonly placeholder="-- Pilih Jenis Pelanggaran --">
                        <input type="hidden" name="jenis_pelanggaran_id" id="jenis_pelanggaran_id" value="{{ old('jenis_pelanggaran_id') }}">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalJenisPelanggaran">
                            <i class="fa-solid fa-search"></i>
                        </button>
                    </div>
                    <small class="text-muted">Poin: <span id="poinDisplay">0</span></small>
                    @error('jenis_pelanggaran_id')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan Kejadian <span class="text-danger">*</span></label>
                    <textarea name="keterangan" id="keterangan" rows="4" class="form-control @error('keterangan') is-invalid @enderror" placeholder="Jelaskan detail kejadian pelanggaran..." required>{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="foto_bukti" class="form-label">Upload Foto Bukti</label>
                    <input type="file" name="foto_bukti" id="foto_bukti" class="form-control @error('foto_bukti') is-invalid @enderror" accept="image/*">
                    <small class="text-muted">Format: JPG, PNG. Maksimal 2MB</small>
                    @error('foto_bukti')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('wali_kelas.laporan.index') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-arrow-left me-1"></i>
                        Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-save me-1"></i>
                        Simpan Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<!-- Modal Pilih Jenis Pelanggaran -->
<div class="modal fade" id="modalJenisPelanggaran" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa-solid fa-exclamation-triangle me-2"></i>Pilih Jenis Pelanggaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <table class="table table-hover" id="tablePelanggaran">
                    <thead>
                        <tr>
                            <th>Kategori</th>
                            <th>Nama Pelanggaran</th>
                            <th>Poin</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jenisPelanggaran as $jp)
                        <tr>
                            <td><span class="badge bg-secondary">{{ $jp->kategori->nama_kategori }}</span></td>
                            <td>{{ $jp->nama_pelanggaran }}</td>
                            <td><span class="badge bg-danger">{{ $jp->poin }}</span></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-success pilih-pelanggaran" 
                                        data-id="{{ $jp->id }}" 
                                        data-nama="{{ $jp->nama_pelanggaran }}"
                                        data-poin="{{ $jp->poin }}">
                                    <i class="fa-solid fa-check"></i> Pilih
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('wali_kelas/laporan.js') }}" defer></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('modalJenisPelanggaran');
        
        modal.addEventListener('click', function(e) {
            if (e.target.closest('.pilih-pelanggaran')) {
                const btn = e.target.closest('.pilih-pelanggaran');
                document.getElementById('jenis_pelanggaran_id').value = btn.dataset.id;
                document.getElementById('jenis_pelanggaran_nama').value = btn.dataset.nama;
                document.getElementById('poinDisplay').textContent = btn.dataset.poin;
                bootstrap.Modal.getInstance(modal).hide();
            }
        });
    });
    </script>
@endpush
