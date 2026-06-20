<!DOCTYPE html>
<html>
<head>
    <title>QR Kelas</title>

    <style>

        body{
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .card{
            border:1px solid #000;
            padding:15px;
            margin-bottom:20px;
            text-align:center;
        }

        .page-break{
            page-break-after: always;
        }

    </style>

</head>
<body>

@foreach($siswas as $siswa)

<div class="card">

    <h2>SDN PONDOK JAGUNG 05</h2>

    <p>
        <strong>Nama :</strong>
        {{ $siswa->nama }}
    </p>

    <p>
        <strong>NISN :</strong>
        {{ $siswa->nisn }}
    </p>

    <img
        src="data:image/svg+xml;base64,{{ $siswa->qrCode }}"
        width="180"
    >

    <p>
        <strong>Kelas :</strong>
        {{ $kelas->nama_kelas }}
    </p>

</div>

<div class="page-break"></div>

@endforeach

</body>
</html>