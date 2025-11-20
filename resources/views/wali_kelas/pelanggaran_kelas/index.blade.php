@extends('wali_kelas.layouts.app')

@section('title', 'Data Pelanggaran Kelas')

@push('styles')
    @vite('resources/css/wali_kelas/pelanggaran_kelas.css')
@endpush

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h3 class="mb-1">Data Pelanggaran Kelas</h3>
        <p class="text-muted">{{ $kelas ? $kelas->nama_kelas : '-' }}</p>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-dark"><i class="fa-solid fa-list me-2"></i>Daftar Pelanggaran</h6>
            <a href="{{ route('wali_kelas.pelanggaran_kelas.export') }}" class="btn btn-success btn-sm shadow-sm">
                <i class="fa-solid fa-file-excel me-2"></i>Export Excel
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive p-2 p-md-3">
                <table id="pelanggaranTable" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 5%;">No</th>
                            <th style="width: 12%;">Tanggal</th>
                            <th style="width: 20%;">Siswa</th>
                            <th style="width: 30%;">Pelanggaran</th>
                            <th class="text-center" style="width: 8%;">Poin</th>
                            <th style="width: 15%;">Pelapor</th>
                            <th class="text-center" style="width: 10%;">Status</th>
                            <th class="text-center" style="width: 10%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pelanggaran as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y H:i') }}</td>
                            <td><strong>{{ $item->siswa->nama_siswa }}</strong><br><small class="text-muted">{{ $item->siswa->nis }}</small></td>
                            <td>{{ $item->jenisPelanggaran->nama_pelanggaran }}</td>
                            <td class="text-center"><span class="badge bg-danger">{{ $item->poin }}</span></td>
                            <td>{{ $item->userPencatat->guru->nama_guru ?? $item->userPencatat->nama_lengkap ?? '-' }}</td>
                            <td class="text-center">
                                @if($item->status_verifikasi == 'menunggu')
                                    <span class="badge bg-warning">Menunggu</span>
                                @elseif($item->status_verifikasi == 'diverifikasi')
                                    <span class="badge bg-success">Disetujui</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('wali_kelas.pelanggaran_kelas.show', $item->id) }}" class="btn btn-sm btn-info" title="Detail">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Belum ada data pelanggaran</td>
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
    @vite('resources/js/wali_kelas/pelanggaran_kelas.js')
@endpush
