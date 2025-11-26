@extends('wali_kelas.layouts.app')

@section('title', 'Data Prestasi Kelas')

@push('styles')
    <link rel="stylesheet" href="{{ asset('wali_kelas/prestasi_kelas.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h3 class="mb-1">Data Prestasi Kelas</h3>
        <p class="text-muted">{{ $kelas ? $kelas->nama_kelas : '-' }}</p>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-dark"><i class="fa-solid fa-list me-2"></i>Daftar Prestasi</h6>
            <a href="{{ route('wali_kelas.prestasi_kelas.export') }}" class="btn btn-success btn-sm shadow-sm">
                <i class="fa-solid fa-file-excel me-2"></i>Export Excel
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive p-2 p-md-3">
                <table id="prestasiTable" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 5%;">No</th>
                            <th style="width: 12%;">Tanggal</th>
                            <th style="width: 20%;">Siswa</th>
                            <th style="width: 25%;">Jenis Prestasi</th>
                            <th class="text-center" style="width: 12%;">Tingkat</th>
                            <th class="text-center" style="width: 12%;">Peringkat</th>
                            <th class="text-center" style="width: 14%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($prestasi as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                            <td><strong>{{ $item->siswa->nama_siswa }}</strong><br><small class="text-muted">{{ $item->siswa->nis }}</small></td>
                            <td>{{ $item->jenisPrestasi->nama_prestasi }}</td>
                            <td class="text-center"><span class="badge bg-primary">{{ ucfirst($item->tingkat) }}</span></td>
                            <td class="text-center"><span class="badge bg-success">{{ $item->peringkat }}</span></td>
                            <td class="text-center">
                                <a href="{{ route('wali_kelas.prestasi_kelas.show', $item->id) }}" class="btn btn-sm btn-info" title="Detail">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada data prestasi</td>
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
    <script src="{{ asset('wali_kelas/prestasi_kelas.js') }}" defer></script>
@endpush
