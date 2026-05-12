<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class superVisorController extends Controller
{
    public function index() {
        $user = Auth::user();
        $super = $user->petugas;
        return view('supervisor.dashboard', compact('user','super'));
    }
}
