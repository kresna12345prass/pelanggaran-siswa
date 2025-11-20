@extends('ortu.layouts.app')

@section('title', 'Detail Prestasi')

@push('styles')
    @vite('resources/css/ortu/prestasi.css')
@endpush

@section('content')
<div class="container-fluid">
    
    <div class="page-header">
        <h1 class="page-title">📄 Detail Prestasi</h1>
        <a href="{{ route('ortu.prestasi.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-borderless">
                <tr>
                    <td width="200"><strong>Nama Siswa</strong></td>
                    <td>: {{ $siswa->nama_siswa }}</td>
                </tr>
                <tr>
                    <td><strong>NIS</strong></td>
                    <td>: {{ $siswa->nis }}</td>
                </tr>
                <tr>
                    <td><strong>Kelas</strong></td>
                    <td>: {{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                </tr>
                <tr>
                    <td colspan="2"><hr></td>
                </tr>
                <tr>
                    <td><strong>Tanggal</strong></td>
                    <td>: {{ \Carbon\Carbon::parse($prestasi->tanggal)->format('d/m/Y H:i') }}</td>
                </tr>
                <tr>
                    <td><strong>Jenis Prestasi</strong></td>
                    <td>: {{ $prestasi->jenisPrestasi->nama_prestasi ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Tingkat</strong></td>
                    <td>: {{ ucfirst($prestasi->tingkat) }}</td>
                </tr>
                <tr>
                    <td><strong>Penghargaan</strong></td>
                    <td>: {{ ucfirst($prestasi->penghargaan) }}</td>
                </tr>
                <tr>
                    <td><strong>Poin</strong></td>
                    <td>: <span class="badge bg-success">{{ $prestasi->poin }}</span></td>
                </tr>
                <tr>
                    <td><strong>Keterangan</strong></td>
                    <td>: {{ $prestasi->keterangan ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Pencatat</strong></td>
                    <td>: {{ $prestasi->pencatat->nama_lengkap ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Verifikator</strong></td>
                    <td>: {{ $prestasi->verifikator->nama_lengkap ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Status</strong></td>
                    <td>: 
                        @if($prestasi->status_verifikasi == 'diverifikasi')
                            <span class="badge bg-success">Diverifikasi</span>
                        @elseif($prestasi->status_verifikasi == 'menunggu')
                            <span class="badge bg-warning">Menunggu</span>
                        @else
                            <span class="badge bg-danger">Ditolak</span>
                        @endif
                    </td>
                </tr>
                @if($prestasi->bukti_dokumen)
                <tr>
                    <td><strong>Bukti Dokumen</strong></td>
                    <td>: <img src="{{ asset('storage/'.$prestasi->bukti_dokumen) }}" alt="Bukti" style="max-width: 300px;"></td>
                </tr>
                @endif
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
    @vite('resources/js/ortu/prestasi.js')
@endpush
