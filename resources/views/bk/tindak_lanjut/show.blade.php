@extends('bk.layouts.app')

@section('title', 'Detail Tindak Lanjut')

@push('styles')
    @vite('resources/css/bk/tindak_lanjut.css')
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Tindak Lanjut</h1>
        <div>
            <a href="{{ route('bk.tindak_lanjut.edit', $konseling->id) }}" class="btn btn-warning">
                <i class="fa-solid fa-edit"></i> Update
            </a>
            <a href="{{ route('bk.tindak_lanjut.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Informasi Konseling</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Siswa:</strong> {{ $konseling->siswa->nama_siswa }}</p>
                    <p><strong>Kelas:</strong> {{ $konseling->siswa->kelas->nama_kelas ?? '-' }}</p>
                    <p><strong>Tanggal Konseling:</strong> {{ \Carbon\Carbon::parse($konseling->tanggal_konseling)->format('d/m/Y') }}</p>
                    <p><strong>Topik:</strong> {{ $konseling->topik }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Status:</strong> 
                        <span class="badge bg-info">{{ ucfirst($konseling->status) }}</span>
                    </p>
                    <p><strong>Tanggal Tindak Lanjut:</strong> 
                        @if($konseling->tanggal_tindak_lanjut)
                            {{ \Carbon\Carbon::parse($konseling->tanggal_tindak_lanjut)->format('d/m/Y') }}
                        @else
                            <span class="badge bg-warning">Belum dijadwalkan</span>
                        @endif
                    </p>
                </div>
            </div>
            <hr>
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
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/bk/tindak_lanjut.js')
@endpush
