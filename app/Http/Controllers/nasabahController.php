<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\Bukti_Tf;
use App\Models\Rekening;
use App\Models\RiwayatTf;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class nasabahController extends Controller
{
    public function index() {
        $user = Auth::user();
        $nasabah = $user->nasabah;
        $rekening = Rekening::where('nasabah_id', $nasabah->id)->first();
if ($rekening) {
        $nomorRekening = $rekening->id;

        // Ambil waktu bulan dan tahun sekarang
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        // 1. HITUNG PEMASUKAN SESAMA REKENING (Uang Masuk dari user lain)
        $pemasukanSesama = RiwayatTf::where('id_penerima', $nomorRekening)
                                    ->whereMonth('created_at', $bulanIni)
                                    ->whereYear('created_at', $tahunIni)
                                    ->sum('jumlah_transfer');

        // 2. HITUNG PEMASUKAN DARI TRANSFER LUAR (Tabel bukti_tf yang sudah diverifikasi)
        // Kolom penentu: id_rekening cocok dengan nomor rekening, dan status sudah diverifikasi
        $pemasukanLuar = Bukti_Tf::where('id_rekening', $nomorRekening)
                                  ->where('status_verifikasi', 'berhasil') // Sesuaikan nama status di DB-mu (misal: 'sukses', 'approved', atau 1)
                                  ->whereMonth('created_at', $bulanIni) // Pastikan tabel bukti_tf punya kolom created_at atau datetime_tgl
                                  ->whereYear('created_at', $tahunIni)
                                  ->sum('jumlah_transfer');

        // 3. JUMBLAHKAN TOTAL PEMASUKAN BULAN INI
        // Jika ada transaksi tipe lain seperti "Setor Tunai langsung lewat Teller", silakan ikut dijumlahkan di sini
        $totalPemasukanBulanIni = $pemasukanSesama + $pemasukanLuar;

        // --- Logika Pengeluaran Bulan Ini (Tetap biarkan yang sudah kamu buat) ---
        $totalPengeluaranBulanIni = RiwayatTf::where('id_pengirim', $nomorRekening)
                                             ->whereMonth('created_at', $bulanIni)
                                             ->whereYear('created_at', $tahunIni)
                                             ->sum('jumlah_transfer');
    } else {
        $totalPemasukanBulanIni = 0;
        $totalPengeluaranBulanIni = 0;
    }
        return view('nasabah.dashboard', compact('user','nasabah', 'rekening', 'totalPemasukanBulanIni', 'totalPengeluaranBulanIni'));
    }

    public function transfer() {
        $user = Auth::user();
        $nasabah = $user->nasabah;
        $rekening = Rekening::where('nasabah_id', $nasabah->id)->first();
if ($rekening) {
        $nomorRekening = $rekening->id;

        $riwayatTransfer = RiwayatTf::where('id_pengirim', $nomorRekening)
                                            ->orWhere('id_penerima', $nomorRekening)
                                            ->orderBy('created_at', 'desc')
                                            ->get();

        // Ambil waktu bulan dan tahun sekarang
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        // 1. HITUNG PEMASUKAN SESAMA REKENING (Uang Masuk dari user lain)
        $pemasukanSesama = RiwayatTf::where('id_penerima', $nomorRekening)
                                    ->whereMonth('created_at', $bulanIni)
                                    ->whereYear('created_at', $tahunIni)
                                    ->sum('jumlah_transfer');

        // 2. HITUNG PEMASUKAN DARI TRANSFER LUAR (Tabel bukti_tf yang sudah diverifikasi)
        // Kolom penentu: id_rekening cocok dengan nomor rekening, dan status sudah diverifikasi
        $pemasukanLuar = Bukti_Tf::where('id_rekening', $nomorRekening)
                                  ->where('status_verifikasi', 'berhasil') // Sesuaikan nama status di DB-mu (misal: 'sukses', 'approved', atau 1)
                                  ->whereMonth('created_at', $bulanIni) // Pastikan tabel bukti_tf punya kolom created_at atau datetime_tgl
                                  ->whereYear('created_at', $tahunIni)
                                  ->sum('jumlah_transfer');

        // 3. JUMBLAHKAN TOTAL PEMASUKAN BULAN INI
        // Jika ada transaksi tipe lain seperti "Setor Tunai langsung lewat Teller", silakan ikut dijumlahkan di sini
        $totalPemasukanBulanIni = $pemasukanSesama + $pemasukanLuar;

        // --- Logika Pengeluaran Bulan Ini (Tetap biarkan yang sudah kamu buat) ---
        $totalPengeluaranBulanIni = RiwayatTf::where('id_pengirim', $nomorRekening)
                                             ->whereMonth('created_at', $bulanIni)
                                             ->whereYear('created_at', $tahunIni)
                                             ->sum('jumlah_transfer');
    } else {
        $riwayatTransfer = collect();
        $totalPemasukanBulanIni = 0;
        $totalPengeluaranBulanIni = 0;
    }
        return view('nasabah.transfer', compact('user', 'rekening','nasabah','riwayatTransfer', 'totalPemasukanBulanIni', 'totalPengeluaranBulanIni'));
    }

        public function cekRekening($id){
        // Cari rekening beserta data user-nya
        $rekening = Rekening::with('user')->find($id);

        if ($rekening && $rekening->user) {
            return response()->json([
                'success' => true,
                'nama' => $rekening->user->name
            ]);
        }

        return response()->json([
            'success' => false,
            'pesan' => 'Rekening tidak ditemukan'
        ]);
    }

    public function transferLogic(Request $request){
            if ($request->has('jumlah_transfer')) {
            $cleanValue = str_replace('.', '', $request->jumlah_transfer);
            $request->merge(['jumlah_transfer' => $cleanValue]);
        }
            // 1. Validasi Input dari Form
            $request->validate([
                'id_penerima' => 'required|string',
                'nama_penerima' => 'required|string',
                'jumlah_transfer' => 'required|numeric|min:1000',
                'catatan' => 'nullable|string|max:255',
            ]);

            // 2. Ambil ID rekening pengirim secara manual lewat 'nasabah_id' agar anti-error
            $rekeningUser = Rekening::where('nasabah_id', Auth::id())->first();
            
            // Proteksi: Jika user login ternyata belum punya akun di tabel rekening
            if (!$rekeningUser) {
                return redirect()->back()->with('error', 'Transfer gagal: Anda belum memiliki nomor rekening.');
            }

            $idPengirim = $rekeningUser->id; 
                
            // Proteksi: Cegah transfer ke rekening diri sendiri
            if ($idPengirim === $request->id_penerima) {
                return redirect()->back()->with('error', 'Tidak bisa mentransfer ke rekening sendiri.');
            }

            // 3. Jalankan Database Transaction untuk keamanan data saldo
            try {
                DB::transaction(function () use ($idPengirim, $request) {
                    
                    // Ambil data rekening pengirim dan kunci barisnya (lockForUpdate)
                    $rekeningPengirim = Rekening::where('id', $idPengirim)->lockForUpdate()->firstOrFail();
                    
                    // Ambil data rekening penerima berdasarkan nomor rekening yang diinput
                    $rekeningPenerima = Rekening::where('id', $request->id_penerima)->lockForUpdate()->firstOrFail();

                    $nominal = $request->jumlah_transfer;

                    // Cek apakah saldo pengirim mencukupi
                    if ($rekeningPengirim->saldo_saat_ini < $nominal) {
                        throw new \Exception('Saldo Anda tidak mencukupi untuk melakukan transfer ini.');
                    }

                    // PROSES POTONG & TAMBAH SALDO
                    // A. Kurangi saldo pengirim
                    $rekeningPengirim->decrement('saldo_saat_ini', $nominal);

                    // B. Tambah saldo penerima
                    $rekeningPenerima->increment('saldo_saat_ini', $nominal);

                    // C. Catat ke tabel riwayat_tf
                    RiwayatTf::create([
                        'id_pengirim' => $idPengirim,
                        'id_penerima' => $rekeningPenerima->id,
                        'nama_penerima' => $request->nama_penerima ?? 'Nasabah Mini Bank',
                        'jumlah_transfer' => $nominal,
                        'catatan' => $request->catatan,
                    ]);
                });

                // Jika semua proses di dalam DB::transaction sukses:
                // Sesuai dengan route yang kamu tuju (pastikan nama routenya sesuai di web.php)
                return redirect()->back()->with('success', 'Transfer berhasil dikirim!');

            } catch (\Exception $e) {
                // Jika terjadi kegagalan, rollback otomatis aktif
                return redirect()->back()->with('error', 'Transfer gagal: ' . $e->getMessage());
            }
        }
}
