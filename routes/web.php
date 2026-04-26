<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');


Route::get('/nasabah/dashboard', function () {
    return view('nasabah.dashboard');
})->name('nasabah.dashboard');

Route::get('/nasabah/transfer', function () {
    return view('nasabah.transfer');
})->name('nasabah.transfer');




