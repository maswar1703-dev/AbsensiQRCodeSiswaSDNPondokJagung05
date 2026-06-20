<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use Barryvdh\DomPDF\Facade\Pdf;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::withCount('siswa')->get();

        return view('kelas.index', compact('kelas'));
    }

    public function create()
    {
        return view('kelas.create');
    }

    public function store(Request $request)
    {
        Kelas::create([
            'nama_kelas' => $request->nama_kelas
        ]);

        return redirect('/kelas')
            ->with('success', 'Kelas berhasil ditambahkan');
    }

    /*
    |--------------------------------------------------------------------------
    | WAJIB ADA UNTUK RESOURCE ROUTE
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        return redirect('/kelas');
    }

    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);

        return view('kelas.edit', compact('kelas'));
    }

    public function update(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);

        $kelas->update([
            'nama_kelas' => $request->nama_kelas
        ]);

        return redirect('/kelas')
            ->with('success', 'Kelas berhasil diupdate');
    }

    public function destroy($id)
    {
        Kelas::destroy($id);

        return redirect('/kelas')
            ->with('success', 'Kelas berhasil dihapus');
    }

    /*
    |--------------------------------------------------------------------------
    | CETAK PDF DATA KELAS
    |--------------------------------------------------------------------------
    */
  public function cetakPdf()
{
    $kelas = Kelas::withCount('siswa')->get();

    $pdf = Pdf::loadView(
        'kelas.pdf',
        compact('kelas')
    );

    return $pdf->download('Data-Kelas.pdf');
}
}