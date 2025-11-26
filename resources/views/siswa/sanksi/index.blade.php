@extends('siswa.layouts.app')

@section('title', 'Status Sanksi')

@push('styles')
    <link rel="stylesheet" href="{{ asset('siswa/sanksi.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    
    <div class="mb-4">
        <h3 class="mb-1">⚠️ Status Sanksi</h3>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-dark"><i class="fa-solid fa-list me-2"></i></h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive p-2 p-md-3">
                <table class="table table-hover" id="sanksiTable" style="width:100%;">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 3%;"></th>
                            <th class="text-center" style="width: 5%;">No</th>
                            <th style="width: 18%;">Jenis Sanksi</th>
                            <th style="width: 30%;">Deskripsi</th>
                            <th style="width: 12%;">Tanggal Mulai</th>
                            <th style="width: 12%;">Tanggal Selesai</th>
                            <th class="text-center" style="width: 10%;">Status</th>
                            <th class="text-center" style="width: 10%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sanksi as $index => $item)
                        <tr>
                            <td class="text-center"></td>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td><strong>{{ $item->jenis_sanksi }}</strong></td>
                            <td>{{ Str::limit($item->deskripsi_hukuman, 50) }}</td>
                            <td>{{ $item->tanggal_mulai ? \Carbon\Carbon::parse($item->tanggal_mulai)->format('d/m/Y') : '-' }}</td>
                            <td>{{ $item->tanggal_selesai ? \Carbon\Carbon::parse($item->tanggal_selesai)->format('d/m/Y') : '-' }}</td>
                            <td class="text-center">
                                @if($item->status_sanksi == 'selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @elseif($item->status_sanksi == 'berjalan')
                                    <span class="badge bg-warning">Berjalan</span>
                                @elseif($item->status_sanksi == 'terlambat')
                                    <span class="badge bg-danger">Terlambat</span>
                                @else
                                    <span class="badge bg-secondary">Pending</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('siswa.sanksi.show', $item->id) }}" class="btn btn-sm btn-info" title="Detail">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada sanksi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="alert alert-info mt-3">
        <i class="fa-solid fa-info-circle me-2"></i>
        <strong>Catatan:</strong> Untuk update status sanksi, silakan menemui bagian kesiswaan dengan membawa bukti pelaksanaan sanksi.
    </div>

</div>
@endsection

@push('scripts')
    <script src="{{ asset('siswa/sanksi.js') }}" defer></script>
@endpush
