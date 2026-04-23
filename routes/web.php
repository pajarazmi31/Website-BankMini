<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');


Route::get('/dashboard', function () {
    return view('costumer_service.dashboard');
})->name('dashboard');

Route::post('/login', function () {
 
    return redirect()->route('dashboard');
});
Route::post('/logout', function () {
    return redirect()->route('login');
})->name('logout');

Route::get('/logout', function () {
    return redirect()->route('login');
});
