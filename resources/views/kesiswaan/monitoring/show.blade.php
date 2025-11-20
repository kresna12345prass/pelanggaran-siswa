@extends('kesiswaan.layouts.app')
@section('title', 'Detail Monitoring')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Detail Monitoring Sanksi</h3>
        <a href="{{ route('kesiswaan.monitoring.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Data Siswa</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th width="150">Nama</th>
                            <td>{{ $sanksi->pelanggaran->siswa->nama_siswa }}</td>
                        </tr>
                        <tr>
                            <th>NIS</th>
                            <td>{{ $sanksi->pelanggaran->siswa->nis }}</td>
                        </tr>
                        <tr>
                            <th>Kelas</th>
                            <td>{{ $sanksi->pelanggaran->siswa->kelas->nama_kelas ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-warning">
                    <h5 class="mb-0">Pelanggaran</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th width="150">Jenis</th>
                            <td>{{ $sanksi->pelanggaran->jenisPelanggaran->nama_pelanggaran }}</td>
                        </tr>
                        <tr>
                            <th>Poin</th>
                            <td><span class="badge bg-danger">{{ $sanksi->pelanggaran->poin }}</span></td>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <td>{{ \Carbon\Carbon::parse($sanksi->pelanggaran->tanggal)->format('d F Y') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Detail Sanksi</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th width="150">Jenis Sanksi</th>
                            <td><strong>{{ $sanksi->jenis_sanksi }}</strong></td>
                        </tr>
                        <tr>
                            <th>Deskripsi</th>
                            <td>{{ $sanksi->deskripsi_hukuman }}</td>
                        </tr>
                        <tr>
                            <th>Periode</th>
                            <td>
                                {{ \Carbon\Carbon::parse($sanksi->tanggal_mulai)->format('d F Y') }}
                                @if($sanksi->tanggal_selesai)
                                    - {{ \Carbon\Carbon::parse($sanksi->tanggal_selesai)->format('d F Y') }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($sanksi->status_sanksi == 'berjalan')
                                    <span class="badge bg-warning">Berjalan</span>
                                @elseif($sanksi->status_sanksi == 'selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @elseif($sanksi->status_sanksi == 'terlambat')
                                    <span class="badge bg-danger">Terlambat</span>
                                @else
                                    <span class="badge bg-secondary">Pending</span>
                                @endif
                            </td>
                        </tr>
                    </table>

                    @if($sanksi->status_sanksi == 'berjalan')
                    <form action="{{ route('kesiswaan.monitoring.update', $sanksi->id) }}" method="POST" class="mt-3">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="selesai">
                        <button type="submit" class="btn btn-success w-100" onclick="return confirm('Yakin tandai selesai?')">
                            <i class="fa-solid fa-check"></i> Tandai Selesai
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
