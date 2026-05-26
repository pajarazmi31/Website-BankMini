<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\loginController;
use App\Http\Controllers\nasabahController;
use App\Http\Controllers\tellerController;
use App\Http\Controllers\superVisorController;
use App\Http\Controllers\csController;
use App\Http\Controllers\rekeningController;
use App\Http\Controllers\alamatController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

//halaman utama
Route::get('/', function () {
    return view('index');
});


// nasabah
Route::middleware(['role:nasabah'])->group(function () {

Route::get('/nasabah/dashboard', [nasabahController::class, 'index'])->name('nasabah.dashboard');
Route::get('/nasabah/transfer', [nasabahController::class, 'transfer'])->name('nasabah.transfer');

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
Route::get('/customerservice/keloladata', [rekeningController::class, 'keloladata'])->name('costumerservice.keloladata');
Route::post('/customer/tambah', [rekeningController::class, 'store'])->name('tambah.rekening');
Route::get('/customer/detail/{id}', [csController::class, 'detail'])->name('detail.nasabah.cs');
Route::get('/customerservice/edit/{id}', [rekeningController::class, 'edit'])->name('edit.nasabah');
Route::put('/customerservice/update/{id}', [rekeningController::class, 'update'])->name('update.nasabah');
Route::delete('/customerservice/hapus/{id}', [rekeningController::class, 'destroy'])->name('hapus.nasabah');

});

//super visor
Route::middleware(['role:supervisor'])->group(function () {

route::get('/supervisor/dashboard', [superVisorController::class, 'index'])->name('supervisor.dashboard');
Route::get('/supervisor/datanasabah', [superVisorController::class, 'nasabah'])->name('nasabah.supervisor');

Route::get('/supervisor/datapetugas', [superVisorController::class, 'datapetugas'])->name('supervisor.datapetugas');

Route::get('/supervisor/verifikasi', [superVisorController::class, 'transfer'])->name('supervisor.verifikasi');


Route::get('/supervisor/revisi/{id}', [superVisorController::class, 'halamanRevisi'])->name('halaman.revisi');
Route::put('/supervisor/revisi/{id}', [superVisorController::class, 'revisi'])->name('proses.revisi');
Route::get('/supervisor/dataNasabah/{id}', [superVisorController::class, 'detailNasabah'])->name('detail.nasabah');
Route::get('/supervisor/detail/rekening/{id}', [superVisorController::class, 'detail'])->name('detail.rekening.super');
Route::delete('/supervisor/hapus/{id}', [superVisorController::class, 'destroy'])->name('hapus.nasabah.super');
Route::post('/supervisor/aktif/{id}', [superVisorController::class, 'aktif'])->name('rekening.aktif');
Route::get('/supervisor/verifikasi/rekening/', [superVisorController::class, 'verifikasi'])->name('verifikasi.rekening');

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

/// alamat
Route::get('/get-kabupaten/{id}', [alamatController::class, 'getKabupaten']);
Route::get('/get-kecamatan/{id}', [alamatController::class, 'getKecamatan']);
Route::get('/get-desa/{id}', [alamatController::class, 'getDesa']);
