@extends('kesiswaan.layouts.app')
@section('title', 'Detail Verifikasi')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Detail Pelanggaran</h3>
        <a href="{{ route('kesiswaan.verifikasi.riwayat') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Informasi Pelanggaran</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th width="200">Siswa</th>
                            <td>{{ $pelanggaran->siswa->nama_siswa }} ({{ $pelanggaran->siswa->nis }})</td>
                        </tr>
                        <tr>
                            <th>Kelas</th>
                            <td>{{ $pelanggaran->siswa->kelas->nama_kelas ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Pelanggaran</th>
                            <td>{{ $pelanggaran->jenisPelanggaran->nama_pelanggaran }}</td>
                        </tr>
                        <tr>
                            <th>Poin</th>
                            <td><span class="badge bg-danger fs-6">{{ $pelanggaran->poin }}</span></td>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <td>{{ \Carbon\Carbon::parse($pelanggaran->tanggal)->format('d F Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Keterangan</th>
                            <td>{{ $pelanggaran->keterangan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Pencatat</th>
                            <td>{{ $pelanggaran->pencatat->nama_lengkap ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($pelanggaran->status_verifikasi == 'menunggu')
                                    <span class="badge bg-warning">Menunggu</span>
                                @elseif($pelanggaran->status_verifikasi == 'diverifikasi')
                                    <span class="badge bg-success">Diverifikasi</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            @if($pelanggaran->foto_bukti)
            <div class="card mb-3">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Foto Bukti</h5>
                </div>
                <div class="card-body text-center">
                    <img src="{{ asset('storage/' . $pelanggaran->foto_bukti) }}" class="img-fluid rounded" alt="Bukti">
                </div>
            </div>
            @endif

            @if($pelanggaran->status_verifikasi == 'menunggu')
            <div class="card">
                <div class="card-header bg-warning">
                    <h5 class="mb-0">Aksi Verifikasi</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('kesiswaan.verifikasi.update', $pelanggaran->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select" required>
                                <option value="">Pilih Status</option>
                                <option value="diverifikasi">Validasi</option>
                                <option value="ditolak">Tolak</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Catatan</label>
                            <textarea name="catatan" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fa-solid fa-save"></i> Simpan Verifikasi
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>


</div>
@endsection
