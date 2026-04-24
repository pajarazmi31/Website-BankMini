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
    /* 
    | Bagian ini dapat diganti dengan AuthController untuk menangani logika login.
    | Frontend sudah siap menerima session 'success' atau 'error' 
    | untuk menampilkan notifikasi toast.
    */
    return redirect()->back()->with('error', 'Fitur login sedang disiapkan oleh tim backend.');
});
