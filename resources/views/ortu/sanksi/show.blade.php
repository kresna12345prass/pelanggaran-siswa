@extends('ortu.layouts.app')

@section('title', 'Detail Sanksi')

@push('styles')
    <link rel="stylesheet" href="{{ asset('ortu/sanksi.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    
    <div class="page-header">
        <h1 class="page-title">📄 Detail Sanksi</h1>
        <a href="{{ route('ortu.sanksi.index') }}" class="btn btn-secondary">
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
                    <td><strong>Jenis Sanksi</strong></td>
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

            @if($sanksi->pelaksanaan && $sanksi->pelaksanaan->count() > 0)
            <hr>
            <h5>Riwayat Pelaksanaan</h5>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sanksi->pelaksanaan as $p)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($p->tanggal_pelaksanaan)->format('d/m/Y') }}</td>
                            <td>
                                @if($p->status == 'hadir')
                                    <span class="badge bg-success">Hadir</span>
                                @elseif($p->status == 'tidak_hadir')
                                    <span class="badge bg-danger">Tidak Hadir</span>
                                @else
                                    <span class="badge bg-info">Tuntas</span>
                                @endif
                            </td>
                            <td>{{ $p->catatan ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>

    <div class="alert alert-warning mt-3">
        <i class="fa-solid fa-exclamation-triangle me-2"></i>
        <strong>Penting:</strong> Mohon pastikan anak menyelesaikan sanksi sesuai jadwal. Hubungi bagian kesiswaan jika ada kendala.
    </div>

</div>
@endsection

@push('scripts')
    <script src="{{ asset('ortu/sanksi.js') }}" defer></script>
@endpush
