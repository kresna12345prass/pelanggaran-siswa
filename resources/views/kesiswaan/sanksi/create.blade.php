@extends('kesiswaan.layouts.app')
@section('title', 'Tetapkan Sanksi')

@push('styles')
    <link rel="stylesheet" href="{{ asset('kesiswaan/sanksi.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">⚖️ Tetapkan Sanksi</h3>
        <a href="{{ route('kesiswaan.sanksi.index') }}" class="btn btn-secondary btn-sm shadow-sm">
            <i class="fa-solid fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    {{-- Card 1: Daftar Siswa --}}
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 fw-bold text-dark"><i class="fa-solid fa-users-viewfinder me-2"></i> Pilih Siswa Bermasalah</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive p-2 p-md-3">
                {{-- Menggunakan ID tableSiswa dan class sanksi-table --}}
                <table class="table sanksi-table table-hover" id="tableSiswa" style="width:100%">
                    <thead>
                        <tr>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th class="text-center">Kelas</th>
                            <th class="text-center">Total Poin</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswas as $siswa)
                        <tr>
                            <td>{{ $siswa->nis }}</td>
                            <td><strong>{{ $siswa->nama_siswa }}</strong></td>
                            <td class="text-center">{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                            <td class="text-center"><span class="badge bg-danger">{{ $siswa->total_poin ?? 0 }} Poin</span></td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#sanksiModal{{ $siswa->id }}">
                                    <i class="fa-solid fa-gavel me-1"></i> Tetapkan
                                </button>
                            </td>
                        </tr>

                        <div class="modal fade" id="sanksiModal{{ $siswa->id }}">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form action="{{ route('kesiswaan.sanksi.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="pelanggaran_id" value="{{ $siswa->pelanggaran->sortByDesc('tanggal')->first()->id ?? '' }}">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title">Tetapkan Sanksi - {{ $siswa->nama_siswa }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body text-start">
                                            <div class="mb-3">
                                                <label class="form-label">Jenis Sanksi <span class="text-danger">*</span></label>
                                                <input type="text" name="jenis_sanksi" class="form-control" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Deskripsi Hukuman <span class="text-danger">*</span></label>
                                                <textarea name="deskripsi_hukuman" class="form-control" rows="4" required></textarea>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                                                        <input type="date" name="tanggal_mulai" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Tanggal Selesai</label>
                                                        <input type="date" name="tanggal_selesai" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Tidak ada siswa yang memerlukan sanksi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Card 2: Referensi Sanksi --}}
    <div class="card shadow-sm border-0">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 fw-bold text-dark"><i class="fa-solid fa-book-open me-2"></i> Referensi Sanksi Bertahap</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive p-2 p-md-3">
                {{-- Menggunakan ID tableReferensi dan class sanksi-table --}}
                <table class="table sanksi-table table-bordered table-hover" id="tableReferensi" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">Kategori</th>
                            <th>Nama Sanksi</th>
                            <th class="text-center">Range Poin</th>
                            <th>Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($masterSanksi as $ms)
                        <tr>
                            <td class="text-center">
                                <span class="badge bg-{{ $ms->kategori == 'RINGAN' ? 'success' : ($ms->kategori == 'SEDANG' ? 'warning' : 'danger') }}">
                                    {{ $ms->kategori }}
                                </span>
                            </td>
                            <td><strong>{{ $ms->nama_sanksi }}</strong></td>
                            <td class="text-center"><span class="badge bg-secondary">{{ $ms->poin_minimal }} - {{ $ms->poin_maksimal }}</span></td>
                            <td>{{ $ms->deskripsi_tindakan }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {{-- Gunakan Vite untuk JS --}}
    <script src="{{ asset('kesiswaan/sanksi.js') }}" defer></script>
@endpush