<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\loginController;
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

//login dan logout


// nasabah
Route::middleware(['role:nasabah'])->group(function () {

Route::get('/nasabah/dashboard', [nasabahController::class, 'index'])->name('nasabah.dashboard');
Route::get('/nasabah/transfer', [nasabahController::class, 'transfer'])->name('nasabah.transfer');

});

//teller
Route::middleware(['role:teller'])->group(function () {
Route::get('/teller/dashboard', [tellerController::class, 'index'])->name('teller.dashboard');
//setoran
Route::get('/teller/setoran', [tellerController::class, 'setoran'])->name('teller.setoran');
Route::post('/teller/setoran/store', [tellerController::class, 'storeSetoran'])
->name('setoran.store');
Route::put('/setoran/{id}', [tellerController::class, 'updateSetoran'])
->name('setoran.update');
Route::delete('/setoran/{id}', [tellerController::class, 'destroySetoran'])
->name('setoran.destroy');
//penarikan
Route::get('/teller/penarikan', [tellerController::class, 'penarikan'])->name('teller.penarikan');
Route::post('/penarikan/store',[tellerController::class, 'storePenarikan'])
->name('penarikan.store');
Route::put('/penarikan/update/{id}',[tellerController::class, 'updatePenarikan'])
->name('penarikan.update');
Route::delete('/penarikan/delete/{id}',[tellerController::class, 'destroyPenarikan'])
->name('penarikan.delete');
//transfer
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

Route::get('/supervisor/datanasabah', [superVisorController::class, 'datanasabah'])->name('supervisor.datanasabah');

Route::get('/supervisor/datapetugas', [superVisorController::class, 'datapetugas'])->name('supervisor.datapetugas');

Route::get('/supervisor/verifikasi', [superVisorController::class, 'transfer'])->name('supervisor.verifikasi');

Route::get('/supervisor/verifikasi/registrasi', [superVisorController::class, 'registrasirekening'])->name('supervisor.verifikasi.registrasi');

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
