@extends('layouts.app')

@section('content')

<div class="container">


@if(session('success'))

    <div class="alert alert-success">
        {{ session('success') }}
    </div>

@endif

<div class="card shadow p-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2>Laporan Absensi Harian</h2>

            <small class="text-muted">
                Tanggal :
                {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
            </small>
        </div>

        <a href="/scan" class="btn btn-primary">
            Scan Lagi
        </a>

    </div>

    <div class="row mb-4">

        <div class="col-md-4">

            <div class="card bg-primary text-white">

                <div class="card-body">

                    <h5>Total Absensi Hari Ini</h5>

                    <h2>{{ $absensis->count() }}</h2>

                </div>

            </div>

        </div>

    </div>

   {{-- FILTER DATA --}}
<form action="{{ route('laporan') }}" method="GET" class="mb-4">

    <div class="row g-2">

        <div class="col-md-2">
            <select name="bulan" class="form-control">
                <option value="">Pilih Bulan</option>

                <option value="1" {{ request('bulan') == 1 ? 'selected' : '' }}>Januari</option>
                <option value="2" {{ request('bulan') == 2 ? 'selected' : '' }}>Februari</option>
                <option value="3" {{ request('bulan') == 3 ? 'selected' : '' }}>Maret</option>
                <option value="4" {{ request('bulan') == 4 ? 'selected' : '' }}>April</option>
                <option value="5" {{ request('bulan') == 5 ? 'selected' : '' }}>Mei</option>
                <option value="6" {{ request('bulan') == 6 ? 'selected' : '' }}>Juni</option>
                <option value="7" {{ request('bulan') == 7 ? 'selected' : '' }}>Juli</option>
                <option value="8" {{ request('bulan') == 8 ? 'selected' : '' }}>Agustus</option>
                <option value="9" {{ request('bulan') == 9 ? 'selected' : '' }}>September</option>
                <option value="10" {{ request('bulan') == 10 ? 'selected' : '' }}>Oktober</option>
                <option value="11" {{ request('bulan') == 11 ? 'selected' : '' }}>November</option>
                <option value="12" {{ request('bulan') == 12 ? 'selected' : '' }}>Desember</option>
            </select>
        </div>

        <div class="col-md-2">
            <input
                type="number"
                name="tahun"
                class="form-control"
                value="{{ request('tahun', date('Y')) }}"
            >
        </div>

        <div class="col-md-2">
            <select name="kelas" class="form-control">

                <option value="">Semua Kelas</option>

                @foreach($kelasList as $k)
                <option
                    value="{{ $k->id }}"
                    {{ request('kelas') == $k->id ? 'selected' : '' }}
                >
                    {{ $k->nama_kelas }}
                </option>
                @endforeach

            </select>
        </div>

        <div class="col-md-2">
            <input
                type="date"
                name="tanggal"
                class="form-control"
                value="{{ request('tanggal') }}"
            >
        </div>

        <div class="col-md-2">
            <button class="btn btn-success w-100">
                Lihat Data
            </button>
        </div>

        <div class="col-md-1">
            <a href="{{ route('absensi.sakit') }}"
               class="btn btn-warning w-100">
                Sakit
            </a>
        </div>

        <div class="col-md-1">
            <a href="{{ route('absensi.izin') }}"
               class="btn btn-info text-white w-100">
                Izin
            </a>
        </div>

    </div>

</form>

    {{-- CETAK PDF --}}
    <form action="{{ route('laporan.pdf') }}" method="GET" class="mb-4">

        <input type="hidden" name="bulan" value="{{ request('bulan') }}">
        <input type="hidden" name="tahun" value="{{ request('tahun') }}">
        <input type="hidden" name="kelas" value="{{ request('kelas') }}">

        <button class="btn btn-danger">
            Cetak Laporan PDF
        </button>

    </form>

    @if(request('bulan'))

<div class="card shadow mb-4">

    <div class="card-header bg-success text-white">
        Rekap Absensi Bulanan
    </div>

    <div class="card-body">

        <table class="table table-bordered">

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

                    <td>
                        <span class="badge bg-success">
                            {{ $rekap['hadir'] }}
                        </span>
                    </td>

                    <td>
                        <span class="badge bg-warning text-dark">
                            {{ $rekap['sakit'] }}
                        </span>
                    </td>

                    <td>
                        <span class="badge bg-info">
                            {{ $rekap['izin'] }}
                        </span>
                    </td>

                </tr>

            @endforeach

            </tbody>

        </table>

    </div>

</div>

@endif

    <table class="table table-bordered table-striped">

        <thead class="table-dark">

            <tr>

                <th>No</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Status</th>

                @if(Auth::user()->role == 'admin')
                <th>Aksi</th>
                @endif

            </tr>

        </thead>

        <tbody>

            @forelse($absensis as $item)

            <tr>

                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->siswa->nis ?? '-' }}</td>
                <td>{{ $item->siswa->nama ?? '-' }}</td>
                <td>{{ $item->siswa->kelas->nama_kelas ?? '-' }}</td>
                <td>{{ $item->tanggal }}</td>
                <td>{{ $item->jam }}</td>

                <td>

    @if($item->status == 'hadir')

        <span class="badge bg-success">
            Hadir
        </span>

    @elseif($item->status == 'sakit')

        <span class="badge bg-warning text-dark">
            Sakit
        </span>

    @elseif($item->status == 'izin')

        <span class="badge bg-info text-white">
            Izin
        </span>

    @else

        <span class="badge bg-secondary">
            {{ $item->status }}
        </span>

    @endif

</td>

                @if(Auth::user()->role == 'admin')
                <td>

                    <form
                        action="{{ route('laporan.destroy', $item->id) }}"
                        method="POST"
                    >

                        @csrf
                        @method('DELETE')

                        <button
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Hapus data absensi?')"
                        >
                            Hapus
                        </button>

                    </form>

                </td>
                @endif

            </tr>

            @empty

            <tr>

                <td colspan="8" class="text-center">
                    Tidak ada data absensi
                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

</div>


</div>

@endsection
