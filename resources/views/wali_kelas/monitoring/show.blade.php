@extends('wali_kelas.layouts.app')

@section('title', 'Detail Siswa')

@push('styles')
    @vite('resources/css/wali_kelas/monitoring.css')
@endpush

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <h1 class="page-title">Detail Siswa</h1>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Informasi Siswa</h5>
        </div>
        <div class="card-body">
            <table class="table">
                <tr>
                    <th width="200">NIS</th>
                    <td>{{ $siswa->nis }}</td>
                </tr>
                <tr>
                    <th>Nama</th>
                    <td>{{ $siswa->nama_siswa }}</td>
                </tr>
                <tr>
                    <th>Kelas</th>
                    <td>{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Total Poin</th>
                    <td><span class="badge bg-danger fs-5">{{ $totalPoin }}</span></td>
                </tr>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Riwayat Pelanggaran</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Pelanggaran</th>
                            <th>Poin</th>
                            <th>Pelapor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswa->pelanggaran as $p)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y') }}</td>
                            <td>{{ $p->jenisPelanggaran->nama_pelanggaran }}</td>
                            <td><span class="badge bg-danger">{{ $p->poin }}</span></td>
                            <td>{{ $p->userPencatat->nama_lengkap ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Belum ada pelanggaran</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <a href="{{ route('wali_kelas.monitoring.index') }}" class="btn btn-secondary mt-3">Kembali</a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    @vite('resources/js/wali_kelas/monitoring.js')
@endpush
