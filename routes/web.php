<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\loginController;
use App\Http\Controllers\Bukti_tfController;
use App\Http\controllers\siswaController;
use App\Http\Controllers\nasabahController;
use App\Http\Controllers\tellerController;
use App\Http\Controllers\superVisorController;
use App\Http\Controllers\csController;
use App\Http\Controllers\supervisor\DataPetugasController;
use App\Http\Controllers\rekeningController;
use App\Http\Controllers\alamatController;
use App\Http\Controllers\landingPageController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

//halaman utama
Route::get('/', [landingPageController::class, 'index'])->name('/');

// Logic Tf Luar
Route::post('/Bukti_tf_transfer_luar', [Bukti_tfController::class, 'transfer_luar'])->name('bukti_tf.transfer_luar');

// nasabah
Route::middleware(['role:nasabah'])->group(function () {
    
    Route::get('/nasabah/dashboard', [nasabahController::class, 'index'])->name('nasabah.dashboard');
    Route::get('/nasabah/transfer', [nasabahController::class, 'transfer'])->name('nasabah.transfer');
    Route::get('/cek-rekening/{id}', [nasabahController::class, 'cekRekening']);
    Route::post('/transferProses', [nasabahController::class, 'transferLogic'])->name('transfer.proses');
    
    });
    //teller
    Route::middleware(['role:teller'])->group(function () {
        
Route::get('/teller/dashboard', [tellerController::class, 'index'])->name('teller.dashboard');
//setoran
Route::get('/teller/setoran', [tellerController::class, 'setoran'])->name('teller.setoran');
Route::post('/teller/setoran/store', [tellerController::class, 'storeSetoran'])
->name('setoran.store');
Route::put('/setoran/{id}', [tellerController::class, 'updateSetoran'])
->name('setoran.update');
Route::delete('/setoran/{id}', [tellerController::class, 'destroySetoran'])
->name('setoran.destroy');
Route::get('/setoran/struk/{id}', [tellerController::class, 'cetakStruk'])
    ->name('setoran.struk');
Route::get('/setoran/export/{filter}', [TellerController::class, 'exportSetoran'])
    ->name('setoran.export');
Route::get('/setoran/export-custom', [TellerController::class, 'exportSetoranCustom'])
    ->name('setoran.export.custom');

//penarikan
Route::get('/teller/penarikan', [tellerController::class, 'penarikan'])->name('teller.penarikan');
Route::post('/penarikan/store',[tellerController::class, 'storePenarikan'])->name('penarikan.store');
Route::put('/penarikan/update/{id}',[tellerController::class, 'updatePenarikan'])->name('penarikan.update');
Route::delete('/penarikan/delete/{id}',[tellerController::class, 'destroyPenarikan'])->name('penarikan.delete');
Route::get('/penarikan/struk/{id}', [tellerController::class, 'cetakStrukPenarikan'])->name('penarikan.struk');
Route::get('/penarikan/export/{filter}',[tellerController::class, 'exportPenarikan'])->name('penarikan.export');
Route::get('/penarikan/export/custom',[tellerController::class, 'exportPenarikanCustom'])->name('penarikan.export.custom');

//transfer
Route::get('/teller/transfer', [tellerController::class, 'transfer'])->name('teller.transfer');
Route::post('/transfer/store', [tellerController::class, 'storeTransfer'])->name('transfer.store');
Route::put('/transfer/update/{id}', [tellerController::class, 'updateTransfer'])->name('transfer.update');
Route::delete('/transfer/delete/{id}', [tellerController::class, 'destroyTransfer'])->name('transfer.delete');
Route::get('/transfer/struk/{id}',[TellerController::class, 'cetakStrukTransfer'])->name('transfer.struk');
Route::get('/transfer/export/{filter}',[tellerController::class, 'exportTransfer'])->name('transfer.export');
Route::get('/transfer/export-custom',[tellerController::class, 'exportTransferCustom'])->name('transfer.export.custom');

//cari nama si norek
Route::get('/cari-rekening/{norek}', [tellerController::class, 'cariRekening'])->name('transfer.cari_rekening');
Route::get('/search-rekening', [tellerController::class, 'searchRekening'])->name('teller.search_rekening');
});




//customer service
Route::middleware(['role:customerservice'])->group(function () {

Route::get('/siswa/{nis}', [siswaController::class, 'getSiswa']);

route::get('/customerservice/dashboard', [csController::class, 'index'])->name('cs.dashboard');
Route::get('/customerservice/keloladata', [rekeningController::class, 'keloladata'])->name('costumerservice.keloladata');
Route::post('/customer/tambah', [rekeningController::class, 'store'])->name('tambah.rekening');
Route::get('/customer/detail/{id}', [csController::class, 'detail'])->name('detail.nasabah.cs');
Route::get('/customerservice/edit/{id}', [rekeningController::class, 'edit'])->name('edit.nasabah');
Route::put('/customerservice/update/{id}', [rekeningController::class, 'update'])->name('update.nasabah');
Route::delete('/customerservice/hapus/{id}', [rekeningController::class, 'destroy'])->name('hapus.nasabah');

    });
    
    //ROLE SUPERVISOR
    Route::middleware(['role:supervisor'])->group(function () {
        route::get('/supervisor/dashboard', [superVisorController::class, 'index'])->name('supervisor.dashboard');

        Route::get('/supervisor/datanasabah', [superVisorController::class, 'nasabah'])->name('supervisor.datanasabah');

        Route::get('/supervisor/datapetugas', [superVisorController::class, 'datapetugas'])->name('supervisor.datapetugas');

        Route::get('/supervisor/verifikasi', [superVisorController::class, 'transfer'])->name('supervisor.verifikasi');


        Route::get('/supervisor/revisi/{id}', [superVisorController::class, 'halamanRevisi'])->name('halaman.revisi');
        Route::put('/supervisor/revisi/{id}', [superVisorController::class, 'revisi'])->name('proses.revisi');
        Route::get('/supervisor/dataNasabah/{id}', [superVisorController::class, 'detailNasabah'])->name('detail.nasabah');
        Route::get('/supervisor/detail/rekening/{id}', [superVisorController::class, 'detail'])->name('detail.rekening.super');
        Route::delete('/supervisor/hapus/{id}', [superVisorController::class, 'destroy'])->name('hapus.nasabah.super');
        Route::post('/supervisor/aktif/{id}', [superVisorController::class, 'aktif'])->name('rekening.aktif');
        Route::get('/supervisor/verifikasi/rekening/', [superVisorController::class, 'verifikasiNasabah'])->name('verifikasi.rekening');

        
        
        // data petugas
        Route::get('/supervisor/datapetugas', [DataPetugasController::class, 'index'])->name('supervisor.datapetugas');
        Route::post('/datapetugas/store', [DataPetugasController::class, 'store'])->name('datapetugas.store');
        Route::put('/datapetugas/update/{id}', [DataPetugasController::class, 'update'])->name('datapetugas.update');
        Route::delete('/datapetugas/delete/{id}', [DataPetugasController::class, 'destroy'])->name('datapetugas.destroy');
        
        // biaya transaksi
        Route::get('/supervisor/biayatransaksi', [superVisorController::class, 'biayatransaksi'])->name('supervisor.biayatransaksi');
        Route::get('/supervisor/biaya-transaksi',[superVisorController::class, 'biayatransaksi'])->name('supervisor.biayatransaksi');
        Route::post('/supervisor/biaya-transaksi/update',[superVisorController::class, 'updateBiayaTransaksi'])->name('supervisor.biayatransaksi.update');
        
        //View Verifikasi Tf
        Route::get('/supervisor/verifikasi', [superVisorController::class, 'verifikasiTFF'])->name('supervisor.verifikasi');
        Route::get('/admin/produk/search', [superVisorController::class, 'searchData'])->name('supervisor.searchData');

// Export Data Tf
Route::get('/supervisor/export-transfer', [superVisorController::class, 'exportExcel'])->name('supervisor.exportTransfer');

// logika verifikasi Tf
Route::patch('/supervisor/verifikasi/status{id}', [superVisorController::class, 'verifikasiTf'])->name('supervisor.verifikasiTf');

Route::get('/supervisor/verifikasi/registrasi', [superVisorController::class, 'verifikasiNasabah'])->name('supervisor.verifikasi.registrasi');
});
/// logika login na

//Halaman Login
Route::get('/login', [loginController::class, 'index'])->name('login');

//proses login
Route::post('/login', [loginController::class, 'login'])->name('proses.login');

//logout
Route::post('/logout',[loginController::class, 'logout'])->name('logout');


// Route::post('/logout', function () {
    //     return redirect()->route('login');
// })->name('logout');

// Route::post('/login', function () {
//     return redirect()->route('nasabah.dashboard');
// });

Route::get('/cek-rekening/{id}', [Bukti_tfController::class, 'cekRekening']);
/// alamat
Route::get('/get-kabupaten/{id}', [alamatController::class, 'getKabupaten']);
Route::get('/get-kecamatan/{id}', [alamatController::class, 'getKecamatan']);
Route::get('/get-desa/{id}', [alamatController::class, 'getDesa']);
