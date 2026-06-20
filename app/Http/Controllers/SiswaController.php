<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DATA SISWA PERKELAS
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $kelas = Kelas::with('siswa')->get();

        return view('siswa.index', compact('kelas'));
    }

    /*
    |--------------------------------------------------------------------------
    | FORM TAMBAH
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $kelas = Kelas::all();

        return view('siswa.create', compact('kelas'));
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN DATA
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:siswas,nis',
            'nama' => 'required',
            'kelas_id' => 'required'
        ]);

        Siswa::create([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'kelas_id' => $request->kelas_id,
            'barcode' => $request->nis
        ]);

        return redirect('/siswa')
            ->with('success', 'Data siswa berhasil ditambahkan');
    }

    /*
    |--------------------------------------------------------------------------
    | FORM EDIT
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);

        $kelas = Kelas::all();

        return view('siswa.edit', compact('siswa', 'kelas'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE DATA
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $request->validate([
            'nis' => 'required',
            'nama' => 'required',
            'kelas_id' => 'required'
        ]);

        $siswa->update([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'kelas_id' => $request->kelas_id,
            'barcode' => $request->nis
        ]);

        return redirect('/siswa')
            ->with('success', 'Data siswa berhasil diupdate');
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS DATA
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);

        $siswa->delete();

        return redirect('/siswa')
            ->with('success', 'Data siswa berhasil dihapus');
    }

    /*
    |--------------------------------------------------------------------------
    | DOWNLOAD QR PDF
    |--------------------------------------------------------------------------
    */

    public function downloadQr($id)
    {
        $siswa = Siswa::with('kelas')->findOrFail($id);

        // generate QR SVG
        $qrCode = base64_encode(
            QrCode::format('svg')
                ->size(300)
                ->generate($siswa->nisn)
        );

        // load pdf
        $pdf = Pdf::loadView(
            'siswa.qr_pdf',
            compact('siswa', 'qrCode')
        );

        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('QR-' . $siswa->nama . '.pdf');
    }

 /*
|--------------------------------------------------------------------------
| CETAK QR PER KELAS
|--------------------------------------------------------------------------
*/

public function cetakQrKelas($kelasId)
{
    $kelas = Kelas::findOrFail($kelasId);

    $siswas = Siswa::where('kelas_id', $kelasId)
        ->orderBy('nama')
        ->get();

    foreach ($siswas as $siswa) {

        $siswa->qrCode = base64_encode(
            QrCode::format('svg')
                ->size(250)
                ->generate($siswa->nisn)
        );
    }

    $pdf = Pdf::loadView(
        'siswa.pdf_qr_kelas',
        compact('kelas', 'siswas')
    );

    $pdf->setPaper('A4', 'portrait');

    return $pdf->download(
        'QR-Kelas-' . $kelas->nama_kelas . '.pdf'
    );
}
    /*
    |--------------------------------------------------------------------------
    | IMPORT EXCEL
    |--------------------------------------------------------------------------
    */

   public function importExcel(Request $request)
{
    $request->validate([
        'file_excel' => 'required|mimes:xlsx,xls,csv'
    ]);

    $file = $request->file('file_excel');

    $data = Excel::toArray([], $file);

    foreach ($data[0] as $index => $row) {

        // skip header
        if ($index == 0) {
            continue;
        }

        // skip data kosong
        if (
            empty($row[0]) ||
            empty($row[1]) ||
            empty($row[2])
        ) {
            continue;
        }

        // cari kelas berdasarkan nama kelas
        $kelas = Kelas::firstOrCreate([
    'nama_kelas' => $row[2]
    ]);

        // cek NIS sudah ada
        $cek = Siswa::where('nis', $row[0])->first();

        if ($cek) {
            continue;
        }

        // simpan siswa
        Siswa::create([
            'nis' => $row[0],
            'nama' => $row[1],
            'kelas_id' => $kelas->id,
            'barcode' => $row[0]
        ]);
    }

    return redirect('/siswa')
        ->with('success', 'Import data siswa berhasil');
}
}