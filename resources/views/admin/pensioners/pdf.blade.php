<!DOCTYPE html>
<html>
<head>
    <title>Data Pensiunan ASABRI</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h1 { text-align: center; color: #333; }
        .status { padding: 4px 8px; border-radius: 4px; font-size: 12px; }
        .red { background-color: #fee2e2; color: #991b1b; }
        .yellow { background-color: #fef9c3; color: #854d0e; }
        .green { background-color: #dcfce7; color: #166534; }
    </style>
</head>
<body>
    <h1>Data Pensiunan ASABRI</h1>
    <p>Tanggal Cetak: {{ now()->format('d F Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>NIP</th>
                <th>Instansi</th>
                <th>Gaji Pensiun</th>
                <th>Jatuh Tempo</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pensioners as $pensioner)
                <tr>
                    <td>{{ $pensioner->nama }}</td>
                    <td>{{ $pensioner->nip }}</td>
                    <td>{{ $pensioner->instansi }}</td>
                    <td>Rp {{ number_format($pensioner->gaji_pensiun, 0, ',', '.') }}</td>
                    <td>{{ $pensioner->tanggal_jatuh_tempo->format('d/m/Y') }}</td>
                    <td>
                        <span class="status {{ $pensioner->status_color }}">
                            {{ $pensioner->status_label }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
