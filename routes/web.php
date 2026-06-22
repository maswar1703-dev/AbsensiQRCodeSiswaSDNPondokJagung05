<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\AbsensiController;

/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    if (auth()->check()) {
        return redirect('/dashboard');
    }

    return redirect('/login');

});
/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | KELAS
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/cetak-data-kelas',
        [KelasController::class, 'cetakPdf']
    )->name('kelas.pdf');

    Route::resource('kelas', KelasController::class);

    /*
    |--------------------------------------------------------------------------
    | SISWA
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/siswa/import',
        [SiswaController::class, 'importExcel']
    )->name('siswa.import');

    Route::get(
        '/siswa/{id}/qr',
        [SiswaController::class, 'downloadQr']
    )->name('siswa.qr');

    Route::get(
        '/siswa/qr-kelas/{kelas}',
        [SiswaController::class, 'cetakQrKelas']
    )->name('siswa.qrkelas');

    Route::resource('siswa', SiswaController::class);

    /*
    |--------------------------------------------------------------------------
    | SCAN ABSENSI
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/scan',
        [AbsensiController::class, 'scan']
    )->name('scan');

    Route::post(
        '/scan',
        [AbsensiController::class, 'store']
    )->name('scan.store');

    /*
    |--------------------------------------------------------------------------
    | SAKIT & IZIN
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/absensi/sakit',
        [AbsensiController::class, 'formSakit']
    )->name('absensi.sakit');

    Route::post(
        '/absensi/sakit',
        [AbsensiController::class, 'storeSakit']
    );

    Route::get(
        '/absensi/izin',
        [AbsensiController::class, 'formIzin']
    )->name('absensi.izin');

    Route::post(
        '/absensi/izin',
        [AbsensiController::class, 'storeIzin']
    );

    /*
    |--------------------------------------------------------------------------
    | LAPORAN ABSENSI
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/laporan',
        [AbsensiController::class, 'laporan']
    )->name('laporan');

    Route::delete(
        '/laporan/{id}',
        [AbsensiController::class, 'destroy']
    )->name('laporan.destroy');

    Route::get(
        '/laporan/pdf',
        [AbsensiController::class, 'cetakPdf']
    )->name('laporan.pdf');
});