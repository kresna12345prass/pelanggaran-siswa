@extends('ortu.layouts.app')

@section('title', 'Data Prestasi')

@push('styles')
    <link rel="stylesheet" href="{{ asset('ortu/prestasi.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    
    <div class="mb-4">
        <h3 class="mb-1">🏆 Data Prestasi Anak</h3>
        <p class="text-muted small">{{ $siswa->nama_siswa }}</p>
    </div>

    <div class="card mb-4 shadow-sm border-0">
        <div class="card-body">
            <h5>Total Poin Prestasi: <span class="badge bg-success">{{ $totalPoin }}</span></h5>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-dark"><i class="fa-solid fa-list me-2"></i></h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive p-2 p-md-3">
                <table class="table table-hover" id="prestasiTable" style="width:100%;">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 3%;"></th>
                            <th class="text-center" style="width: 5%;">No</th>
                            <th style="width: 30%;">Jenis Prestasi</th>
                            <th style="width: 15%;">Tingkat</th>
                            <th style="width: 15%;">Penghargaan</th>
                            <th class="text-center" style="width: 10%;">Poin</th>
                            <th style="width: 15%;">Pencatat</th>
                            <th class="text-center" style="width: 7%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($prestasi as $index => $item)
                        <tr>
                            <td class="text-center"></td>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td><strong>{{ $item->jenisPrestasi->nama_prestasi ?? '-' }}</strong></td>
                            <td>{{ ucfirst($item->tingkat) }}</td>
                            <td>{{ ucfirst($item->penghargaan) }}</td>
                            <td class="text-center"><span class="badge bg-success">{{ $item->poin }}</span></td>
                            <td>{{ $item->pencatat->nama_lengkap ?? '-' }}</td>
                            <td class="text-center">
                                <a href="{{ route('ortu.prestasi.show', $item->id) }}" class="btn btn-sm btn-info" title="Detail">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data prestasi</td>
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
    <script src="{{ asset('ortu/prestasi.js') }}" defer></script>
@endpush
