<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\loginController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('index');
});

//Halaman Login
Route::get('/login', [loginController::class, 'index'])->name('login');

//proses login
Route::post('/login', [loginController::class, 'login'])->name('proses.login');

//logout
Route::post('/logout',[loginController::class, 'logout'])->name('logout');



Route::get('/nasabah/dashboard', function () {
    $user = auth::user();
    $nasabah = $user->nasabah;
    return view('nasabah.dashboard', compact('user','nasabah'));
})->name('nasabah.dashboard');

Route::get('/nasabah/transfer', function () {
    return view('nasabah.transfer');
})->name('nasabah.transfer');

Route::get('/teller/dashboard', function () {
    return view('teller.dashboard');
})->name('teller.dashboard');

Route::post('/login', function () {
    return redirect()->route('nasabah.dashboard');
});


Route::get('/teller/setoran', function () {
    return view('teller.setoran');
})->name('teller.setoran');

Route::get('/teller/penarikan', function () {
    return view('teller.penarikan');
})->name('teller.penarikan');

Route::get('/teller/transfer', function () {
    return view('teller.transfer');
})->name('teller.transfer');

Route::get('/costumerservice/dashboard', function () {
    return view('costumerservice.dashboard');
})->name('costumerservice.dashboard');

Route::get('/costumerservice/keloladata', function () {
    return view('costumerservice.keloladata');
})->name('costumerservice.keloladata');

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





Route::post('/logout', function () {
    return redirect()->route('login');
})->name('logout');
