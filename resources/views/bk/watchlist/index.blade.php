@extends('bk.layouts.app')

@section('title', 'Watchlist Siswa')

@push('styles')
    @vite('resources/css/bk/watchlist.css')
@endpush

@section('content')
    <div class="mb-4">
        <h3 class="mb-1">Watchlist Siswa Bermasalah</h3>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-dark"><i class="fa-solid fa-list me-2"></i></h6>
            <div class="d-flex gap-2">
                <a href="{{ route('bk.watchlist.export') }}" class="btn btn-success btn-sm shadow-sm">
                    <i class="fa-solid fa-file-excel me-2"></i>
                    <span class="d-none d-sm-inline">Export Excel</span>
                    <span class="d-inline d-sm-none">Excel</span>
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive p-2 p-md-3">
                <table id="watchlistTable" class="table table-hover" style="width:100%;">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 3%;"></th>
                            <th class="text-center" style="width: 5%;">No</th>
                            <th style="width: 10%;">Rank</th>
                            <th style="width: 12%;">NIS</th>
                            <th style="width: 25%;">Nama Siswa</th>
                            <th style="width: 15%;">Kelas</th>
                            <th class="text-center" style="width: 10%;">Poin</th>
                            <th class="text-center" style="width: 20%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topPelanggar as $index => $siswa)
                        <tr>
                            <td class="text-center"></td>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>
                                <span class="badge bg-{{ $index < 3 ? 'danger' : 'warning' }}">
                                    #{{ $index + 1 }}
                                </span>
                            </td>
                            <td>{{ $siswa->nis }}</td>
                            <td><strong>{{ $siswa->nama_siswa }}</strong></td>
                            <td><span class="badge bg-info">{{ $siswa->kelas->nama_kelas ?? '-' }}</span></td>
                            <td class="text-center">
                                <span class="badge bg-danger">{{ $siswa->pelanggaran_sum_poin }}</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('bk.watchlist.show', $siswa->id) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/bk/watchlist.js')
@endpush
