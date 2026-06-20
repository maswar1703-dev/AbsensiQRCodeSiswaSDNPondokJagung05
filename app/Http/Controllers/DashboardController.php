<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Absensi;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahSiswa = Siswa::count();

        $jumlahKelas = Kelas::count();

        // Hanya menghitung absensi hari ini
        $jumlahAbsensi = Absensi::whereDate(
            'tanggal',
            date('Y-m-d')
        )->count();

        return view(
            'dashboard',
            compact(
                'jumlahSiswa',
                'jumlahKelas',
                'jumlahAbsensi'
            )
        );
    }
}