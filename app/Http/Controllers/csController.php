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

    public function keloladata() {
        $user = Auth::user();
        $cs = $user->petugas;
        $nasabah = Nasabah::with('rekening')->get();
        return view('costumerservice.keloladata',compact('user','cs','nasabah'));
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
