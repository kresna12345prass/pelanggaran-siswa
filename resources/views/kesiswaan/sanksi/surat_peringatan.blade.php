<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Peringatan</title>
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
        hr { border: 1px solid #000; }
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
        <p style="text-align: center;"><strong><u>SURAT PERINGATAN</u></strong></p>
        <p style="text-align: center;">Nomor: {{ str_pad($sanksi->id, 4, '0', STR_PAD_LEFT) }}/SP/KESISWAAN/{{ date('Y') }}</p>

        <p>Yang bertanda tangan di bawah ini, Kepala Bagian Kesiswaan SMK Bakti Nusantara 666, memberikan surat peringatan kepada:</p>

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
            Berdasarkan catatan pelanggaran tata tertib sekolah, siswa yang bersangkutan telah melakukan pelanggaran sebagai berikut:
        </p>

        <table class="table">
            <tr>
                <td width="30%"><strong>Jenis Pelanggaran</strong></td>
                <td>{{ $sanksi->pelanggaran->jenisPelanggaran->nama_pelanggaran }}</td>
            </tr>
            <tr>
                <td><strong>Tanggal Pelanggaran</strong></td>
                <td>{{ \Carbon\Carbon::parse($sanksi->pelanggaran->tanggal)->format('d F Y') }}</td>
            </tr>
            <tr>
                <td><strong>Keterangan</strong></td>
                <td>{{ $sanksi->pelanggaran->keterangan ?? '-' }}</td>
            </tr>
        </table>

        <p style="text-align: justify;">
            Dengan ini kami memberikan <strong>SURAT PERINGATAN</strong> agar siswa yang bersangkutan:
        </p>

        <ol>
            <li>Tidak mengulangi pelanggaran yang sama</li>
            <li>Memperbaiki sikap dan perilaku</li>
            <li>Mematuhi seluruh tata tertib sekolah</li>
            <li>Menjadi teladan bagi siswa lainnya</li>
        </ol>

        <p style="text-align: justify;">
            Apabila siswa yang bersangkutan mengulangi pelanggaran, maka akan diberikan sanksi yang lebih berat 
            sesuai dengan peraturan tata tertib sekolah yang berlaku.
        </p>

        <p style="text-align: justify;">
            Demikian surat peringatan ini dibuat untuk dapat diperhatikan dan dilaksanakan dengan sebaik-baiknya.
        </p>
    </div>

    <div class="footer">
        <div class="signature">
            <p>Bandung, {{ \Carbon\Carbon::now()->format('d F Y') }}</p>
            <p>Kepala Bagian Kesiswaan</p>
            <br><br><br>
            <p><strong><u>{{ auth()->user()->nama_lengkap }}</u></strong></p>
        </div>
    </div>
</body>
</html>
