<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\loginController;
use App\Http\Controllers\Bukti_tfController;
use App\Http\Controllers\nasabahController;
use App\Http\Controllers\tellerController;
use App\Http\Controllers\superVisorController;
use App\Http\Controllers\csController;
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

//super visor
Route::middleware(['role:supervisor'])->group(function () {

route::get('/supervisor/dashboard', [superVisorController::class, 'index'])->name('supervisor.dashboard');

Route::get('/supervisor/datanasabah', function () {
    return view('supervisor.datanasabah');
})->name('supervisor.datanasabah');

Route::get('/supervisor/datapetugas', function () {
    return view('supervisor.datapetugas');
})->name('supervisor.datapetugas');

//View Verifikasi Tf
Route::get('/supervisor/verifikasi', [superVisorController::class, 'verifikasi'])->name('supervisor.verifikasi');

// logika verifikasi Tf
Route::patch('/supervisor/verifikasi/status{id}', [superVisorController::class, 'verifikasiTf'])->name('supervisor.verifikasiTf');

Route::get('/supervisor/verifikasi/registrasi', function () {
    return view('supervisor.verifikasi.registrasirekening');
})->name('supervisor.verifikasi.registrasi');

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
