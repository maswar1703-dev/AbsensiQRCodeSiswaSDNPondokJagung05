<!DOCTYPE html>
<html>
<head>
    <title>Data Kelas</title>

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
            padding:8px;
        }

        th{
            background:#eeeeee;
        }
    </style>

</head>
<body>

<h2 align="center">
    DATA KELAS SDN PONDOK JAGUNG 05
</h2>

<table>

    <thead>

        <tr>
            <th>No</th>
            <th>Nama Kelas</th>
            <th>Jumlah Siswa</th>
        </tr>

    </thead>

    <tbody>

        @foreach($kelas as $item)

        <tr>

            <td>{{ $loop->iteration }}</td>

            <td>{{ $item->nama_kelas }}</td>

            <td>{{ $item->siswa_count }}</td>

        </tr>

        @endforeach

    </tbody>

</table>

</body>
</html>