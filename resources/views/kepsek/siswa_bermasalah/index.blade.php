@extends('kepsek.layouts.app')

@section('title', 'Monitoring Siswa Bermasalah')

@push('styles')
    <link rel="stylesheet" href="{{ asset('kepsek/siswa_bermasalah.css') }}">
@endpush

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1 text-gray-800">Monitoring Siswa Bermasalah</h1>
        <p class="text-muted mb-0 small">Daftar siswa dengan poin pelanggaran</p>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-dark"><i class="fa-solid fa-list me-2"></i></h6>
            <div class="d-flex gap-2">
                <a href="{{ route('kepsek.siswa_bermasalah.export') }}" class="btn btn-success btn-sm shadow-sm">
                    <i class="fa-solid fa-file-excel me-2"></i>
                    <span class="d-none d-sm-inline">Export Excel</span>
                    <span class="d-inline d-sm-none">Excel</span>
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive p-2 p-md-3">
                <table class="table table-hover" id="siswaTable" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 3%;"></th>
                            <th class="text-center" style="width: 5%;">No</th>
                            <th style="width: 12%;">NIS</th>
                            <th style="width: 30%;">Nama Siswa</th>
                            <th style="width: 15%;">Kelas</th>
                            <th class="text-center" style="width: 13%;">Total Poin</th>
                            <th class="text-center" style="width: 12%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($siswa as $index => $s)
                            <tr>
                                <td class="text-center"></td>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $s->nis }}</td>
                                <td><strong>{{ $s->nama_siswa }}</strong></td>
                                <td><span class="badge bg-info">{{ $s->kelas->nama_kelas ?? 'N/A' }}</span></td>
                                <td class="text-center">
                                    <span class="badge bg-{{ $s->total_poin >= 100 ? 'danger' : ($s->total_poin >= 50 ? 'warning' : 'secondary') }}">
                                        {{ $s->total_poin }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('kepsek.siswa_bermasalah.show', $s->id) }}" class="btn btn-info btn-sm" title="Lihat Detail">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data siswa bermasalah.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('kepsek/siswa_bermasalah.js') }}" defer></script>
@endpush
