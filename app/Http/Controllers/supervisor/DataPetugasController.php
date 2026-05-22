<?php

namespace App\Http\Controllers\supervisor;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DataPetugasController extends Controller
{

public function index()
{
    $user = Auth::user();
    $super = $user->petugas;

    $petugas = User::with('role')
        ->whereHas('role', function ($query) {
            $query->whereIn('nama_role', [
                'supervisor',
                'customerservice',
                'teller'
            ]);
        })
        ->get();

    $roles = Role::whereIn('nama_role', [
        'supervisor',
        'customerservice',
        'teller'
    ])->get();

    return view('supervisor.datapetugas', compact(
        'petugas',
        'roles',
        'user',
        'super'
    ));
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'role_id' => 'required',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role_id' => $request->role_id,
    ]);

    return redirect()->back()
        ->with('success', 'Petugas berhasil ditambahkan');
}

public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'role_id' => 'required',
    ]);

    $petugas = User::findOrFail($id);

    $data = [
        'name' => $request->name,
        'email' => $request->email,
        'role_id' => $request->role_id,
    ];

    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    $petugas->update($data);

    return redirect()->back()
        ->with('success', 'Data berhasil diupdate');
}

public function destroy($id)
{
    $petugas = User::findOrFail($id);

    $petugas->delete();

    return redirect()->back()
        ->with('success', 'Data berhasil dihapus');
}

}