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

//Landing Page

Route::get('/', function () {
    return view('index');
});

//login dan logout

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/logout', function () {
    return redirect()->route('login');
})->name('logout');

//Nasabah

//teller
Route::middleware(['role:teller'])->group(function () {

Route::get('/teller/dashboard', [tellerController::class, 'index'])->name('teller.dashboard');
Route::get('/teller/setoran', [tellerController::class, 'setoran'])->name('teller.setoran');
Route::get('/teller/penarikan', [tellerController::class, 'penarikan'])->name('teller.penarikan');
Route::get('/teller/transfer', [tellerController::class, 'transfer'])->name('teller.transfer');

//Teller

Route::get('/teller/dashboard', function () {
    return view('teller.dashboard');
})->name('teller.dashboard');

Route::get('/teller/setoran', function () {
    return view('teller.setoran');
})->name('teller.setoran');

});

//super visor
Route::middleware(['role:supervisor'])->group(function () {

//Customer Service

Route::get('/costumerservice/dashboard', function () {
    return view('costumerservice.dashboard');
})->name('costumerservice.dashboard');

Route::get('/costumerservice/keloladata', function () {
    return view('costumerservice.keloladata');
})->name('costumerservice.keloladata');

//Supervisor

Route::get('/supervisor/dashboard', function () {
    return view('supervisor.dashboard');
})->name('supervisor.dashboard');

Route::get('/supervisor/datanasabah', function () {
    return view('supervisor.datanasabah');
})->name('supervisor.datanasabah');

Route::get('/supervisor/datapetugas', function () {
    return view('supervisor.datapetugas');
})->name('supervisor.datapetugas');

Route::get('/supervisor/verifikasi', function () {
    return view('supervisor.verifikasi.transfer');
})->name('supervisor.verifikasi');

Route::get('/supervisor/verifikasi/registrasi', function () {
    return view('supervisor.verifikasi.registrasirekening');
})->name('supervisor.verifikasi.registrasi');

});
