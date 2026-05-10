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




