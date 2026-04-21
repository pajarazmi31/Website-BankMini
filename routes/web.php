<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/login', function () {
    return view('login.login');
})->name('login');

Route::post('/login', function () {
    /* 
    | Bagian ini dapat diganti dengan AuthController untuk menangani logika login.
    | Frontend sudah siap menerima session 'success' atau 'error' 
    | untuk menampilkan notifikasi toast.
    */
    return redirect()->back()->with('error', 'Fitur login sedang disiapkan oleh tim backend.');
});
