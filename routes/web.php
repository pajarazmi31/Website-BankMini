<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/nasabah/dashboard', function () {
    return view('nasabah.dashboard');
})->name('nasabah.dashboard');

Route::get('/nasabah/transfer', function () {
    return view('nasabah.transfer');
})->name('nasabah.transfer');

//Teller

Route::get('/teller/dashboard', function () {
    return view('teller.dashboard');
})->name('teller.dashboard');

Route::get('/teller/setoran', function () {
    return view('teller.setoran');
})->name('teller.setoran');

Route::get('/teller/penarikan', function () {
    return view('teller.penarikan');
})->name('teller.penarikan');

Route::get('/teller/transfer', function () {
    return view('teller.transfer');
})->name('teller.transfer');

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