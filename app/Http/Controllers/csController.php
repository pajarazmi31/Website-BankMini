<?php

namespace App\Http\Controllers;

use App\Models\CostumerService;
use Illuminate\Support\Facades\Auth;
use App\Models\Nasabah;
use App\Models\User;
use App\Models\Rekening;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NasabahTemplateExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class csController extends Controller
{
    public function index() {
        $user = Auth::user();
        $cs = $user->petugas;
        $jumlahNasabah = Nasabah::all()->count();
        $revisi = rekening::where('status_akun','revisi')->count();
        $jumlahPending = rekening::where('status_akun','pending')->count();
        $nasabah = Nasabah::with('rekening')->get();
        return view('costumerservice.dashboard', compact('user','cs','jumlahNasabah','revisi','jumlahPending','nasabah'));
    }

public function keloladata(Request $request) {
        $user = Auth::user();
        $cs = $user->petugas;
        
        // Ambil nilai filter dari URL (jika ada)
        $perPage = $request->input('per_page', 10);
        $keyword = $request->input('keyword');

        // Mulai query untuk Nasabah
        $query = Nasabah::with('rekening');

        // Jika user mengetikkan sesuatu di kolom pencarian
        if ($keyword) {
            $query->where(function($q) use ($keyword) {
                $q->where('nama_nasabah', 'like', "%{$keyword}%")
                  ->orWhere('nis_nip', 'like', "%{$keyword}%")
                  ->orWhere('jabatan', 'like', "%{$keyword}%")
                  ->orWhereHas('rekening', function($rekQuery) use ($keyword) {
                      $rekQuery->where('id', 'like', "%{$keyword}%");
                  });
            });
        }

        // Terapkan paginasi dan bawa serta query (keyword & per_page) ke halaman selanjutnya
        $allNasabah = $query->paginate($perPage)->appends(request()->query());

        // Kirim $allNasabah dan $perPage agar tidak error di Blade
        return view('costumerservice.keloladata', compact('user', 'cs', 'allNasabah', 'perPage'));
    }

    public function detail(String $id) {
        $user = Auth::user();
        $cs = $user->petugas;
        $nasabah = Nasabah::with('rekening','jurusan')->findOrFail($id);
        return view('costumerservice.crudnasabah.detail',compact('user','cs','nasabah'));
    }

    public function TemplateImport() {
        $path = storage_path('app/public/template/import_data_nasabah.xlsx');

        return response()->download($path);
    }

    public function downloadTemplate()
    {
        return Excel::download(new NasabahTemplateExport, 'template_import_nasabah.xlsx');
    }
}
