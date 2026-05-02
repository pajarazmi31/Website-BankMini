<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\loginController;

Route::get('/', function () {
    return view('index');
});

//Halaman Login
Route::get('/login', [loginController::class, 'index'])->name('halaman.login');

