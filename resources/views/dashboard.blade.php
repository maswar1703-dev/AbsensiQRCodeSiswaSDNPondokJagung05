@extends('layouts.app')

@section('content')

@php
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Absensi;
@endphp

<div class="card border-0 shadow-sm p-5">

```
<div class="text-center">

    <img src="{{ asset('logo.png') }}" width="220">

    <h1 class="fw-bold text-primary mt-4">
        Sistem Absensi Siswa
    </h1>

    <h2>
        SDN Pondok Jagung 05
    </h2>

    <p class="text-muted">
        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
    </p>

    <hr class="my-4">

</div>

<div class="row">

    <div class="col-md-4 mb-3">
        <div class="card bg-primary text-white border-0 shadow">
            <div class="card-body text-center">
                <h4>Total Siswa</h4>
                <h1>{{ Siswa::count() }}</h1>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card bg-success text-white border-0 shadow">
            <div class="card-body text-center">
                <h4>Total Kelas</h4>
                <h1>{{ Kelas::count() }}</h1>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card bg-warning border-0 shadow">
            <div class="card-body text-center">
                <h4>Absensi Hari Ini</h4>
                <h1>
                    {{ Absensi::whereDate('tanggal', date('Y-m-d'))->count() }}
                </h1>
            </div>
        </div>
    </div>

</div>
```

</div>

@endsection
