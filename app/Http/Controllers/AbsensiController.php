<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Absensi;
use App\Models\Kelas;
use Barryvdh\DomPDF\Facade\Pdf;

class AbsensiController extends Controller
{
    // =========================
    // HALAMAN SCAN
    // =========================
    public function scan()
    {
        return view('scan.index');
    }

    // =========================
    // PROSES ABSENSI
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'qr_code' => 'required'
        ]);

        $siswa = Siswa::where('nis', $request->qr_code)->first();
if (!$siswa) {
    return response()->json([
        'success' => false,
        'message' => 'Siswa tidak ditemukan'
    ]);
}       

        $cek = Absensi::where('siswa_id', $siswa->id)
            ->whereDate('tanggal', now()->toDateString())
            ->first();

        if ($cek) {
    return response()->json([
        'success' => false,
        'message' => 'Siswa sudah absen hari ini',
        'nis' => $siswa->nis,
        'nama' => $siswa->nama,
        'kelas' => $siswa->kelas->nama_kelas
    ]);
}

        Absensi::create([
            'siswa_id' => $siswa->id,
            'tanggal' => now()->toDateString(),
            'jam' => now()->format('H:i:s'),
            'status' => 'hadir'
        ]);

       return response()->json([
    'success' => true,
    'message' => 'Absensi berhasil',
    'nis' => $siswa->nis,
    'nama' => $siswa->nama,
    'kelas' => $siswa->kelas->nama_kelas
]);
    }

  // =========================
// LAPORAN ABSENSI
// =========================
public function laporan(Request $request)
{
    $kelasList = Kelas::all();

    $bulan   = $request->bulan;
    $tahun   = $request->tahun;
    $kelas   = $request->kelas;
    $tanggal = $request->tanggal;

    $query = Absensi::with(['siswa.kelas']);

    if ($bulan && $tahun) {
        $query->whereMonth('tanggal', $bulan)
              ->whereYear('tanggal', $tahun);
    }

    if ($kelas) {
        $query->whereHas('siswa', function ($q) use ($kelas) {
            $q->where('kelas_id', $kelas);
        });
    }

    if ($tanggal) {
        $query->whereDate('tanggal', $tanggal);
    }

    $absensis = $query->latest()->get();

    $totalHadir = (clone $query)
        ->where('status', 'hadir')
        ->count();

    $totalSakit = (clone $query)
        ->where('status', 'sakit')
        ->count();

    $totalIzin = (clone $query)
        ->where('status', 'izin')
        ->count();

    // REKAP BULANAN
    $rekapBulanan = [];

    if ($bulan && $tahun) {

        $siswas = Siswa::with('kelas')->get();

        foreach ($siswas as $siswa) {

            if ($kelas && $siswa->kelas_id != $kelas) {
                continue;
            }

            $rekapBulanan[] = [

                'nis'   => $siswa->nis,
                'nama'  => $siswa->nama,
                'kelas' => $siswa->kelas->nama_kelas ?? '-',

                'hadir' => Absensi::where('siswa_id', $siswa->id)
                    ->whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun)
                    ->where('status', 'hadir')
                    ->count(),

                'sakit' => Absensi::where('siswa_id', $siswa->id)
                    ->whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun)
                    ->where('status', 'sakit')
                    ->count(),

                'izin' => Absensi::where('siswa_id', $siswa->id)
                    ->whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun)
                    ->where('status', 'izin')
                    ->count(),
            ];
        }
    }

    return view('laporan.index', compact(
        'absensis',
        'kelasList',
        'bulan',
        'tahun',
        'kelas',
        'tanggal',
        'totalHadir',
        'totalSakit',
        'totalIzin',
        'rekapBulanan'
    ));
}

// =========================
// CETAK PDF
// =========================
public function cetakPdf(Request $request)
{
    $bulan = $request->bulan;
    $tahun = $request->tahun;
    $kelas = $request->kelas;

    $query = Absensi::with(['siswa.kelas']);

    if ($bulan && $tahun) {
        $query->whereMonth('tanggal', $bulan)
              ->whereYear('tanggal', $tahun);
    }

    if ($kelas) {
        $query->whereHas('siswa', function ($q) use ($kelas) {
            $q->where('kelas_id', $kelas);
        });
    }

    $absensis = $query->get();

    $namaKelas = 'Semua Kelas';

    if ($kelas) {
        $dataKelas = Kelas::find($kelas);

        if ($dataKelas) {
            $namaKelas = $dataKelas->nama_kelas;
        }
    }

    $rekapBulanan = [];

    if ($bulan && $tahun) {

        $siswas = Siswa::with('kelas')->get();

        foreach ($siswas as $siswa) {

            if ($kelas && $siswa->kelas_id != $kelas) {
                continue;
            }

            $rekapBulanan[] = [

                'nis' => $siswa->nis,
                'nama' => $siswa->nama,
                'kelas' => $siswa->kelas->nama_kelas ?? '-',

                'hadir' => Absensi::where('siswa_id', $siswa->id)
                    ->whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun)
                    ->where('status', 'hadir')
                    ->count(),

                'sakit' => Absensi::where('siswa_id', $siswa->id)
                    ->whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun)
                    ->where('status', 'sakit')
                    ->count(),

                'izin' => Absensi::where('siswa_id', $siswa->id)
                    ->whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun)
                    ->where('status', 'izin')
                    ->count(),
            ];
        }
    }

    $pdf = Pdf::loadView('laporan.pdf', compact(
        'absensis',
        'namaKelas',
        'bulan',
        'tahun',
        'rekapBulanan'
    ));

    return $pdf->download('Laporan-Absensi.pdf');
}

   // =========================
// FORM SAKIT
// =========================
public function formSakit(Request $request)
{
    $kelasList = Kelas::orderBy('nama_kelas')->get();

    $siswas = Siswa::when($request->kelas, function ($q) use ($request) {
        $q->where('kelas_id', $request->kelas);
    })->orderBy('nama')->get();

    return view('absensi.sakit', compact(
        'siswas',
        'kelasList'
    ));
}    // =========================
    // SIMPAN SAKIT
    // =========================
    public function storeSakit(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required'
        ]);

        Absensi::create([
            'siswa_id' => $request->siswa_id,
            'tanggal' => now()->toDateString(),
            'jam' => now()->format('H:i:s'),
            'status' => 'sakit'
        ]);

        return redirect('/laporan')
            ->with('success', 'Data siswa sakit berhasil disimpan');
    }

    // =========================
// FORM IZIN
// =========================
public function formIzin(Request $request)
{
    $kelasList = Kelas::orderBy('nama_kelas')->get();

    $siswas = Siswa::when($request->kelas, function ($q) use ($request) {
        $q->where('kelas_id', $request->kelas);
    })->orderBy('nama')->get();

    return view('absensi.izin', compact(
        'siswas',
        'kelasList'
    ));
}
    // =========================
    // SIMPAN IZIN
    // =========================
    public function storeIzin(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required'
        ]);

        Absensi::create([
            'siswa_id' => $request->siswa_id,
            'tanggal' => now()->toDateString(),
            'jam' => now()->format('H:i:s'),
            'status' => 'izin'
        ]);

        return redirect('/laporan')
            ->with('success', 'Data siswa izin berhasil disimpan');
    }

    // =========================
    // HAPUS DATA
    // =========================
    public function destroy($id)
    {
        $absensi = Absensi::findOrFail($id);
        $absensi->delete();

        return redirect('/laporan')
            ->with('success', 'Data berhasil dihapus');
    }
}