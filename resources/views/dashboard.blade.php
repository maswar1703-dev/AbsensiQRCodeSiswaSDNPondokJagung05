@extends('layouts.app')

@section('content')

@php
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Absensi;
@endphp

<div class="container-fluid">

    <div class="card border-0 shadow-sm p-4">

        <div class="text-center">

            {{-- LOGO SEKOLAH --}}
            <img src="{{ asset('images/logo-sekolah.png') }}" 
     alt="Logo Sekolah" 
     class="img-fluid mb-3"
     style="max-width:180px; width:100%;">

            <h1 class="fw-bold text-primary">
                Sistem Absensi Siswa
            </h1>

            <h4 class="text-secondary">
                SDN Pondok Jagung 05
            </h4>

            <p class="text-muted">
                {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
            </p>

        </div>

    </div>

    <div class="row mt-4">

        <div class="col-md-4 mb-3">
            <div class="card bg-primary text-white shadow border-0">
                <div class="card-body text-center">
                    <h5>Total Siswa</h5>
                    <h1>{{ Siswa::count() }}</h1>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card bg-success text-white shadow border-0">
                <div class="card-body text-center">
                    <h5>Total Kelas</h5>
                    <h1>{{ Kelas::count() }}</h1>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card bg-warning shadow border-0">
                <div class="card-body text-center">
                    <h5>Absensi Hari Ini</h5>
                    <h1>
                        {{ Absensi::whereDate('tanggal', date('Y-m-d'))->count() }}
                    </h1>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection