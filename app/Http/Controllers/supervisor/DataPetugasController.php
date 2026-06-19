<?php

namespace App\Http\Controllers\supervisor;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PetugasImport;
use App\Exports\PetugasTemplateExport;

class DataPetugasController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $super = $user->petugas;

        $petugas = Petugas::with(['user.role'])
            ->whereHas('user.role', function ($query) {
                $query->whereIn('nama_role', [
                    'supervisor',
                    'customerservice',
                    'teller'
                ]);
            })
            ->get();

        $roles = Role::whereIn('nama_role', [ 
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
            'name' => 'required|string|max:255',
            'kelas' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role_id' => 'required|exists:roles,id',
        ]);

        try {

            DB::transaction(function () use ($request) {

                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role_id' => $request->role_id,
                ]);

                Petugas::create([
                    'user_id' => $user->id,
                    'kelas' => $request->kelas,
                ]);
            });

            return redirect()
                ->route('datapetugas.index')
                ->with('success', 'Data petugas berhasil ditambahkan');

        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->with('error', 'Data petugas gagal ditambahkan');
        }
    }

    public function update(Request $request, $id)
    {
        $petugas = Petugas::with('user')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'kelas' => 'required',
            'email' => 'required|email|unique:users,email,' . $petugas->user->id,
            'role_id' => 'required|exists:roles,id',
            'password' => 'nullable|min:6',
        ]);

        try {

            DB::transaction(function () use ($request, $petugas) {

                $petugas->update([
                    'kelas' => $request->kelas,
                ]);

                $userData = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'role_id' => $request->role_id,
                ];

                if ($request->filled('password')) {
                    $userData['password'] = Hash::make($request->password);
                }

                $petugas->user->update($userData);
            });

            return redirect()
                ->route('datapetugas.index')
                ->with('success', 'Data petugas berhasil diupdate');

        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->with('error', 'Data petugas gagal diupdate');
        }
    }

    public function destroy($id)
    {
        try {

            DB::transaction(function () use ($id) {

                $petugas = Petugas::with('user')->findOrFail($id);

                $user = $petugas->user;

                $petugas->delete();

                if ($user) {
                    $user->delete();
                }
            });

            return redirect()
                ->route('datapetugas.index')
                ->with('success', 'Data petugas berhasil dihapus');

        } catch (\Exception $e) {

            return back()
                ->with('error', 'Data petugas gagal dihapus');
        }
    }

    public function downloadTemplate()
    {
        return Excel::download(new PetugasTemplateExport, 'template_import_petugas.xlsx');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            Excel::import(new PetugasImport, $request->file('file_excel'));

            return redirect()->route('datapetugas.index')
                ->with('success', 'Data petugas berhasil di-import dari Excel!');
        } catch (\Exception $e) {
            return redirect()->route('datapetugas.index')
                ->with('error', 'Gagal mengimport data. Pastikan format file dan ID Role sudah benar.');
        }
    }
}