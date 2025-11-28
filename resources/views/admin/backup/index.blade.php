@extends('admin.layouts.app')

@section('title', 'Backup Database')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/backup.css') }}">
@endpush

@section('content')
    
    <div class="mb-4">
        <h1 class="h3 mb-1 text-gray-800">Backup & Restore Database</h1>
        <p class="text-muted mb-0 small">Kelola backup database sistem</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm mb-4 border-0">
        <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-dark"><i class="fa-solid fa-history me-2"></i>Riwayat Backup</h6>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.backup.export') }}" class="btn btn-success btn-sm shadow-sm">
                    <i class="fa-solid fa-file-excel me-2"></i>
                    <span class="d-none d-sm-inline">Export Excel</span>
                    <span class="d-inline d-sm-none">Excel</span>
                </a>
                <form action="{{ route('admin.backup.store') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-sm shadow-sm">
                        <i class="fa-solid fa-database me-2"></i>
                        <span class="d-none d-sm-inline">Buat Backup Baru</span>
                        <span class="d-inline d-sm-none">Backup</span>
                    </button>
                </form>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive p-2 p-md-3">
                
                <table class="table backup-table table-hover" id="backupTable" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 5%;">No.</th>
                            <th style="width: 35%;">Nama File</th>
                            <th style="width: 15%;">Ukuran</th>
                            <th style="width: 25%;">Tanggal Backup</th>
                            <th class="text-center" style="width: 20%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($backups as $index => $backup)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>
                                    <i class="fa-solid fa-file-code text-muted me-2"></i>
                                    <strong>{{ $backup['filename'] }}</strong>
                                </td>
                                <td><span class="badge bg-info">{{ $backup['size'] }}</span></td>
                                <td>{{ $backup['created_at']->format('d M Y, H:i:s') }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.backup.download', ['filename' => $backup['filename']]) }}" class="btn btn-success btn-sm" title="Download SQL">
                                            <i class="fa-solid fa-download"></i>
                                        </a>
                                        
                                        <button class="btn btn-danger btn-sm" 
                                                title="Hapus" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteBackupModal"
                                                data-backup-name="{{ $backup['filename'] }}"
                                                data-delete-url="{{ route('admin.backup.destroy', ['filename' => $backup['filename']]) }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada file backup ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="alert alert-info">
        <i class="fa-solid fa-info-circle me-2"></i>
        <strong>Catatan:</strong> 
        <ul class="mb-0 mt-2">
            <li>Untuk melakukan <em>Restore</em>, download file .sql dan import melalui <strong>phpMyAdmin</strong></li>
            <li>Backup dilakukan secara otomatis dengan <code>--single-transaction</code> untuk konsistensi data</li>
            <li>File backup disimpan di <code>storage/app/backups/</code></li>
            <li>Pastikan ruang disk cukup sebelum membuat backup</li>
        </ul>
    </div>

    <div class="modal fade" id="deleteBackupModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Hapus Backup</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="modal-body-text">Apakah Anda yakin ingin menghapus backup ini? Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteBackupForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('admin/backup.js') }}" defer></script>
@endpush
