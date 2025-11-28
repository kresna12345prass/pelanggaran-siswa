@extends('kesiswaan.layouts.app')
@section('title', 'Verifikasi Laporan')

@push('styles')
    <link rel="stylesheet" href="{{ asset('kesiswaan/verifikasi.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h3 class="mb-1">📋 Verifikasi Laporan Pelanggaran</h3>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm mb-4 border-0">
        {{-- Header Card Putih Minimalis --}}
        <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-dark"><i class="fa-solid fa-list-check me-2"></i> Daftar Menunggu Verifikasi</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive p-2 p-md-3">
                {{-- Gunakan class verifikasi-table --}}
                <table class="table verifikasi-table table-hover" id="verifikasiTable" style="width:100%;">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Tanggal</th>
                            <th>Siswa</th>
                            <th class="text-center">Kelas</th>
                            <th>Pelanggaran</th>
                            <th class="text-center">Poin</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pelanggarans as $index => $p)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y') }}</td>
                            <td><strong>{{ $p->siswa->nama_siswa }}</strong></td>
                            <td class="text-center"><span class="badge bg-info">{{ $p->siswa->kelas->nama_kelas ?? '-' }}</span></td>
                            <td>{{ $p->jenisPelanggaran->nama_pelanggaran }}</td>
                            <td class="text-center"><span class="badge bg-danger">{{ $p->poin }}</span></td>
                            <td class="text-center">
                                <div class="action-buttons">
                                    <a href="{{ route('kesiswaan.verifikasi.show', $p->id) }}" class="btn btn-info" title="Detail">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#validasiModal{{ $p->id }}" title="Validasi">
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#tolakModal{{ $p->id }}" title="Tolak">
                                        <i class="fa-solid fa-times"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade" id="validasiModal{{ $p->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('kesiswaan.verifikasi.update', $p->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="diverifikasi">
                                        <div class="modal-header bg-success text-white">
                                            <h5 class="modal-title">Validasi Pelanggaran</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Siswa:</strong> {{ $p->siswa->nama_siswa }}</p>
                                            <p><strong>Pelanggaran:</strong> {{ $p->jenisPelanggaran->nama_pelanggaran }}</p>
                                            <div class="mb-3">
                                                <label class="form-label">Catatan (Opsional)</label>
                                                <textarea name="catatan" class="form-control" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-success">Validasi</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="tolakModal{{ $p->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('kesiswaan.verifikasi.update', $p->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="ditolak">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title">Tolak Pelanggaran</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                                                <textarea name="catatan" class="form-control" rows="3" required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger">Tolak</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Tidak ada laporan yang menunggu verifikasi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('kesiswaan/verifikasi.js') }}" defer></script>
@endpush
