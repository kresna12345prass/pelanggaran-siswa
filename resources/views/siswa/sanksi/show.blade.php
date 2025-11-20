@extends('siswa.layouts.app')

@section('title', 'Detail Sanksi')

@push('styles')
    @vite('resources/css/siswa/sanksi.css')
@endpush

@section('content')
<div class="container-fluid">
    
    <div class="page-header">
        <h1 class="page-title">📄 Detail Sanksi</h1>
        <a href="{{ route('siswa.sanksi.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-borderless">
                <tr>
                    <td width="200"><strong>Jenis Sanksi</strong></td>
                    <td>: {{ $sanksi->jenis_sanksi }}</td>
                </tr>
                <tr>
                    <td><strong>Deskripsi</strong></td>
                    <td>: {{ $sanksi->deskripsi_hukuman }}</td>
                </tr>
                <tr>
                    <td><strong>Tanggal Mulai</strong></td>
                    <td>: {{ $sanksi->tanggal_mulai ? \Carbon\Carbon::parse($sanksi->tanggal_mulai)->format('d/m/Y') : '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Tanggal Selesai</strong></td>
                    <td>: {{ $sanksi->tanggal_selesai ? \Carbon\Carbon::parse($sanksi->tanggal_selesai)->format('d/m/Y') : '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Status</strong></td>
                    <td>: 
                        @if($sanksi->status_sanksi == 'selesai')
                            <span class="badge bg-success">SELESAI</span>
                        @elseif($sanksi->status_sanksi == 'berjalan')
                            <span class="badge bg-warning">BERJALAN</span>
                        @elseif($sanksi->status_sanksi == 'terlambat')
                            <span class="badge bg-danger">TERLAMBAT</span>
                        @else
                            <span class="badge bg-secondary">PENDING</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><strong>Penetap</strong></td>
                    <td>: {{ $sanksi->userPenetap->nama_lengkap ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Pelanggaran Terkait</strong></td>
                    <td>: {{ $sanksi->pelanggaran->jenisPelanggaran->nama_pelanggaran ?? '-' }}</td>
                </tr>
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
    @vite('resources/js/siswa/sanksi.js')
@endpush
