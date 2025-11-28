@extends('siswa.layouts.app')

@section('title', 'Data Prestasi')

@push('styles')
    <link rel="stylesheet" href="{{ asset('siswa/prestasi.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    
    <div class="mb-4">
        <h3 class="mb-1">🏆 Data Prestasi</h3>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-dark"><i class="fa-solid fa-trophy me-2"></i> Daftar Prestasi Saya</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive p-2 p-md-3">
                {{-- Gunakan class prestasi-table (ukuran normal) --}}
                <table class="table prestasi-table table-hover" id="prestasiTable" style="width:100%;">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Tanggal</th>
                            <th>Jenis Prestasi</th>
                            <th class="text-center">Tingkat</th>
                            <th>Pencatat</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($prestasi as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                            <td>
                                <strong>{{ $item->jenisPrestasi->nama_prestasi ?? '-' }}</strong>
                                @if($item->penghargaan)
                                    <div class="text-muted-small">{{ $item->penghargaan }}</div>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge 
                                    @if($item->tingkat == 'Internasional') bg-danger
                                    @elseif($item->tingkat == 'Nasional') bg-warning
                                    @elseif($item->tingkat == 'Provinsi') bg-info
                                    @elseif($item->tingkat == 'Kabupaten/Kota') bg-primary
                                    @else bg-success
                                    @endif">
                                    {{ $item->tingkat }}
                                </span>
                            </td>
                            <td>{{ $item->pencatat->nama_lengkap ?? '-' }}</td>
                            <td class="text-center">
                                <div class="action-buttons">
                                    <a href="{{ route('siswa.prestasi.show', $item->id) }}" class="btn btn-info" title="Detail">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada data prestasi</td>
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
    <script src="{{ asset('siswa/prestasi.js') }}" defer></script>
@endpush
