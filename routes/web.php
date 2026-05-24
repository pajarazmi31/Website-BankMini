<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\loginController;
use App\Http\Controllers\Bukti_tfController;
use App\Http\Controllers\nasabahController;
use App\Http\Controllers\tellerController;
use App\Http\Controllers\superVisorController;
use App\Http\Controllers\csController;
use App\Http\Controllers\supervisor\DataPetugasController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

//halaman utama
Route::get('/', function () {
    return view('index');
});

// Logic Tf Luar
Route::post('/Bukti_tf_transfer_luar', [Bukti_tfController::class, 'transfer_luar'])->name('bukti_tf.transfer_luar');

// nasabah
Route::middleware(['role:nasabah'])->group(function () {

Route::get('/nasabah/dashboard', [nasabahController::class, 'index'])->name('nasabah.dashboard');
Route::get('/nasabah/transfer', [nasabahController::class, 'transfer'])->name('nasabah.transfer');
Route::post('/transferProses', [nasabahController::class, 'transferLogic'])->name('transfer.proses');

});
//teller
Route::middleware(['role:teller'])->group(function () {

Route::get('/teller/dashboard', [tellerController::class, 'index'])->name('teller.dashboard');
Route::get('/teller/setoran', [tellerController::class, 'setoran'])->name('teller.setoran');
Route::get('/teller/penarikan', [tellerController::class, 'penarikan'])->name('teller.penarikan');
Route::get('/teller/transfer', [tellerController::class, 'transfer'])->name('teller.transfer');

});

//customer service
Route::middleware(['role:customerservice'])->group(function () {

route::get('/customerservice/dashboard', [csController::class, 'index'])->name('cs.dashboard');
Route::get('/customerservice/keloladata', [csController::class, 'keloladata'])->name('costumerservice.keloladata');

});

    //ROLE SUPERVISOR
Route::middleware(['role:supervisor'])->group(function () {

route::get('/supervisor/dashboard', [superVisorController::class, 'index'])->name('supervisor.dashboard');

// data petugas
Route::get('/supervisor/datapetugas', [DataPetugasController::class, 'index'])->name('supervisor.datapetugas');
Route::post('/datapetugas/store', [DataPetugasController::class, 'store'])->name('datapetugas.store');
Route::put('/datapetugas/update/{id}', [DataPetugasController::class, 'update'])->name('datapetugas.update');
Route::delete('/datapetugas/delete/{id}', [DataPetugasController::class, 'destroy'])->name('datapetugas.destroy');

Route::get('/supervisor/datanasabah', [superVisorController::class, 'dataNasabah'])->name('supervisor.datanasabah');

//View Verifikasi Tf
Route::get('/supervisor/verifikasi', [superVisorController::class, 'verifikasi'])->name('supervisor.verifikasi');
Route::get('/admin/produk/search', [superVisorController::class, 'searchData'])->name('supervisor.searchData');

// Export Data Tf
Route::get('/supervisor/export-transfer', [superVisorController::class, 'exportExcel'])->name('supervisor.exportTransfer');

// logika verifikasi Tf
Route::patch('/supervisor/verifikasi/status{id}', [superVisorController::class, 'verifikasiTf'])->name('supervisor.verifikasiTf');

Route::get('/supervisor/verifikasi/registrasi', [superVisorController::class, 'registrasiRekening'])->name('supervisor.verifikasi.registrasi');

});
/// logika login na

//Halaman Login
Route::get('/login', [loginController::class, 'index'])->name('login');

//proses login
Route::post('/login', [loginController::class, 'login'])->name('proses.login');

//logout
Route::post('/logout',[loginController::class, 'logout'])->name('logout');


// Route::post('/logout', function () {
//     return redirect()->route('login');
// })->name('logout');

// Route::post('/login', function () {
//     return redirect()->route('nasabah.dashboard');
// });
