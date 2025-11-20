@extends('kesiswaan.layouts.app')
@section('title', 'Tambah Pelanggaran')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">➕ Tambah Pelanggaran</h3>
        <a href="{{ route('kesiswaan.pelanggaran.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('kesiswaan.pelanggaran.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Siswa <span class="text-danger">*</span></label>
                            <select name="siswa_id" class="form-select @error('siswa_id') is-invalid @enderror" required>
                                <option value="">Pilih Siswa</option>
                                @foreach($siswas as $siswa)
                                    <option value="{{ $siswa->id }}" {{ old('siswa_id') == $siswa->id ? 'selected' : '' }}>
                                        {{ $siswa->nama_siswa }} - {{ $siswa->kelas->nama_kelas ?? '-' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('siswa_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', now()->format('Y-m-d\TH:i')) }}" required>
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Pelanggaran <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="jenis_pelanggaran_nama" readonly placeholder="-- Pilih Jenis Pelanggaran --">
                        <input type="hidden" name="jenis_pelanggaran_id" id="jenis_pelanggaran_id" value="{{ old('jenis_pelanggaran_id') }}">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalJenisPelanggaran">
                            <i class="fa-solid fa-search"></i>
                        </button>
                    </div>
                    <small class="text-muted">Poin: <span id="poinDisplay">0</span></small>
                    @error('jenis_pelanggaran_id')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="3" placeholder="Deskripsi detail pelanggaran...">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Foto Bukti (Opsional)</label>
                    <input type="file" name="foto_bukti" class="form-control @error('foto_bukti') is-invalid @enderror" accept="image/*">
                    <small class="text-muted">Max 2MB</small>
                    @error('foto_bukti')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-save"></i> Simpan
                    </button>
                    <a href="{{ route('kesiswaan.pelanggaran.index') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Pilih Jenis Pelanggaran -->
<div class="modal fade" id="modalJenisPelanggaran" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa-solid fa-exclamation-triangle me-2"></i>Pilih Jenis Pelanggaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="filterPelanggaran" placeholder="🔍 Cari pelanggaran...">
                        </div>
                        <div class="col-md-6">
                            <select class="form-select" id="filterKategori">
                                <option value="">Semua Kategori</option>
                                @foreach($jenisPelanggarans->groupBy('kategoriPelanggaran.nama_kategori') as $kategori => $items)
                                    <option value="{{ $kategori }}">{{ $kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <table class="table table-hover" id="tablePelanggaran">
                    <thead>
                        <tr>
                            <th>Kategori</th>
                            <th>Nama Pelanggaran</th>
                            <th>Poin</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jenisPelanggarans as $jp)
                        <tr data-kategori="{{ $jp->kategoriPelanggaran->nama_kategori }}" data-nama="{{ strtolower($jp->nama_pelanggaran) }}">
                            <td><span class="badge bg-secondary">{{ $jp->kategoriPelanggaran->nama_kategori }}</span></td>
                            <td>{{ $jp->nama_pelanggaran }}</td>
                            <td><span class="badge bg-danger">{{ $jp->poin }}</span></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-success pilih-pelanggaran" 
                                        data-id="{{ $jp->id }}" 
                                        data-nama="{{ $jp->nama_pelanggaran }}"
                                        data-poin="{{ $jp->poin }}"
                                        onclick="pilihPelanggaran(this)">
                                    <i class="fa-solid fa-check"></i> Pilih
                                </button>
                            </td>
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('modalJenisPelanggaran');
    const filterPelanggaran = document.getElementById('filterPelanggaran');
    const filterKategori = document.getElementById('filterKategori');
    const tableRows = document.querySelectorAll('#tablePelanggaran tbody tr');
    
    // Filter function
    function filterTable() {
        const searchText = filterPelanggaran.value.toLowerCase();
        const selectedKategori = filterKategori.value;
        
        tableRows.forEach(row => {
            const nama = row.dataset.nama;
            const kategori = row.dataset.kategori;
            
            const matchesSearch = nama.includes(searchText);
            const matchesKategori = !selectedKategori || kategori === selectedKategori;
            
            row.style.display = matchesSearch && matchesKategori ? '' : 'none';
        });
    }
    
    // Event listeners for filters
    filterPelanggaran.addEventListener('input', filterTable);
    filterKategori.addEventListener('change', filterTable);
    
    // Clear filters when modal opens
    modal.addEventListener('show.bs.modal', function() {
        filterPelanggaran.value = '';
        filterKategori.value = '';
        filterTable();
    });
    
    // Handle pelanggaran selection
    document.addEventListener('click', function(e) {
        if (e.target.closest('.pilih-pelanggaran')) {
            e.preventDefault();
            const btn = e.target.closest('.pilih-pelanggaran');
            document.getElementById('jenis_pelanggaran_id').value = btn.dataset.id;
            document.getElementById('jenis_pelanggaran_nama').value = btn.dataset.nama;
            document.getElementById('poinDisplay').textContent = btn.dataset.poin;
            
            const modalInstance = bootstrap.Modal.getInstance(modal) || new bootstrap.Modal(modal);
            modalInstance.hide();
        }
    });
});

// Function to handle pelanggaran selection
function pilihPelanggaran(btn) {
    document.getElementById('jenis_pelanggaran_id').value = btn.dataset.id;
    document.getElementById('jenis_pelanggaran_nama').value = btn.dataset.nama;
    document.getElementById('poinDisplay').textContent = btn.dataset.poin;
    
    const modal = document.getElementById('modalJenisPelanggaran');
    const modalInstance = bootstrap.Modal.getInstance(modal);
    if (modalInstance) {
        modalInstance.hide();
    }
}
</script>
@endpush
