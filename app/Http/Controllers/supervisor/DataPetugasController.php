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
    public function index(Request $request)
    {
        $user = Auth::user();
        $super = $user->petugas;
        $perPage = $request->input('per_page', 10);
        $keyword = $request->keyword;

        // Sesuaikan dengan relasi role utama atau role2
        $petugas = Petugas::with(['user.role', 'user.role2'])
            ->whereHas('user', function ($query) {
                $query->whereHas('role', function($q) {
                    $q->whereIn('nama_role', ['customerservice', 'teller']);
                })->orWhereHas('role2', function($q) {
                    $q->whereIn('nama_role', ['customerservice', 'teller']);
                });
            })->when($keyword, function ($query, $keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('kelas', 'like', '%' . $keyword . '%')
                      ->orWhereHas('user', function ($userQuery) use ($keyword) {
                          $userQuery->where('name', 'like', '%' . $keyword . '%');
                      });
                });
            })
            ->orderByDesc('id')
            ->paginate($perPage)
            ->appends(['per_page' => $perPage, 'keyword' => $keyword]);

        $roles = Role::whereIn('nama_role', [
            'customerservice',
            'teller'
        ])->get();

        return view('supervisor.datapetugas', compact(
            'petugas',
            'roles',
            'user',
            'perPage',
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
            'role_id_2' => 'nullable|exists:roles,id|different:role_id',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role_id' => $request->role_id,
                    'role_id_2' => $request->role_id_2,
                ]);

                Petugas::create([
                    'user_id' => $user->id,
                    'kelas' => $request->kelas,
                ]);
            });

            return redirect()
                ->route('supervisor.datapetugas')
                ->with('success', 'Data petugas berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Data petugas gagal ditambahkan: ' . $e->getMessage());
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
            'role_id_2' => 'nullable|exists:roles,id|different:role_id',
            'password' => 'nullable|min:6',
        ]);

        try {
            DB::transaction(function () use ($request, $petugas) {
                $petugas->update(['kelas' => $request->kelas]);

                $userData = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'role_id' => $request->role_id,
                    'role_id_2' => $request->role_id_2,
                ];

                if ($request->filled('password')) {
                    $userData['password'] = Hash::make($request->password);
                }

                $petugas->user->update($userData);
            });

            return redirect()
                ->route('supervisor.datapetugas')
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
                ->route('supervisor.datapetugas')
                ->with('success', 'Data petugas berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Data petugas gagal dihapus');
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
            return redirect()->route('supervisor.datapetugas')->with('success', 'Data petugas berhasil di-import!');
        } catch (\Exception $e) {
            return redirect()->route('supervisor.datapetugas')->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }
}