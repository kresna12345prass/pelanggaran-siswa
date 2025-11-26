@extends('bk.layouts.app')

@section('title', 'Tindak Lanjut')

@push('styles')
    <link rel="stylesheet" href="{{ asset('bk/tindak_lanjut.css') }}">
@endpush

@section('content')
    <div class="mb-4">
        <h3 class="mb-1">Tindak Lanjut Konseling</h3>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-dark"><i class="fa-solid fa-list me-2"></i></h6>
            <div class="d-flex gap-2">
                <a href="{{ route('bk.tindak_lanjut.export') }}" class="btn btn-success btn-sm shadow-sm">
                    <i class="fa-solid fa-file-excel me-2"></i>
                    <span class="d-none d-sm-inline">Export Excel</span>
                    <span class="d-inline d-sm-none">Excel</span>
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive p-2 p-md-3">
                <table id="tindakLanjutTable" class="table table-hover" style="width:100%; font-size: 1.15rem;">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 3%;"></th>
                            <th class="text-center" style="width: 5%;">No</th>
                            <th style="width: 12%;">Tanggal Konseling</th>
                            <th style="width: 25%;">Siswa</th>
                            <th style="width: 25%;">Topik</th>
                            <th style="width: 15%;">Tanggal Tindak Lanjut</th>
                            <th class="text-center" style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tindakLanjut as $index => $item)
                        <tr>
                            <td class="text-center"></td>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_konseling)->format('d/m/Y') }}</td>
                            <td><strong>{{ $item->siswa->nama_siswa }}</strong></td>
                            <td>{{ $item->topik }}</td>
                            <td>
                                @if($item->tanggal_tindak_lanjut)
                                    {{ \Carbon\Carbon::parse($item->tanggal_tindak_lanjut)->format('d/m/Y') }}
                                @else
                                    <span class="badge bg-warning">Belum dijadwalkan</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('bk.tindak_lanjut.show', $item->id) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('bk.tindak_lanjut.edit', $item->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fa-solid fa-edit"></i>
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
    <script src="{{ asset('bk/tindak_lanjut.js') }}" defer></script>
@endpush
