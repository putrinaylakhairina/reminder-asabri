<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Peserta - {{ $peserta->nama_peserta }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; font-size: 12px; }
        .container { width: 100%; margin: 0 auto; }
        .header { margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 15px; }
        .header-content { display: table; width: 100%; }
        .header img { display: table-cell; width: 80px; height: auto; vertical-align: middle; }
        .header .title { display: table-cell; vertical-align: middle; padding-left: 15px; text-align: center; width: 100%; }
        .header h1 { margin: 0; font-size: 20px; font-weight: bold; }
        .header p { margin: 3px 0 0; font-size: 14px; }
        .content { margin-top: 20px; }
        .profile-photo { float: right; width: 150px; height: auto; border: 1px solid #ddd; border-radius: 8px; margin-left: 20px; }
        .data-section { width: 70%; float: left; }
        .section-title { font-weight: bold; margin: 12px 0 6px; font-size: 13px; border-bottom: 1px solid #ccc; padding-bottom: 4px; }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table td { padding: 6px 0; border-bottom: 1px solid #eee; vertical-align: top; }
        .data-table td:first-child { font-weight: bold; width: 40%; }
        .clearfix::after { content: ""; clear: both; display: table; }
        .footer { text-align: center; margin-top: 40px; font-size: 10px; color: #777; }
        .tema-pidato { border-top: 1px solid #eee; padding-top: 15px; margin-top: 15px; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <div class="header-content">
            <img src="{{ public_path('daipolres.webp') }}" alt="Logo">
            <div class="title">
                <h1>FORMULIR PENDAFTARAN PESERTA</h1>
                <p>DUTA PELAJAR KAMTIBMAS DAN DA'I POLRI</p>
            </div>
        </div>
    </div>

    <div class="content clearfix">
        @if($peserta->foto_formal)
            <img src="{{ storage_path('app/public/' . $peserta->foto_formal) }}" alt="Foto Peserta" class="profile-photo">
        @endif

        <div class="data-section">

            <div class="section-title">Identitas Peserta</div>
            <table class="data-table">
                <tr><td>Nama Lengkap</td><td>: {{ $peserta->nama_peserta }}</td></tr>
                <tr><td>NISN</td><td>: {{ $peserta->user->nisn }}</td></tr>
                <tr><td>Tempat, Tanggal Lahir</td><td>: {{ $peserta->tempat_lahir }}, {{ \Carbon\Carbon::parse($peserta->tanggal_lahir)->isoFormat('D MMMM Y') }}</td></tr>
                <tr><td>Usia</td><td>: {{ $peserta->usia }} Tahun</td></tr>
                <tr><td>Jenis Kelamin</td><td>: {{ $peserta->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td></tr>
                <tr><td>Alamat</td><td>: {{ $peserta->alamat }}</td></tr>
                <tr><td>No. HP Peserta</td><td>: {{ $peserta->hp_peserta }}</td></tr>
            </table>

            <div class="section-title">Data Sekolah</div>
            <table class="data-table">
                <tr><td>Jenjang</td><td>: {{ $peserta->jenjang }}</td></tr>
                <tr><td>Kelas</td><td>: {{ $peserta->kelas }}</td></tr>
                <tr><td>Asal Sekolah</td><td>: {{ $peserta->user->asal_sekolah }}</td></tr>
            </table>

            <div class="section-title">Data Orang Tua & Official</div>
            <table class="data-table">
                <tr><td>Nama Orang Tua</td><td>: {{ $peserta->nama_ortu }}</td></tr>
                <tr><td>No. HP Orang Tua</td><td>: {{ $peserta->hp_ortu }}</td></tr>
                <tr><td>Nama Official</td><td>: {{ $peserta->nama_pengawas }}</td></tr>
                <tr><td>No. HP Official</td><td>: {{ $peserta->hp_pengawas }}</td></tr>
                        </table>
            
                        <div class="section-title">Jadwal Tampil</div>
                        <table class="data-table">
                            <tr><td>Nomor Urut</td><td>: {{ $peserta->nomor_urut ?? '-' }}</td></tr>
                            <tr><td>Tanggal Tampil</td><td>: {{ $peserta->tanggal_tampil ? \Carbon\Carbon::parse($peserta->tanggal_tampil)->isoFormat('dddd, D MMMM Y') : '-' }}</td></tr>
                            <tr><td>Tempat Tampil</td><td>: {{ $peserta->tempat_tampil ?? '-' }}</td></tr>
                        </table>
                    </div>
                </div>

    <div class="clearfix"></div>

    <div class="content tema-pidato">
        <div class="section-title">Tema Pidato Pilihan</div>
        <table class="data-table">
            <tr>
                <td style="font-weight: bold; vertical-align: top;">Tema</td>
                <td style="vertical-align: top;">: <div style="display: inline-block; white-space: pre-wrap;">{{ $peserta->tema_pidato }}</div></td>
            </tr>
        </table>
    </div>

    <div class="footer">
        Dicetak pada {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y, HH:mm:ss') }}
    </div>
</div>
</body>
</html>