<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pelanggaran - {{ $pelanggaran->siswa->nama_siswa }}</title>
    <style>
        body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 12px; margin: 20px; line-height: 1.4; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 15px; }
        .title { font-size: 18px; font-weight: bold; margin-bottom: 5px; color: #333; }
        .subtitle { font-size: 14px; margin-bottom: 20px; color: #666; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .info-table td { padding: 10px; border: 1px solid #333; vertical-align: top; }
        .label { font-weight: bold; background-color: #f0f0f0; width: 35%; }
        .footer { margin-top: 40px; text-align: right; }
        .signature { margin-top: 60px; text-align: center; }
        .date-print { font-size: 10px; color: #666; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">LAPORAN PELANGGARAN SISWA</div>
        <div class="subtitle">Tahun Ajaran {{ $pelanggaran->tahunAjaran->tahun_ajaran ?? '-' }}</div>
    </div>

    <table class="info-table">
        <tr>
            <td class="label">Nama Siswa</td>
            <td>{{ $pelanggaran->siswa->nama_siswa }}</td>
        </tr>
        <tr>
            <td class="label">NIS</td>
            <td>{{ $pelanggaran->siswa->nis }}</td>
        </tr>
        <tr>
            <td class="label">Kelas</td>
            <td>{{ $pelanggaran->siswa->kelas->nama_kelas ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Jenis Pelanggaran</td>
            <td>{{ $pelanggaran->jenisPelanggaran->nama_pelanggaran }}</td>
        </tr>
        <tr>
            <td class="label">Poin Pelanggaran</td>
            <td>{{ $pelanggaran->poin }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal Pelanggaran</td>
            <td>{{ \Carbon\Carbon::parse($pelanggaran->tanggal)->format('d F Y') }}</td>
        </tr>
        <tr>
            <td class="label">Keterangan</td>
            <td>{{ $pelanggaran->keterangan ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Status Verifikasi</td>
            <td>{{ ucfirst($pelanggaran->status_verifikasi) }}</td>
        </tr>
        <tr>
            <td class="label">Pencatat</td>
            <td>{{ $pelanggaran->pencatat->name ?? '-' }}</td>
        </tr>
    </table>

    @if($pelanggaran->foto_bukti)
    <div style="margin: 20px 0;">
        <p style="font-weight: bold; margin-bottom: 10px;">Foto Bukti Pelanggaran: Tersedia (lihat di sistem)</p>
    </div>
    @endif

    <div class="date-print">
        Dicetak pada: {{ \Carbon\Carbon::now()->format('d F Y H:i') }}
    </div>
    
    <div class="footer">
        <div class="signature">
            <div style="margin-bottom: 10px;">Mengetahui,</div>
            <div style="margin-bottom: 5px;"><strong>Bagian Kesiswaan</strong></div>
            <br><br><br>
            <div style="border-top: 1px solid #333; width: 200px; margin: 0 auto; padding-top: 5px;">
                Nama & Tanda Tangan
            </div>
        </div>
    </div>
</body>
</html>
