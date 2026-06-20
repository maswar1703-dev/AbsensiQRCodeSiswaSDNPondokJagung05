<!DOCTYPE html>
<html>
<head>
    <title>Laporan Absensi</title>

   <!DOCTYPE html>

<html>
<head>
    <title>Laporan Absensi</title>


<style>
    body{
        font-family: Arial, sans-serif;
        font-size: 12px;
    }

    table{
        width:100%;
        border-collapse: collapse;
    }

    th, td{
        border:1px solid #000;
        padding:5px;
    }

    th{
        background:#eee;
    }

    h2{
        margin-bottom:20px;
    }
</style>


</head>
<body>

<h2 align="center">
    LAPORAN ABSENSI SISWA
</h2>

<p>
    <strong>Tanggal :</strong>
    {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
</p>

<p>
    <strong>Kelas :</strong> {{ $namaKelas }}
</p>

<p>
    <strong>Bulan :</strong> {{ $bulan ?? '-' }}
</p>

<p>
    <strong>Tahun :</strong> {{ $tahun ?? '-' }}
</p>
@if($bulan)

<h3>Rekap Absensi Bulanan</h3>

<table>

    <thead>
        <tr>
            <th>NIS</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Hadir</th>
            <th>Sakit</th>
            <th>Izin</th>
        </tr>
    </thead>

    <tbody>

    @foreach($rekapBulanan as $rekap)

        <tr>
            <td>{{ $rekap['nis'] }}</td>
            <td>{{ $rekap['nama'] }}</td>
            <td>{{ $rekap['kelas'] }}</td>
            <td>{{ $rekap['hadir'] }}</td>
            <td>{{ $rekap['sakit'] }}</td>
            <td>{{ $rekap['izin'] }}</td>
        </tr>

    @endforeach

    </tbody>

</table>

@else

<table>

    <thead>
        <tr>
            <th>No</th>
            <th>NIS</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Tanggal</th>
            <th>Jam</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>

    @foreach($absensis as $item)

        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->siswa->nis ?? '-' }}</td>
            <td>{{ $item->siswa->nama ?? '-' }}</td>
            <td>{{ $item->siswa->kelas->nama_kelas ?? '-' }}</td>
            <td>{{ $item->tanggal }}</td>
            <td>{{ $item->jam }}</td>
            <td>{{ $item->status }}</td>
        </tr>

    @endforeach

    </tbody>

</table>

@endif
</body>
</html>
