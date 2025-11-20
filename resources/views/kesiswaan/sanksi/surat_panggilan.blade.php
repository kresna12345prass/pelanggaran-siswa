<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Panggilan Orang Tua</title>
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
        <p style="text-align: center;"><strong><u>SURAT PANGGILAN ORANG TUA/WALI</u></strong></p>
        <p style="text-align: center;">Nomor: {{ str_pad($sanksi->id, 4, '0', STR_PAD_LEFT) }}/KESISWAAN/{{ date('Y') }}</p>

        <p>Kepada Yth.<br>
        Orang Tua/Wali dari:<br>
        <strong>{{ $siswa->nama_siswa }}</strong><br>
        Kelas: <strong>{{ $siswa->kelas->nama_kelas ?? '-' }}</strong></p>

        <p>Dengan hormat,</p>

        <p style="text-align: justify;">
            Berdasarkan catatan pelanggaran tata tertib sekolah, dengan ini kami mengundang Bapak/Ibu untuk hadir 
            di sekolah guna membahas perilaku putra/putri Bapak/Ibu yang telah melakukan pelanggaran.
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
                <td><strong>Pelanggaran</strong></td>
                <td>{{ $sanksi->pelanggaran->jenisPelanggaran->nama_pelanggaran }}</td>
            </tr>
            <tr>
                <td><strong>Sanksi</strong></td>
                <td>{{ $sanksi->jenis_sanksi }}</td>
            </tr>
            <tr>
                <td><strong>Tanggal Panggilan</strong></td>
                <td>{{ \Carbon\Carbon::parse($sanksi->tanggal_mulai)->format('d F Y') }}</td>
            </tr>
        </table>

        <p style="text-align: justify;">
            Demikian surat panggilan ini kami sampaikan. Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.
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
