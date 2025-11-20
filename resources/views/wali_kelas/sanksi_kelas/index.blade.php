@extends('wali_kelas.layouts.app')

@section('title', 'Data Sanksi Kelas')

@push('styles')
    @vite('resources/css/wali_kelas/sanksi_kelas.css')
@endpush

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h3 class="mb-1">Data Sanksi Kelas</h3>
        <p class="text-muted">{{ $kelas ? $kelas->nama_kelas : '-' }}</p>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-dark"><i class="fa-solid fa-list me-2"></i>Daftar Sanksi</h6>
            <a href="{{ route('wali_kelas.sanksi_kelas.export') }}" class="btn btn-success btn-sm shadow-sm">
                <i class="fa-solid fa-file-excel me-2"></i>Export Excel
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive p-2 p-md-3">
                <table id="sanksiTable" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 5%;">No</th>
                            <th style="width: 12%;">Tanggal</th>
                            <th style="width: 20%;">Siswa</th>
                            <th style="width: 25%;">Jenis Sanksi</th>
                            <th class="text-center" style="width: 10%;">Total Poin</th>
                            <th class="text-center" style="width: 15%;">Status</th>
                            <th style="width: 13%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sanksi as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $item->tanggal_mulai ? \Carbon\Carbon::parse($item->tanggal_mulai)->format('d/m/Y') : '-' }}</td>
                            <td><strong>{{ $item->pelanggaran->siswa->nama_siswa ?? '-' }}</strong><br><small class="text-muted">{{ $item->pelanggaran->siswa->nis ?? '-' }}</small></td>
                            <td>{{ $item->jenis_sanksi }}</td>
                            <td class="text-center"><span class="badge bg-danger">{{ $item->pelanggaran->poin ?? 0 }}</span></td>
                            <td class="text-center">
                                @if($item->status_sanksi == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($item->status_sanksi == 'selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @elseif($item->status_sanksi == 'berjalan')
                                    <span class="badge bg-info">Berjalan</span>
                                @else
                                    <span class="badge bg-danger">Terlambat</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('wali_kelas.sanksi_kelas.show', $item->id) }}" class="btn btn-sm btn-info" title="Detail">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada data sanksi</td>
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
    @vite('resources/js/wali_kelas/sanksi_kelas.js')
@endpush
