<!DOCTYPE html>
<html>
<head>
    <title>QR Siswa</title>

    <style>

        body{
            text-align:center;
            font-family:Arial, sans-serif;
            padding-top:50px;
        }

        .nama{
            font-size:28px;
            font-weight:bold;
            margin-bottom:10px;
        }

        .kelas{
            font-size:20px;
            margin-bottom:20px;
        }

        .nis{
            margin-top:20px;
            font-size:18px;
        }

    </style>

</head>
<body>

    <div class="nama">
        {{ $siswa->nama }}
    </div>

    <div class="kelas">
        Kelas {{ $siswa->kelas->nama_kelas }}
    </div>

    <img
        src="data:image/svg+xml;base64,{{ $qrCode }}"
        width="250"
    >

    <div class="nis">
        NIS : {{ $siswa->nis }}
    </div>

</body>
</html>