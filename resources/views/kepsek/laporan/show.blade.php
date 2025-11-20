@extends('kepsek.layouts.app')

@section('title', 'Hasil Laporan')

@push('styles')
    @vite('resources/css/kepsek/laporan.css')
@endpush

@section('content')

    <div class="mb-4">
        <h1 class="h3 mb-1 text-gray-800">Hasil Laporan</h1>
        <p class="text-muted mb-0 small">{{ $jenis == 'pelanggaran_siswa' ? 'Laporan Pelanggaran Siswa' : 'Rekapitulasi Poin Siswa per Kelas' }}</p>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-dark"><i class="fa-solid fa-list me-2"></i> Data Laporan</h6>
            <div class="d-flex gap-2">
                <a href="{{ route('kepsek.laporan.export', ['jenis' => $jenis, 'kelas_id' => $kelas_id, 'tanggal_mulai' => $tanggal_mulai, 'tanggal_selesai' => $tanggal_selesai]) }}" class="btn btn-success btn-sm shadow-sm">
                    <i class="fa-solid fa-file-excel me-2"></i>
                    <span class="d-none d-sm-inline">Export Excel</span>
                    <span class="d-inline d-sm-none">Excel</span>
                </a>
                <a href="{{ route('kepsek.laporan.index') }}" class="btn btn-secondary btn-sm shadow-sm">
                    <i class="fa-solid fa-arrow-left me-2"></i>
                    <span class="d-none d-sm-inline">Kembali</span>
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            {{-- Laporan Pelanggaran Siswa --}}
            @if($jenis == 'pelanggaran_siswa')
                <div class="table-responsive p-2 p-md-3">
                    <table class="table laporan-table table-hover" id="laporanTable" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Tanggal</th>
                                <th>Siswa</th>
                                <th class="text-center">Kelas</th>
                                <th>Pelanggaran</th>
                                <th class="text-center">Poin</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                                    <td><strong>{{ $item->siswa->nama_siswa ?? '-' }}</strong></td>
                                    <td class="text-center"><span class="badge bg-info">{{ $item->siswa->kelas->nama_kelas ?? '-' }}</span></td>
                                    <td>{{ $item->jenisPelanggaran->nama_pelanggaran ?? '-' }}</td>
                                    <td class="text-center"><span class="badge bg-danger">{{ $item->poin }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">Tidak ada data pelanggaran pada periode ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            
            {{-- Rekapitulasi Kelas --}}
            @elseif($jenis == 'rekapitulasi_kelas')
                <div class="table-responsive p-2 p-md-3">
                    <table class="table laporan-table table-hover" id="laporanTable" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th class="text-center">Kelas</th>
                                <th class="text-center">Total Poin</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $item->nis }}</td>
                                    <td><strong>{{ $item->nama_siswa }}</strong></td>
                                    <td class="text-center"><span class="badge bg-info">{{ $item->kelas->nama_kelas ?? '-' }}</span></td>
                                    <td class="text-center">
                                        <span class="badge bg-{{ $item->total_poin >= 50 ? 'danger' : ($item->total_poin >= 20 ? 'warning' : 'success') }}">
                                            {{ $item->total_poin }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Tidak ada data siswa.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

@endsection

@push('scripts')
    @vite('resources/js/kepsek/laporan.js')
@endpush