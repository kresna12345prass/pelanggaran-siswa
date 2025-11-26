@extends('kesiswaan.layouts.app')
@section('title', 'Monitoring Sanksi')

@push('styles')
    <link rel="stylesheet" href="{{ asset('kesiswaan/monitoring.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h3 class="mb-1">📊 Monitoring Pelaksanaan Sanksi</h3>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm mb-4 border-0">
        <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-dark"><i class="fa-solid fa-list me-2"></i> Daftar Sanksi</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive p-2 p-md-3">
                {{-- GUNAKAN CLASS monitoring-table --}}
                <table class="table monitoring-table table-hover" id="monitoringTable" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th>Nama Siswa</th>
                            <th class="text-center">Kelas</th>
                            <th>Jenis Sanksi</th>
                            {{-- Kolom Periode DIHAPUS --}}
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sanksis as $index => $sanksi)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td><strong>{{ $sanksi->pelanggaran->siswa->nama_siswa }}</strong></td>
                            <td class="text-center"><span class="badge bg-info">{{ $sanksi->pelanggaran->siswa->kelas->nama_kelas ?? '-' }}</span></td>
                            <td>{{ $sanksi->jenis_sanksi }}</td>
                            {{-- Kolom Periode DIHAPUS --}}
                            <td class="text-center">
                                @if($sanksi->status_sanksi == 'berjalan')
                                    <span class="badge bg-warning">Berjalan</span>
                                @elseif($sanksi->status_sanksi == 'selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @elseif($sanksi->status_sanksi == 'terlambat')
                                    <span class="badge bg-danger">Terlambat</span>
                                @else
                                    <span class="badge bg-secondary">Pending</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="action-buttons">
                                    <a href="{{ route('kesiswaan.monitoring.show', $sanksi->id) }}" class="btn btn-sm btn-info" title="Detail">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    @if($sanksi->status_sanksi == 'berjalan')
                                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#selesaiModal{{ $sanksi->id }}" title="Selesai">
                                            <i class="fa-solid fa-check"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade" id="selesaiModal{{ $sanksi->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('kesiswaan.monitoring.update', $sanksi->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="selesai">
                                        <div class="modal-header bg-success text-white">
                                            <h5 class="modal-title">Tandai Selesai</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Apakah Anda yakin sanksi untuk <strong>{{ $sanksi->pelanggaran->siswa->nama_siswa }}</strong> sudah selesai dilaksanakan?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-success">Ya, Selesai</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Tidak ada sanksi yang sedang berjalan</td>
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
    <script src="{{ asset('kesiswaan/monitoring.js') }}" defer></script>
@endpush