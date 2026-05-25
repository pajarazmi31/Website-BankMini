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
                        value="{{ $teller->nama_petugas }}"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2 text-[13px] text-gray-500 bg-gray-50"
                        readonly
                    >
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
                        placeholder="Masukkan nomor rekening"
                        required
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
                
                <!-- BARIS 2: NOMINAL PENARIKAN (FULL WIDTH - TENGAH PANJANG) -->
                <div class="md:col-span-2">
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                        Nominal Penarikan
                    </label>

                    <input type="text"
                        id="tambah_jumlah_penarikan"
                        name="jumlah_penarikan"
                        placeholder="0"
                        required
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-[#c0860b] transition-all">
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
 
                    <input type="hidden" id="tambah_biaya_transaksi" value="{{ $transaksi->nominal }}">
                    <input type="hidden" name="transaksi_id" value="{{ $transaksi->id }}">
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
                    class="w-full bg-[#797979] hover:bg-gray-600 text-white font-bold py-3.5 rounded-xl transition-colors text-[15px]"
                >
                    Kembali
                </button>

                <button
                    type="submit"
                    class="w-full bg-button-gradient hover:bg-green-700 text-white font-bold py-3.5 rounded-xl transition-colors text-[15px]"
                >
                    Kirim
                </button>
            </div>

        </div>

    </form>

</div>

<script>
// Selector dengan ID Baru khusus Form Tambah
const formTambahPenarikan = document.getElementById('tambahPenarikanForm');
const rekeningInputTmb   = document.getElementById('tambah_id_rekening');
const namaInputTmb       = document.getElementById('tambah_nama_penarik');
const jumlahInputTmb     = document.getElementById('tambah_jumlah_penarikan');
const biayaInputTmb      = document.getElementById('tambah_biaya_transaksi');
const totalBiayaInputTmb = document.getElementById('tambah_total_biaya');
const totalBiayaViewTmb  = document.getElementById('tambah_total_biaya_view');

// SALDO
let saldoRekeningTmb = 0;
const saldoMinimum = 10000;

// 1. AJAX CARI REKENING (Dengan Feedback Warna Merah)
rekeningInputTmb.addEventListener('change', async function () { // Diubah ke 'change' agar lebih stabil
    let rekening = this.value.trim();

    // RESET STYLE AWAL
    namaInputTmb.classList.remove('text-red-500');
    namaInputTmb.classList.add('text-gray-800');

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
            namaInputTmb.classList.remove('text-gray-800');
            namaInputTmb.classList.add('text-red-500'); // Efek merah
            saldoRekeningTmb = 0;
        }
    } catch (err) {
        console.error("Gagal cari rekening:", err);
        namaInputTmb.value = 'Terjadi kesalahan';
        namaInputTmb.classList.remove('text-gray-800');
        namaInputTmb.classList.add('text-red-500'); // Efek merah
        saldoRekeningTmb = 0;
    }
});

// 2. LOGIKA UTILITY ANGKA
function formatAngka(num) {
    return new Intl.NumberFormat('id-ID').format(num);
}

function bersihkanAngka(angka) {
    return parseInt(angka.toString().replace(/\D/g, '')) || 0;
}

function initBiaya() {
    let biayaRaw = bersihkanAngka(biayaInputTmb.value);
    document.getElementById('tambah_biaya_transaksi_view').value = formatAngka(biayaRaw);
}

initBiaya();

function hitungTotal() {
    let nominal = bersihkanAngka(jumlahInputTmb.value);
    let biaya   = bersihkanAngka(biayaInputTmb.value);
    let total   = nominal + biaya;

    totalBiayaInputTmb.value = total;
    totalBiayaViewTmb.value  = formatAngka(total);
}

// 3. AUTO FORMAT NOMINAL SAAT INPUT
jumlahInputTmb.addEventListener('input', function () {
    let value = this.value.replace(/\D/g, '');
    this.value = value ? formatAngka(value) : '';
    hitungTotal();
});

// 4. VALIDASI SAAT SUBMIT
formTambahPenarikan.addEventListener('submit', function(e) {
    let nominal = bersihkanAngka(jumlahInputTmb.value);
    let biaya   = bersihkanAngka(biayaInputTmb.value);
    let totalPotong = nominal + biaya;
    let sisaSaldo = saldoRekeningTmb - totalPotong;

    // VALIDASI SALDO MINIMUM
    if (sisaSaldo < saldoMinimum) {
        e.preventDefault();
        alert('Penarikan gagal!\nSaldo minimum harus tersisa Rp ' + formatAngka(saldoMinimum));
        return;
    }

    // SANITASI ANGKA SEBELUM SUBMIT
    jumlahInputTmb.value = nominal;
    totalBiayaInputTmb.value = totalPotong;
});

// Initial Run
hitungTotal();
</script>