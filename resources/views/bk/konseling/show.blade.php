@extends('bk.layouts.app')

@section('title', 'Detail Konseling')

@push('styles')
    <link rel="stylesheet" href="{{ asset('bk/konseling.css') }}">
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Konseling</h1>
        <div>
            <a href="{{ route('bk.konseling.edit', $konseling->id) }}" class="btn btn-warning">
                <i class="fa-solid fa-edit"></i> Edit
            </a>
            <a href="{{ route('bk.konseling.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informasi Konseling</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Siswa</th>
                            <td>{{ $konseling->siswa->nama_siswa }}</td>
                        </tr>
                        <tr>
                            <th>NIS</th>
                            <td>{{ $konseling->siswa->nis }}</td>
                        </tr>
                        <tr>
                            <th>Kelas</th>
                            <td>{{ $konseling->siswa->kelas->nama_kelas ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Konseling</th>
                            <td>{{ \Carbon\Carbon::parse($konseling->tanggal_konseling)->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <th>Tahun Ajaran</th>
                            <td>{{ $konseling->tahunAjaran->tahun_ajaran }} - {{ $konseling->tahunAjaran->semester }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Layanan</th>
                            <td>{{ $konseling->jenis_layanan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge bg-{{ $konseling->status == 'selesai' ? 'success' : ($konseling->status == 'aktif' ? 'warning' : 'info') }}">
                                    {{ ucfirst($konseling->status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Konselor</th>
                            <td>{{ $konseling->guruBk->nama_lengkap }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Detail Konseling</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Topik:</strong>
                        <p>{{ $konseling->topik }}</p>
                    </div>
                    <div class="mb-3">
                        <strong>Keluhan/Masalah:</strong>
                        <p>{{ $konseling->keluhan_masalah }}</p>
                    </div>
                    <div class="mb-3">
                        <strong>Tindakan/Solusi:</strong>
                        <p>{{ $konseling->tindakan_solusi }}</p>
                    </div>
                    @if($konseling->hasil_evaluasi)
                    <div class="mb-3">
                        <strong>Hasil Evaluasi:</strong>
                        <p>{{ $konseling->hasil_evaluasi }}</p>
                    </div>
                    @endif
                    @if($konseling->tanggal_tindak_lanjut)
                    <div class="mb-3">
                        <strong>Tanggal Tindak Lanjut:</strong>
                        <p>{{ \Carbon\Carbon::parse($konseling->tanggal_tindak_lanjut)->format('d/m/Y') }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('bk/konseling.js') }}" defer></script>
@endpush
