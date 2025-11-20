<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Skorsing</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12pt; line-height: 1.6; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h2 { margin: 5px 0; }
        .header p { margin: 2px 0; font-size: 10pt; }
        .content { margin: 20px 0; }
        .content p { margin: 10px 0; }
        .table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .table td { padding: 8px; border: 1px solid #000; }
        .footer { margin-top: 50px; }
        .signature { float: right; text-align: center; width: 200px; }
        .signature-left { float: left; text-align: center; width: 200px; }
        hr { border: 1px solid #000; }
        .warning { background-color: #fff3cd; padding: 10px; border-left: 4px solid #ffc107; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="header">
        <h2>SMK BAKTI NUSANTARA 666</h2>
        <p>Jl. Pendidikan No. 123, Kota Bandung</p>
        <p>Telp: (022) 1234567 | Email: info@smkbn666.sch.id</p>
        <hr>
    </div>

    <div class="content">
        <p style="text-align: center;"><strong><u>SURAT KEPUTUSAN SKORSING</u></strong></p>
        <p style="text-align: center;">Nomor: {{ str_pad($sanksi->id, 4, '0', STR_PAD_LEFT) }}/SK-SKORSING/{{ date('Y') }}</p>

        <p><strong>MEMUTUSKAN:</strong></p>

        <p>Menetapkan:</p>

        <table class="table">
            <tr>
                <td width="30%"><strong>Nama Siswa</strong></td>
                <td>{{ $siswa->nama_siswa }}</td>
            </tr>
            <tr>
                <td><strong>NIS</strong></td>
                <td>{{ $siswa->nis }}</td>
            </tr>
            <tr>
                <td><strong>Kelas</strong></td>
                <td>{{ $siswa->kelas->nama_kelas ?? '-' }} / {{ $siswa->kelas->jurusan->nama_jurusan ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Pelanggaran</strong></td>
                <td>{{ $sanksi->pelanggaran->jenisPelanggaran->nama_pelanggaran }}</td>
            </tr>
            <tr>
                <td><strong>Jenis Sanksi</strong></td>
                <td><strong>{{ $sanksi->jenis_sanksi }}</strong></td>
            </tr>
            <tr>
                <td><strong>Periode Skorsing</strong></td>
                <td>
                    {{ \Carbon\Carbon::parse($sanksi->tanggal_mulai)->format('d F Y') }}
                    @if($sanksi->tanggal_selesai)
                        s/d {{ \Carbon\Carbon::parse($sanksi->tanggal_selesai)->format('d F Y') }}
                    @endif
                </td>
            </tr>
        </table>

        <div class="warning">
            <strong>CATATAN PENTING:</strong>
            <p style="margin: 5px 0;">{{ $sanksi->deskripsi_hukuman }}</p>
        </div>

        <p style="text-align: justify;">
            Selama masa skorsing, siswa yang bersangkutan <strong>TIDAK DIPERKENANKAN</strong> mengikuti kegiatan 
            belajar mengajar di sekolah. Siswa wajib melaporkan diri kepada Bagian Kesiswaan setelah masa skorsing berakhir.
        </p>

        <p style="text-align: justify;">
            Demikian surat keputusan ini dibuat untuk dilaksanakan dengan sebaik-baiknya.
        </p>
    </div>

    <div class="footer">
        <div class="signature-left">
            <p>Mengetahui,</p>
            <p>Kepala Sekolah</p>
            <br><br><br>
            <p><strong><u>_________________</u></strong></p>
        </div>
        <div class="signature">
            <p>Bandung, {{ \Carbon\Carbon::now()->format('d F Y') }}</p>
            <p>Kepala Bagian Kesiswaan</p>
            <br><br><br>
            <p><strong><u>{{ auth()->user()->nama_lengkap }}</u></strong></p>
        </div>
    </div>
</body>
</html>
