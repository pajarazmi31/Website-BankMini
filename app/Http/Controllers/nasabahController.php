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

use App\Models\Setoran;
use App\Models\Penarikan;
use App\Models\Transfer;
use App\Models\Transaksi;

class nasabahController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $nasabah = $user->nasabah;
        $rekening = Rekening::where('nasabah_id', $nasabah->id)->first();

        if ($rekening) {
            $nomorRekening = $rekening->id;

            // Ambil bulan dan tahun sekarang
            $bulanIni = Carbon::now()->month;
            $tahunIni = Carbon::now()->year;

            // 1. HITUNG TOTAL PEMASUKAN BULAN INI
            // a. Transfer Sesama Nasabah (Penerima = Nomor Rekening)
            $pemasukanSesama = RiwayatTf::where('id_penerima', $nomorRekening)
                ->whereMonth('created_at', $bulanIni)
                ->whereYear('created_at', $tahunIni)
                ->sum('jumlah_transfer');

            // b. Transfer Teller Masuk
            $pemasukanTeller = Transfer::where('id_rekening_penerima', $nomorRekening)
                ->whereMonth('created_at', $bulanIni)
                ->whereYear('created_at', $tahunIni)
                ->sum('jumlah_transfer');

            // c. Setoran Tunai Teller
            $pemasukanSetoran = Setoran::where('id_rekening', $nomorRekening)
                ->whereMonth('created_at', $bulanIni)
                ->whereYear('created_at', $tahunIni)
                ->sum('jumlah_penyetoran');

            // d. Transfer dari Luar (Bukti_Tf - Uang Masuk dari Bank/Pihak Luar)
            $pemasukanLuar = Bukti_Tf::where('id_rekening', $nomorRekening)
                ->where('status_verifikasi', 'berhasil') // Hanya yang sudah disetujui
                ->whereMonth('datetime_tgl', $bulanIni)
                ->whereYear('datetime_tgl', $tahunIni)
                ->sum('jumlah_transfer');

            $totalPemasukanBulanIni = $pemasukanSesama + $pemasukanTeller + $pemasukanSetoran + $pemasukanLuar;


            // 2. HITUNG TOTAL PENGELUARAN BULAN INI
            // a. Transfer Sesama Nasabah (Pengirim = Nomor Rekening)
            $pengeluaranSesama = RiwayatTf::where('id_pengirim', $nomorRekening)
                ->whereMonth('created_at', $bulanIni)
                ->whereYear('created_at', $tahunIni)
                ->sum('jumlah_transfer');

            // b. Transfer Teller Keluar
            $pengeluaranTeller = Transfer::where('id_rekening_pengirim', $nomorRekening)
                ->whereMonth('created_at', $bulanIni)
                ->whereYear('created_at', $tahunIni)
                ->sum('jumlah_transfer');

            // c. Penarikan Tunai Teller
            $pengeluaranPenarikan = Penarikan::where('id_rekening', $nomorRekening)
                ->whereMonth('created_at', $bulanIni)
                ->whereYear('created_at', $tahunIni)
                ->sum('jumlah_penarikan');

            $totalPengeluaranBulanIni = $pengeluaranSesama + $pengeluaranTeller + $pengeluaranPenarikan;


            // 3. AMBIL RIWAYAT TRANSAKSI

            $transferNasabah = RiwayatTf::where('id_pengirim', $nomorRekening)
                ->orWhere('id_penerima', $nomorRekening)
                ->get()
                ->map(function ($item) {
                    $item->jenis_transaksi = 'transfer';
                    return $item;
                });

            $transferTeller = Transfer::where('id_rekening_pengirim', $nomorRekening)
                ->orWhere('id_rekening_penerima', $nomorRekening)
                ->get()
                ->map(function ($item) use ($nomorRekening) {
                    $item->jenis_transaksi = $item->id_rekening_pengirim == $nomorRekening
                        ? 'transfer_teller_keluar'
                        : 'transfer_teller_masuk';
                    return $item;
                });

            $setoran = Setoran::where('id_rekening', $nomorRekening)
                ->get()
                ->map(function ($item) {
                    $item->jenis_transaksi = 'setoran';
                    return $item;
                });

            $penarikan = Penarikan::where('id_rekening', $nomorRekening)
                ->get()
                ->map(function ($item) {
                    $item->jenis_transaksi = 'penarikan';
                    return $item;
                });

            // Transfer Bank Luar (Sifatnya Uang Masuk)
            $transferLuar = Bukti_Tf::where('id_rekening', $nomorRekening)
                ->get()
                ->map(function ($item) {
                    $item->jenis_transaksi = 'transfer_luar_masuk';
                    return $item;
                });

            // 4. GABUNGKAN DAN URUTKAN RIWAYAT
            $semuaRiwayat = $transferNasabah
                ->concat($transferTeller)
                ->concat($setoran)
                ->concat($penarikan)
                ->concat($transferLuar)
                ->sortByDesc(function ($item) {
                    return $item->created_at ?? $item->datetime_tgl;
                })
                ->values();

            $riwayatTransfer = $semuaRiwayat->take(5);
        } else {
            $totalPemasukanBulanIni = 0;
            $totalPengeluaranBulanIni = 0;
            $riwayatTransfer = collect();
            $semuaRiwayat = collect();
        }

        return view('nasabah.dashboard', compact(
            'user',
            'nasabah',
            'rekening',
            'totalPemasukanBulanIni',
            'totalPengeluaranBulanIni',
            'riwayatTransfer',
            'semuaRiwayat'
        ));
    }

    public function transfer()
    {
        $biaya_admin = Transaksi::findOrFail(5);
        $user = Auth::user();
        $nasabah = $user->nasabah;
        $rekening = Rekening::where('nasabah_id', $nasabah->id)->first();
        if ($rekening) {
            $nomorRekening = $rekening->id;

            $riwayatTransfer = RiwayatTf::with(['pengirim.nasabah.user', 'penerima']) // <-- Ditambahkan ini
                ->where('id_pengirim', $nomorRekening)
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
        return view('nasabah.transfer', compact('biaya_admin', 'user', 'rekening', 'nasabah', 'riwayatTransfer', 'totalPemasukanBulanIni', 'totalPengeluaranBulanIni'));
    }

    public function cekRekening($id)
    {
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

    public function transferLogic(Request $request)
    {
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
        $nasabah = Nasabah::where('user_id', Auth::id())->first();
        $rekeningUser = Rekening::where('nasabah_id', $nasabah->id)->first();

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

                $adminTransfer = Transaksi::where('id', 5)->value('nominal');
                // Ambil data rekening pengirim dan kunci barisnya (lockForUpdate)
                $rekeningPengirim = Rekening::where('id', $idPengirim)->lockForUpdate()->firstOrFail();
                // Ambil data rekening penerima berdasarkan nomor rekening yang diinput
                $rekeningPenerima = Rekening::where('id', $request->id_penerima)->lockForUpdate()->firstOrFail();

                $nominal = $request->jumlah_transfer;
                $totalPotongan = $nominal + $adminTransfer;

                // Cek apakah saldo pengirim mencukupi
                if ($rekeningPengirim->saldo_saat_ini < $totalPotongan) {
                    throw new \Exception('Saldo Anda tidak mencukupi untuk melakukan transfer ini.');
                }

// PROSES POTONG & TAMBAH SALDO
// A. Kurangi saldo pengirim dan simpan ke variabel
$rekeningPengirim->saldo_saat_ini -= $totalPotongan;
$saldoPengirimBaru = $rekeningPengirim->saldo_saat_ini;
$rekeningPengirim->save(); // <-- PERBAIKAN: Simpan perubahan saldo pengirim

// B. Tambah saldo penerima dan simpan ke variabel
$rekeningPenerima->saldo_saat_ini += $nominal;
$saldoPenerimaBaru = $rekeningPenerima->saldo_saat_ini;
$rekeningPenerima->save(); // <-- PERBAIKAN: Simpan perubahan saldo penerima

// C. Catat ke tabel riwayat_tf
RiwayatTf::create([
    'transaksi_id'  => 5,
    'id_pengirim' => $idPengirim,
    'id_penerima' => $rekeningPenerima->id,
    'nama_penerima' => $request->nama_penerima ?? 'Nasabah Mini Bank',
    'jumlah_transfer' => $nominal,
    'nominal_admin' => $adminTransfer,
    'catatan' => $request->catatan,
    'saldo_transaksi_pengirim' => $saldoPengirimBaru,
    'saldo_transaksi_penerima' => $saldoPenerimaBaru,
]);
                $teller = new \App\Http\Controllers\tellerController();
                $teller->sinkronisasiSaldo($idPengirim); // Update saldo pengirim
                $teller->sinkronisasiSaldo($request->id_penerima); // Update saldo penerima
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
