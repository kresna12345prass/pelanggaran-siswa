@extends('kepsek.layouts.app')

@section('title', 'Detail Siswa Bermasalah')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Siswa Bermasalah</h1>
        <a href="{{ route('kepsek.siswa_bermasalah.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-body text-center">
                    @if($siswa->foto)
                        <img src="{{ Storage::url($siswa->foto) }}" alt="{{ $siswa->nama_siswa }}" class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($siswa->nama_siswa) }}&size=150&background=dc3545&color=fff" alt="{{ $siswa->nama_siswa }}" class="rounded-circle mb-3">
                    @endif
                    <h4 class="mb-1">{{ $siswa->nama_siswa }}</h4>
                    <p class="text-muted mb-3">
                        <span class="badge bg-info">{{ $siswa->kelas->nama_kelas ?? 'N/A' }}</span>
                    </p>
                    <div class="alert alert-{{ $totalPoin >= 100 ? 'danger' : ($totalPoin >= 50 ? 'warning' : 'secondary') }}">
                        <h5 class="mb-0">Total Poin: {{ $totalPoin }}</h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Riwayat Pelanggaran</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Jenis Pelanggaran</th>
                                    <th>Poin</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($siswa->pelanggaran as $p)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y') }}</td>
                                        <td>{{ $p->jenisPelanggaran->nama_pelanggaran ?? '-' }}</td>
                                        <td><span class="badge bg-danger">{{ $p->poin }}</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada riwayat pelanggaran</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
