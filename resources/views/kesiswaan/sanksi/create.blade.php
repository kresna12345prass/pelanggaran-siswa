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

    {{-- Form Tambah Sanksi Manual --}}
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 fw-bold text-dark"><i class="fa-solid fa-gavel me-2"></i> Form Tambah Sanksi Manual</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('kesiswaan.sanksi.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Pilih Siswa <span class="text-danger">*</span></label>
                            <select name="siswa_id" id="siswa_id" class="form-select" required>
                                <option value="">-- Pilih Siswa --</option>
                                @foreach($siswa as $s)
                                    <option value="{{ $s->id }}">{{ $s->nis }} - {{ $s->nama_siswa }} ({{ $s->kelas->nama_kelas ?? '-' }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Info Siswa</label>
                            <div class="alert alert-info mb-0" id="siswaInfo">
                                <small>Pilih siswa untuk melihat info</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kategori Sanksi <span class="text-danger">*</span></label>
                    <select name="kategori_sanksi_id" id="kategori_sanksi_id" class="form-select" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoriSanksi as $ks)
                            <option value="{{ $ks->id }}" data-deskripsi="{{ $ks->deskripsi_sanksi }}">
                                {{ $ks->kategori }} ({{ $ks->pasal }}) - {{ $ks->poin_min }}-{{ $ks->poin_max }} Poin
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Sanksi <span class="text-danger">*</span></label>
                    <input type="text" name="jenis_sanksi" id="jenis_sanksi" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi Hukuman <span class="text-danger">*</span></label>
                    <textarea name="deskripsi_hukuman" id="deskripsi_hukuman" class="form-control" rows="5" required></textarea>
                    <small class="text-muted">Deskripsi akan otomatis terisi sesuai kategori sanksi yang dipilih</small>
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

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-save me-1"></i> Simpan Sanksi
                    </button>
                    <a href="{{ route('kesiswaan.sanksi.index') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-times me-1"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Card 2: Referensi Sanksi --}}
    <div class="card shadow-sm border-0">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 fw-bold text-dark"><i class="fa-solid fa-book-open me-2"></i> Referensi Kategori Sanksi</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive p-2 p-md-3">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">Kategori</th>
                            <th class="text-center">Pasal</th>
                            <th class="text-center">Range Poin</th>
                            <th>Deskripsi Sanksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kategoriSanksi as $ks)
                        <tr>
                            <td class="text-center">
                                <span class="badge bg-{{ $ks->kategori == 'Ringan' ? 'success' : ($ks->kategori == 'Sedang' ? 'warning' : 'danger') }}">
                                    {{ $ks->kategori }}
                                </span>
                            </td>
                            <td class="text-center"><strong>{{ $ks->pasal }}</strong></td>
                            <td class="text-center"><span class="badge bg-secondary">{{ $ks->poin_min }} - {{ $ks->poin_max }}</span></td>
                            <td style="white-space: pre-line;">{{ $ks->deskripsi_sanksi }}</td>
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
// Auto-fill info siswa
document.getElementById('siswa_id').addEventListener('change', function() {
    const siswaId = this.value;
    if (siswaId) {
        fetch(`/kesiswaan/sanksi/siswa-info/${siswaId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('siswaInfo').innerHTML = `
                    <strong>${data.nama}</strong><br>
                    <small>Kelas: ${data.kelas} | Total Poin: <span class="badge bg-danger">${data.total_poin}</span></small>
                `;
            });
    }
});

// Auto-fill deskripsi sanksi
document.getElementById('kategori_sanksi_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const deskripsi = selectedOption.getAttribute('data-deskripsi');
    const kategori = selectedOption.text.split(' ')[0];
    const pasal = selectedOption.text.match(/\(([^)]+)\)/)[1];
    
    if (deskripsi) {
        document.getElementById('jenis_sanksi').value = `Sanksi ${kategori} - ${pasal}`;
        document.getElementById('deskripsi_hukuman').value = deskripsi;
    }
});
</script>
@endpush
