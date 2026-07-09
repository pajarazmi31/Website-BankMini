@if(session('success'))
    <div style="background: #d4edda; color: #155724; padding: 15px; margin-bottom: 20px; border-radius: 8px;">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div style="background: #f8d7da; color: #721c24; padding: 15px; margin-bottom: 20px; border-radius: 8px;">
        <strong>Eror Terjadi Bray!</strong> {{ session('error') }}
    </div>
@endif

<form action="{{ route('transfer.store') }}" method="POST" id="formTransaksiTransfer">
    @csrf

    <div id="viewTambahData" class="fade-in flex-1 mt-4 hidden">

        <div class="bg-white rounded-[24px] shadow-card p-6 md:p-10 w-full border border-gray-50">
            
            <div class="lg:flex lg:justify-between items-start mb-8">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-[5px] h-6 bg-[#c0860b] rounded-full"></div>
                    <h3 class="text-[20px] font-bold text-gray-800">
                        Form Transaksi Transfer Baru
                    </h3>
                </div>

                <div class="w-full lg:max-w-[200px]">
                    <input type="text" 
                        value="{{ $user->name }}" 
                        class="w-full border border-gray-200 rounded-lg px-4 py-2 text-[13px] text-gray-500 bg-gray-50" 
                        readonly>
                    
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5 mb-5">
                <div class="relative">
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                        Norek. Pengirim
                    </label>
                    <input
                        type="text"
                        id="tambah_id_rekening_pengirim"
                        name="id_rekening_pengirim"
                        autocomplete="off"
                        placeholder="Masukkan nomor rekening pengirim"
                        required
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-[#c0860b] transition-all"
                    >
                    <div id="tambah_rekening_pengirim_suggestions" class="absolute left-0 right-0 mt-1 bg-white border border-gray-200 rounded-xl shadow-lg z-50 max-h-60 overflow-y-auto hidden animate-fade-in"></div>
                    <div id="tambah_info_pengirim" class="text-xs text-gray-400 mt-1 mb-1 min-h-[16px]"></div>
                </div>

                <div class="relative">
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                        Norek. Penerima
                    </label>
                    <input
                        type="text"
                        id="tambah_id_rekening_penerima"
                        name="id_rekening_penerima"
                        autocomplete="off"
                        placeholder="Masukkan nomor rekening penerima"
                        required
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-[#c0860b] transition-all"
                    >
                    <div id="tambah_rekening_penerima_suggestions" class="absolute left-0 right-0 mt-1 bg-white border border-gray-200 rounded-xl shadow-lg z-50 max-h-60 overflow-y-auto hidden animate-fade-in"></div>
                    <div id="tambah_info_penerima" class="text-xs text-gray-400 mt-1 mb-1 min-h-[16px]"></div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5 mb-10">
                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                        Nominal Transfer (Rp)
                    </label>
                    <input
                        type="text"
                        id="tambah_jumlah_transfer"
                        name="jumlah_transfer"
                        placeholder="0"
                        required
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-[#c0860b] transition-all"
                    >
                </div>

                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                        Catatan (Opsional)
                    </label>
                    <input
                        type="text"
                        name="catatan"
                        placeholder="Contoh: Bayar Kos / Keperluan Keluarga"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-[#c0860b] transition-all"
                    >
                </div>

                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                        Biaya Transaksi (Rp)
                    </label>
                    <input
                        type="text"
                        id="tambah_biaya_transaksi_view"
                        value="{{ number_format($transaksi->nominal ?? 0, 0, ',', '.') }}"
                        readonly
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 bg-gray-50 focus:outline-none"
                    >

                    <input type="hidden" name="transaksi_id" value="{{ $transaksi->id ?? '' }}">
                    <input type="hidden" id="tambah_biaya_transaksi" name="biaya_transaksi" value="{{ $transaksi->nominal ?? 0 }}">

                    <input
                        type="hidden"
                        id="tambah_biaya_transaksi"
                        name="biaya_transaksi"
                        value="{{ $transaksi->nominal ?? 0 }}"
                    >
                </div>

                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                        Total Biaya (Rp)
                    </label>

                    <input
                        type="text"
                        id="tambah_total_biaya_view"
                        readonly
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 bg-gray-50 focus:outline-none transition-all"
                    >

                    <input
                        type="hidden"
                        id="tambah_total_biaya"
                        name="total_biaya"
                    >
                </div>

            </div> 

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-8 w-full">
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

    </div>
</form>

<script>
// 1. UTILITY HITUNG DAN FORMAT ANGKA
function cleanNumber(value) {
    return parseInt(value.toString().replace(/\D/g, '')) || 0;
}

function formatNumber(num) {
    return new Intl.NumberFormat('id-ID').format(num);
}

function calculateTotal() {
    const transferInput = document.getElementById('tambah_jumlah_transfer');
    const biayaInput    = document.getElementById('tambah_biaya_transaksi');
    const biayaView     = document.getElementById('tambah_biaya_transaksi_view');
    const totalInput    = document.getElementById('tambah_total_biaya');
    const totalView     = document.getElementById('tambah_total_biaya_view');

    if (!transferInput || !biayaInput) return;

    let nominal = cleanNumber(transferInput.value);
    let biaya   = cleanNumber(biayaInput.value);
    let total   = nominal + biaya;

    if (biayaView) biayaView.value  = formatNumber(biaya);
    if (totalInput) totalInput.value = total;
    if (totalView) totalView.value  = formatNumber(total);
}

// 2. LISTEN INPUT TRANSFER (OTOMATIS RUPIAH & HITUNG)
document.getElementById('tambah_jumlah_transfer')?.addEventListener('input', function () {
    let angka = this.value.replace(/\D/g, '');
    this.value = angka ? formatNumber(angka) : '';
    calculateTotal();
});

// 3. FUNGSI AJAX CEK REKENING UNIK UNTUK TRANSFER (Plus Validasi Rekening Sama)
async function cekRekeningTransfer(aksi, tipe) {
    const pengirimInput = document.getElementById('tambah_id_rekening_pengirim');
    const penerimaInput = document.getElementById('tambah_id_rekening_penerima');
    const infoPengirim  = document.getElementById('tambah_info_pengirim');
    const infoPenerima  = document.getElementById('tambah_info_penerima');

    let inputTarget = (tipe === 'pengirim') ? pengirimInput : penerimaInput;
    let infoTarget  = (tipe === 'pengirim') ? infoPengirim : infoPenerima;
    
    if (!inputTarget || !infoTarget) return;

    let rekening = inputTarget.value.trim();

    if (rekening.length === 0) {
        infoTarget.innerHTML = '';
        return;
    }

    // --- VALIDASI REKENING SAMA ---
    let norekPengirim = pengirimInput.value.trim();
    let norekpenerima = penerimaInput.value.trim();

    if (norekPengirim !== '' && norekpenerima !== '' && norekPengirim === norekpenerima) {
        infoTarget.innerHTML = `<span class="text-red-500">❌ Rekening pengirim & penerima tidak boleh sama!</span>`;
        return; 
    }

    try {
        let response = await fetch(`/cari-rekening/${rekening}`);
        let data = await response.json();

        if (data.success) {
            if (tipe === 'pengirim' && data.saldo !== undefined) {
                let saldoFormat = new Intl.NumberFormat('id-ID').format(data.saldo);
                infoTarget.innerHTML = `<span class="text-green-600 font-medium">✓ ${data.nama}</span> | Saldo: Rp. ${saldoFormat}`;
            } else {
                infoTarget.innerHTML = `<span class="text-green-600 font-medium">✓ ${data.nama}</span>`;
            }
        } else {
            infoTarget.innerHTML = `<span class="text-red-500">❌ Rekening tidak ditemukan</span>`;
        }
    } catch (error) {
        console.error("Gagal memuat data rekening:", error);
        infoTarget.innerHTML = `<span class="text-red-400">⚠️ Gagal memverifikasi data</span>`;
    }
}

// 4. JALANKAN TOTALAN PERTAMA KALI SAAT HALAMAN DIBUKA (Tanpa Intervensi Submit)
document.addEventListener('DOMContentLoaded', function() {
    calculateTotal();
});
</script>