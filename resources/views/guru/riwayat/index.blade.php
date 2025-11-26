@extends('guru.layouts.app')

@section('title', 'Riwayat Laporanku')

@push('styles')
    <link rel="stylesheet" href="{{ asset('guru/riwayat.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    
    <div class="mb-4">
        <h3 class="mb-1">Riwayat Laporanku</h3>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-dark"><i class="fa-solid fa-list me-2"></i></h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive p-2 p-md-3">
                <table id="riwayatTable" class="table table-hover" style="width:100%;">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 3%;"></th>
                            <th class="text-center" style="width: 5%;">No</th>
                            <th style="width: 12%;">Tanggal</th>
                            <th style="width: 20%;">Siswa</th>
                            <th style="width: 33%;">Jenis Pelanggaran</th>
                            <th class="text-center" style="width: 8%;">Poin</th>
                            <th class="text-center" style="width: 10%;">Status</th>
                            <th class="text-center" style="width: 9%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pelanggarans as $index => $pelanggaran)
                        <tr>
                            <td class="text-center"></td>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($pelanggaran->tanggal)->format('d/m/Y H:i') }}</td>
                            <td><strong>{{ $pelanggaran->siswa->nama_siswa }}</strong></td>
                            <td>{{ $pelanggaran->jenisPelanggaran->nama_pelanggaran }}</td>
                            <td class="text-center"><span class="badge bg-danger">{{ $pelanggaran->poin }}</span></td>
                            <td class="text-center">
                                @if($pelanggaran->status_verifikasi == 'menunggu')
                                    <span class="badge bg-warning">Menunggu</span>
                                @elseif($pelanggaran->status_verifikasi == 'diverifikasi')
                                    <span class="badge bg-success">Disetujui</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('guru.riwayat.show', $pelanggaran->id) }}" class="btn btn-sm btn-info" title="Detail">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">Belum ada riwayat laporan</td>
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
    <script src="{{ asset('guru/riwayat.js') }}" defer></script>
@endpush
