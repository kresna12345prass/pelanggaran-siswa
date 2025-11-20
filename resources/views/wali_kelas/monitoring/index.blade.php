@extends('wali_kelas.layouts.app')

@section('title', 'Monitoring Kelas')

@push('styles')
    @vite('resources/css/wali_kelas/monitoring.css')
@endpush

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h3 class="mb-1">Monitoring Kelas Binaan</h3>
        <p class="text-muted small">{{ $kelas ? $kelas->nama_kelas : 'Belum ada kelas' }}</p>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-dark"><i class="fa-solid fa-list me-2"></i></h6>
            <div class="d-flex gap-2">
                <a href="{{ route('wali_kelas.monitoring.export') }}" class="btn btn-success btn-sm shadow-sm">
                    <i class="fa-solid fa-file-excel me-2"></i>
                    <span class="d-none d-sm-inline">Export Excel</span>
                    <span class="d-inline d-sm-none">Excel</span>
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive p-2 p-md-3">
                <table id="monitoringTable" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 3%;"></th>
                            <th class="text-center" style="width: 5%;">No</th>
                            <th style="width: 15%;">NIS</th>
                            <th style="width: 35%;">Nama Siswa</th>
                            <th class="text-center" style="width: 12%;">Total Poin</th>
                            <th class="text-center" style="width: 15%;">Status</th>
                            <th class="text-center" style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswaList as $siswa)
                        <tr>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td>{{ $siswa->nis }}</td>
                            <td><strong>{{ $siswa->nama_siswa }}</strong></td>
                            <td class="text-center"><span class="badge bg-danger">{{ $siswa->total_poin }}</span></td>
                            <td class="text-center">
                                @if($siswa->status_poin == 'Kritis')
                                    <span class="badge bg-danger">Kritis</span>
                                @elseif($siswa->status_poin == 'Lampu Kuning')
                                    <span class="badge bg-warning">Lampu Kuning</span>
                                @else
                                    <span class="badge bg-success">Aman</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('wali_kelas.monitoring.show', $siswa->id) }}" class="btn btn-sm btn-info" title="Detail">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada siswa di kelas ini</td>
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
    @vite('resources/js/wali_kelas/monitoring.js')
@endpush
