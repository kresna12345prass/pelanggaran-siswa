@extends('ortu.layouts.app')

@section('title', 'Detail Pelanggaran')

@push('styles')
    <link rel="stylesheet" href="{{ asset('ortu/riwayat.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    
    <div class="page-header">
        <h1 class="page-title">📄 Detail Pelanggaran</h1>
        <a href="{{ route('ortu.riwayat.index') }}" class="btn btn-secondary">
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
                    <td>: {{ \Carbon\Carbon::parse($pelanggaran->tanggal)->format('d/m/Y H:i') }}</td>
                </tr>
                <tr>
                    <td><strong>Jenis Pelanggaran</strong></td>
                    <td>: {{ $pelanggaran->jenisPelanggaran->nama_pelanggaran ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Kategori</strong></td>
                    <td>: {{ $pelanggaran->jenisPelanggaran->kategoriPelanggaran->nama_kategori ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Poin</strong></td>
                    <td>: <span class="badge bg-danger">{{ $pelanggaran->poin }}</span></td>
                </tr>
                <tr>
                    <td><strong>Keterangan</strong></td>
                    <td>: {{ $pelanggaran->keterangan ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Pencatat</strong></td>
                    <td>: {{ $pelanggaran->pencatat->nama_lengkap ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Verifikator</strong></td>
                    <td>: {{ $pelanggaran->userVerifikator->nama_lengkap ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Status</strong></td>
                    <td>: 
                        @if($pelanggaran->status_verifikasi == 'diverifikasi')
                            <span class="badge bg-success">Diverifikasi</span>
                        @elseif($pelanggaran->status_verifikasi == 'menunggu')
                            <span class="badge bg-warning">Menunggu</span>
                        @else
                            <span class="badge bg-danger">Ditolak</span>
                        @endif
                    </td>
                </tr>
                @if($pelanggaran->foto_bukti)
                <tr>
                    <td><strong>Foto Bukti</strong></td>
                    <td>: <img src="{{ asset('storage/'.$pelanggaran->foto_bukti) }}" alt="Bukti" style="max-width: 300px;"></td>
                </tr>
                @endif
                @if($pelanggaran->dataSanksi)
                <tr>
                    <td colspan="2"><hr></td>
                </tr>
                <tr>
                    <td><strong>Sanksi</strong></td>
                    <td>: {{ $pelanggaran->dataSanksi->jenis_sanksi }}</td>
                </tr>
                <tr>
                    <td><strong>Deskripsi Sanksi</strong></td>
                    <td>: {{ $pelanggaran->dataSanksi->deskripsi_hukuman }}</td>
                </tr>
                @endif
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
    <script src="{{ asset('ortu/riwayat.js') }}" defer></script>
@endpush
