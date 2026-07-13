<div id="viewTambahData" class="fade-in hidden flex-1 mt-4">

    <form id="tambahPenarikanForm" action="{{ route('penarikan.store') }}" method="POST">
        @csrf

        <div class="bg-white rounded-[24px] shadow-card p-6 md:p-10 w-full border border-gray-50">

            <div class="lg:flex lg:justify-between items-start mb-8">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-[5px] h-6 bg-[#c0860b] rounded-full"></div>
                    <h3 class="text-[20px] font-bold text-gray-800">
                        Data Penarikan
                    </h3>
                </div>

                <div class="w-full lg:max-w-[200px]">
                    <input
                        type="text"
                        value="{{ $user->name }}"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2 text-[13px] text-gray-500 bg-gray-50"
                        readonly>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5 mb-5">

                <!-- BARIS 1 KIRI: NO REKENING -->
                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                        No. Rekening
                    </label>

                    <input type="text"
                        id="tambah_id_rekening"
                        name="id_rekening"
                        inputmode="numeric"
                        autocomplete="off"
                        placeholder="Masukkan nomor rekening"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px]">
                </div>

                <!-- BARIS 1 KANAN: NAMA LENGKAP -->
                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                        Nama Lengkap
                    </label>

                    <input type="text"
                        id="tambah_nama_penarik"
                        name="nama_penarik"
                        readonly
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 bg-gray-50 focus:outline-none">
                </div>

                <!-- BARIS 2: NOMINAL PENARIKAN  -->
                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                        Nominal Penarikan
                    </label>

                    <input type="text"
                        id="tambah_jumlah_penarikan"
                        name="jumlah_penarikan"
                        placeholder="0"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-[#c0860b] transition-all">
                </div>

                <div>
                    <label for="pilihan_biaya_transaksi" class="block text-[13px] font-semibold text-gray-500 mb-2">
                        Pilihan Biaya Transaksi
                    </label>

                    <select
                        id="pilihan_biaya_transaksi"
                        name="pilihan_biaya_transaksi"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-[#c0860b] transition-all"
                        required>

                        <option value="" disabled selected>-- Pilih Metode --</option>

                        <option value="cash">Cash</option>
                        <option value="potong_saldo">Potong Saldo</option>
                    </select>
                </div>

                <!-- BARIS 3 KIRI: BIAYA TRANSAKSI -->
                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                        Biaya Transaksi
                    </label>

                    <input type="text"
                        id="tambah_biaya_transaksi_view"
                        value="{{ number_format($transaksi->nominal ?? 0, 0, ',', '.') }}"
                        readonly
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 bg-gray-50 focus:outline-none">

                    <input type="hidden" id="tambah_biaya_transaksi" value="{{ $transaksi->nominal ?? '0' }}">
                    <input type="hidden" name="transaksi_id" value="{{ $transaksi->id ?? '' }}">
                </div>

                <!-- BARIS 3 KANAN: TOTAL BIAYA -->
                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                        Total Biaya
                    </label>

                    <input type="text"
                        id="tambah_total_biaya_view"
                        readonly
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 bg-gray-50 focus:outline-none">
                    <input type="hidden" name="total_biaya" id="tambah_total_biaya">
                </div>

            </div>

            <!-- BUTTONS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-8">
                <button
                    type="button"
                    onclick="switchView('tabel')"
                    class="w-full bg-[#797979] hover:bg-gray-600 text-white font-bold py-3.5 rounded-xl transition-colors text-[15px]">
                    Kembali
                </button>

                <button
                    type="submit"
                    class="w-full bg-button-gradient hover:bg-green-700 text-white font-bold py-3.5 rounded-xl transition-colors text-[15px]">
                    Kirim
                </button>
            </div>

        </div>

    </form>

</div>

<script>
// Selector dengan ID Baru khusus Form Tambah
const formTambahPenarikan = document.getElementById('tambahPenarikanForm');
const rekeningInputTmb = document.getElementById('tambah_id_rekening');
const namaInputTmb = document.getElementById('tambah_nama_penarik');
const jumlahInputTmb = document.getElementById('tambah_jumlah_penarikan');
const biayaInputTmb = document.getElementById('tambah_biaya_transaksi');
const totalBiayaInputTmb = document.getElementById('tambah_total_biaya');
const totalBiayaViewTmb = document.getElementById('tambah_total_biaya_view');
const pilihanBiayaTmb = document.getElementById('pilihan_biaya_transaksi'); // TAMBAHKAN INI

// Simpan nominal biaya admin asli dari backend ke dalam variabel js
const BIAYA_ADMIN_ASLI = bersihkanAngka(biayaInputTmb.value);

// SALDO
let saldoRekeningTmb = 0;
const saldoMinimum = {{ $saldoMinimum }};

// No Rekening hanya angka
rekeningInputTmb.addEventListener('input', function() {
    this.value = this.value.replace(/\D/g, '');
});

// AJAX Cari Rekening
rekeningInputTmb.addEventListener('keyup', async function() {
    let rekening = this.value.trim();
    if (rekening.length === 0) {
        namaInputTmb.value = '';
        saldoRekeningTmb = 0;
        return;
    }

    try {
        let response = await fetch(`/cari-rekening/${rekening}`);
        let data = await response.json();

        if (data.success) {
            namaInputTmb.value = data.nama;
            saldoRekeningTmb = parseInt(data.saldo);
        } else {
            namaInputTmb.value = 'Rekening tidak ditemukan';
            saldoRekeningTmb = 0;
        }
    } catch (err) {
        namaInputTmb.value = 'Terjadi kesalahan';
        saldoRekeningTmb = 0;
    }
});

// LOGIKA UTILITY ANGKA
function formatAngka(num) {
    return new Intl.NumberFormat('id-ID').format(num);
}

function bersihkanAngka(angka) {
    return parseInt(angka.toString().replace(/\D/g, '')) || 0;
}

function hitungTotal() {
    let nominal = bersihkanAngka(jumlahInputTmb.value);
    let metode = pilihanBiayaTmb.value;
    
    // Logika: jika cash, biaya admin di form jadi 0. Jika potong saldo, pakai biaya asli.
    let biaya = (metode === 'cash') ? 0 : BIAYA_ADMIN_ASLI; 

    // Update view biaya transaksi secara dinamis
    document.getElementById('tambah_biaya_transaksi_view').value = formatAngka(biaya);
    
    let total = nominal + biaya;
    totalBiayaInputTmb.value = total;
    totalBiayaViewTmb.value = formatAngka(total);
}

// Aksi ketika dropdown pilihan biaya transaksi berubah
pilihanBiayaTmb.addEventListener('change', function() {
    hitungTotal();
});

// AUTO FORMAT NOMINAL SAAT INPUT
jumlahInputTmb.addEventListener('input', function() {
    let value = this.value.replace(/\D/g, '');
    this.value = value ? formatAngka(value) : '';
    hitungTotal();
});

// VALIDASI SAAT SUBMIT
formTambahPenarikan.addEventListener('submit', function(e) {
    let nominal = bersihkanAngka(jumlahInputTmb.value);
    let metode = pilihanBiayaTmb.value;
    
    // Di backend/database saldo akan berkurang sebesar nominal penarikan,
    // DAN jika potong_saldo, saldo berkurang lagi sebesar biaya admin.
    let totalPotongKeSaldo = (metode === 'potong_saldo') ? (nominal + BIAYA_ADMIN_ASLI) : nominal;

    let sisaSaldo = saldoRekeningTmb - totalPotongKeSaldo;

    // VALIDASI SALDO MINIMUM
    if (sisaSaldo < saldoMinimum) {
        e.preventDefault();
        alert(
            'Penarikan gagal!\n' +
            'Saldo tidak mencukupi. Sisa saldo minimum setelah penarikan dan biaya admin harus tersisa Rp ' +
            formatAngka(saldoMinimum)
        );
        return;
    }

    // SANITASI ANGKA SEBELUM SUBMIT
    jumlahInputTmb.value = nominal;
});

// Initial Run
hitungTotal();
</script>