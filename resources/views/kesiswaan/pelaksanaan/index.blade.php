@extends('kesiswaan.layouts.app')
@section('title', 'Update Pelaksanaan Sanksi')

@push('styles')
    <link rel="stylesheet" href="{{ asset('kesiswaan/pelaksanaan.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h3 class="mb-1">✅ Update Pelaksanaan Sanksi</h3>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card shadow-sm mb-4 border-0">
        {{-- Header Card disamakan dengan Monitoring (Putih) --}}
        <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-dark"><i class="fa-solid fa-clipboard-check me-2"></i> Sanksi Aktif (Pending/Berjalan)</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive p-2 p-md-3">
                {{-- Gunakan class pelaksanaan-table --}}
                <table class="table pelaksanaan-table table-hover" id="tablePelaksanaan" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th class="text-center">Kelas</th>
                            <th>Jenis Sanksi</th>
                            <th>Tanggal Mulai</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sanksiAktif as $sanksi)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $sanksi->pelanggaran->siswa->nis }}</td>
                            <td><strong>{{ $sanksi->pelanggaran->siswa->nama_siswa }}</strong></td>
                            <td class="text-center"><span class="badge bg-info">{{ $sanksi->pelanggaran->siswa->kelas->nama_kelas ?? '-' }}</span></td>
                            <td>{{ $sanksi->jenis_sanksi }}</td>
                            <td>{{ \Carbon\Carbon::parse($sanksi->tanggal_mulai)->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <span class="badge bg-{{ $sanksi->status_sanksi == 'pending' ? 'warning' : 'info' }}">
                                    {{ strtoupper($sanksi->status_sanksi) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-success btn-action" data-bs-toggle="modal" data-bs-target="#updateModal{{ $sanksi->id }}">
                                    <i class="fa-solid fa-check"></i> Selesai
                                </button>
                            </td>
                        </tr>

                        <div class="modal fade" id="updateModal{{ $sanksi->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('kesiswaan.pelaksanaan.update', $sanksi->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header bg-success text-white">
                                            <h5 class="modal-title">Update Pelaksanaan Sanksi</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Siswa:</label>
                                                <p class="mb-0">{{ $sanksi->pelanggaran->siswa->nama_siswa }} ({{ $sanksi->pelanggaran->siswa->nis }})</p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Jenis Sanksi:</label>
                                                <p class="mb-0">{{ $sanksi->jenis_sanksi }}</p>
                                            </div>
                                            <hr>
                                            <div class="mb-3">
                                                <label class="form-label">Bukti Foto (Opsional)</label>
                                                <input type="file" name="bukti_foto" class="form-control" accept="image/*">
                                                <small class="text-muted">Upload foto bukti pelaksanaan sanksi</small>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Catatan</label>
                                                <textarea name="catatan" class="form-control" rows="3" placeholder="Catatan tambahan..."></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-success">
                                                <i class="fa-solid fa-check"></i> Tandai Selesai
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">Tidak ada sanksi aktif</td>
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
    <script src="{{ asset('kesiswaan/pelaksanaan.js') }}" defer></script>
@endpush