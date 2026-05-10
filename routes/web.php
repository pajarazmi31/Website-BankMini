<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\loginController;

Route::get('/', function () {
    return view('index');
});

//Halaman Login
Route::get('/login', [loginController::class, 'index'])->name('halaman.login');


Route::get('/nasabah/dashboard', function () {
    return view('nasabah.dashboard');
})->name('nasabah.dashboard');

Route::get('/nasabah/transfer', function () {
    return view('nasabah.transfer');
})->name('nasabah.transfer');




