@extends('bk.layouts.app')

@section('title', 'Detail Siswa')

@push('styles')
    <link rel="stylesheet" href="{{ asset('bk/watchlist.css') }}">
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Siswa</h1>
        <a href="{{ route('bk.watchlist.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informasi Siswa</h5>
                </div>
                <div class="card-body">
                    <p><strong>NIS:</strong> {{ $siswa->nis }}</p>
                    <p><strong>Nama:</strong> {{ $siswa->nama_siswa }}</p>
                    <p><strong>Kelas:</strong> {{ $siswa->kelas->nama_kelas ?? '-' }}</p>
                    <p><strong>Total Poin:</strong> <span class="badge bg-danger">{{ $siswa->pelanggaran_sum_poin }} Poin</span></p>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Riwayat Pelanggaran</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Pelanggaran</th>
                                    <th>Poin</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($siswa->pelanggaran as $p)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y') }}</td>
                                    <td>{{ $p->jenisPelanggaran->nama_pelanggaran }}</td>
                                    <td><span class="badge bg-danger">{{ $p->poin }}</span></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">Tidak ada riwayat pelanggaran</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">Riwayat Konseling</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Topik</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($siswa->bimbinganKonseling as $bk)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($bk->tanggal_konseling)->format('d/m/Y') }}</td>
                                    <td>{{ $bk->topik }}</td>
                                    <td><span class="badge bg-info">{{ ucfirst($bk->status) }}</span></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">Belum ada riwayat konseling</td>
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

@push('scripts')
    <script src="{{ asset('bk/watchlist.js') }}" defer></script>
@endpush
