<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Berita Acara Pelaksanaan Sanksi</title>
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
        .signature { display: inline-block; text-align: center; width: 45%; vertical-align: top; }
        .signature-left { float: left; }
        .signature-right { float: right; }
        hr { border: 1px solid #000; }
        .badge { display: inline-block; padding: 5px 10px; background: #dc3545; color: white; border-radius: 3px; }
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
        <p style="text-align: center;"><strong><u>BERITA ACARA PELAKSANAAN SANKSI</u></strong></p>
        <p style="text-align: center;">Nomor: {{ str_pad($pelaksanaan->id, 4, '0', STR_PAD_LEFT) }}/BA-PS/KESISWAAN/{{ date('Y') }}</p>

        <p style="text-align: justify;">
            Pada hari ini, <strong>{{ \Carbon\Carbon::parse($pelaksanaan->tanggal_pelaksanaan)->locale('id')->isoFormat('dddd, D MMMM Y') }}</strong>, 
            telah dilaksanakan sanksi terhadap siswa dengan identitas sebagai berikut:
        </p>

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
                <td>{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Jurusan</strong></td>
                <td>{{ $siswa->kelas->jurusan->nama_jurusan ?? '-' }}</td>
            </tr>
        </table>

        <p style="text-align: justify;">
            Sanksi diberikan berdasarkan pelanggaran tata tertib sekolah dengan rincian sebagai berikut:
        </p>

        <table class="table">
            <tr>
                <td width="30%"><strong>Jenis Pelanggaran</strong></td>
                <td>{{ $pelaksanaan->dataSanksi->pelanggaran->jenisPelanggaran->nama_pelanggaran }}</td>
            </tr>
            <tr>
                <td><strong>Poin Pelanggaran</strong></td>
                <td><span class="badge">{{ $pelaksanaan->dataSanksi->pelanggaran->poin }} Poin</span></td>
            </tr>
            <tr>
                <td><strong>Tanggal Pelanggaran</strong></td>
                <td>{{ \Carbon\Carbon::parse($pelaksanaan->dataSanksi->pelanggaran->tanggal)->format('d F Y') }}</td>
            </tr>
        </table>

        <p style="text-align: justify;">
            Sanksi yang telah ditetapkan dan dilaksanakan:
        </p>

        <table class="table">
            <tr>
                <td width="30%"><strong>Jenis Sanksi</strong></td>
                <td>{{ $pelaksanaan->dataSanksi->jenis_sanksi }}</td>
            </tr>
            <tr>
                <td><strong>Deskripsi Sanksi</strong></td>
                <td>{{ $pelaksanaan->dataSanksi->deskripsi_hukuman }}</td>
            </tr>
            <tr>
                <td><strong>Periode Sanksi</strong></td>
                <td>
                    {{ \Carbon\Carbon::parse($pelaksanaan->dataSanksi->tanggal_mulai)->format('d F Y') }}
                    @if($pelaksanaan->dataSanksi->tanggal_selesai)
                        s/d {{ \Carbon\Carbon::parse($pelaksanaan->dataSanksi->tanggal_selesai)->format('d F Y') }}
                    @endif
                </td>
            </tr>
            <tr>
                <td><strong>Tanggal Pelaksanaan</strong></td>
                <td>{{ \Carbon\Carbon::parse($pelaksanaan->tanggal_pelaksanaan)->format('d F Y, H:i') }} WIB</td>
            </tr>
            <tr>
                <td><strong>Status Pelaksanaan</strong></td>
                <td><strong>{{ strtoupper($pelaksanaan->status) }}</strong></td>
            </tr>
        </table>

        @if($pelaksanaan->catatan)
        <p style="text-align: justify;">
            <strong>Catatan Pelaksanaan:</strong><br>
            {{ $pelaksanaan->catatan }}
        </p>
        @endif

        @if($pelaksanaan->bukti_foto)
        <div style="margin: 20px 0; text-align: center;">
            <p><strong>Bukti Foto Pelaksanaan Sanksi:</strong></p>
            <img src="{{ public_path('storage/' . $pelaksanaan->bukti_foto) }}" style="max-width: 400px; max-height: 300px; border: 1px solid #000;">
        </div>
        @endif

        <p style="text-align: justify;">
            Demikian berita acara ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.
        </p>
    </div>

    <div class="footer">
        <div class="signature signature-left">
            <p>Mengetahui,<br>Siswa Yang Bersangkutan</p>
            <br><br><br>
            <p><strong><u>{{ $siswa->nama_siswa }}</u></strong></p>
        </div>
        <div class="signature signature-right">
            <p>Bandung, {{ \Carbon\Carbon::now()->format('d F Y') }}<br>Kepala Bagian Kesiswaan</p>
            <br><br><br>
            <p><strong><u>{{ auth()->user()->nama_lengkap }}</u></strong></p>
        </div>
    </div>
</body>
</html>
