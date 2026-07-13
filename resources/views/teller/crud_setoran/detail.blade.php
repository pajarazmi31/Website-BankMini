@php
    use Carbon\Carbon;
@endphp

<div id="viewDetailData" class="fade-in hidden flex-1 mt-4">
    <div class="bg-white rounded-[24px] shadow-card p-6 md:p-10 w-full border border-gray-50">
        
        <!-- SECTION 1: DATA PENYETORAN -->
        <div class="mb-10">
            <div class="flex justify-between items-start mb-8 gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-[5px] h-6 bg-[#c0860b] rounded-full"></div>
                    <h3 class="text-[20px] font-bold text-gray-800">Detail Data Penyetoran</h3>
                </div>
                <div class="w-full max-w-[200px]">
                    <input type="text" id="detail_petugas" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-[13px] text-gray-500 bg-gray-50 focus:outline-none" readonly>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5 mb-5">
                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">No. Rekening</label>
                    <input type="text" id="detail_rek" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 bg-gray-50 focus:outline-none" readonly>
                </div>
                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">Nama Lengkap</label>
                    <input type="text" id="detail_nama_lengkap" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 bg-gray-50 focus:outline-none" readonly>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-5 mb-5">
                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">Setoran</label>
                    <input type="text" id="detail_setoran" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 bg-gray-50 focus:outline-none" readonly>
                </div>
                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">Mata Uang</label>
                    <input type="text" id="detail_mata_uang" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 bg-gray-50 focus:outline-none" readonly>
                </div>
                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">Nominal Rupiah</label>
                    <input type="text" id="detail_nominal" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 bg-gray-50 focus:outline-none" readonly>
                </div>
            </div>

            <div>
                <label class="block text-[13px] font-semibold text-gray-500 mb-2">Terbilang</label>
                <input type="text" id="detail_terbilang" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-500 bg-gray-50 focus:outline-none" readonly>
            </div>
        </div>

        <!-- SECTION 2: DATA PENYETOR -->
        <div class="mb-10">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-[5px] h-6 bg-[#c0860b] rounded-full"></div>
                <h3 class="text-[20px] font-bold text-gray-800">Data Penyetor</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                <div class="flex flex-col gap-5">
                    <div>
                        <label class="block text-[13px] font-semibold text-gray-500 mb-2">Penyetor</label>
                        <input type="text" id="detail_nama_penyetor" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 bg-gray-50 focus:outline-none" readonly>
                    </div>
                    
                    <div>
                        <label class="block text-[13px] font-semibold text-gray-500 mb-2">Alamat</label>
                        <textarea id="detail_alamat" class="w-full h-[120px] md:h-[155px] border border-gray-200 rounded-lg px-4 py-3 text-[14px] text-gray-800 resize-none bg-gray-50 focus:outline-none" readonly></textarea>
                    </div>
                </div>
                
                <div class="flex flex-col gap-5">
                    <div>
                        <label class="block text-[13px] font-semibold text-gray-500 mb-2">No. Telepon</label>
                        <input type="text" id="detail_no_hp" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 bg-gray-50 focus:outline-none" readonly>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 3: DETAIL TRANSAKSI -->
        <div class="mb-10">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-[5px] h-6 bg-[#c0860b] rounded-full"></div>
                <h3 class="text-[20px] font-bold text-gray-800">Detail Transaksi</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-5 mb-5">
                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">Pilihan Biaya Transaksi</label>
                    <input type="text" id="detail_pilihan_biaya_transaksi" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 bg-gray-50 focus:outline-none" readonly>
                </div>
                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">Biaya Transaksi</label>
                    <input type="text" id="detail_biaya_transaksi" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 bg-gray-50 focus:outline-none" readonly>
                </div>
                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">Total Biaya</label>
                    <input type="text" id="detail_total_biaya" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 bg-gray-50 focus:outline-none" readonly>
                </div>
            </div>

            <div>
                <label class="block text-[13px] font-semibold text-gray-500 mb-2">Catatan</label>
                <textarea id="detail_catatan" class="w-full h-[120px] border border-gray-200 rounded-lg px-4 py-3 text-[14px] text-gray-800 resize-none bg-gray-50 focus:outline-none" readonly></textarea>
            </div>
        </div>

        <!-- BUTTONS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-12">
            <div class="hidden sm:block"></div>
            <button type="button" onclick="switchView('tabel')" class="w-full bg-[#797979] hover:bg-gray-600 text-white font-bold py-3.5 rounded-xl transition-colors text-[15px] shadow-sm">
                Kembali
            </button>
        </div>
    </div>
</div>

<script>
(function() {
    function formatRupiahDetail(angka) {
        if (!angka) return "0";
        let clean = parseInt(angka.toString().replace(/\D/g, '')) || 0;
        return new Intl.NumberFormat('id-ID').format(clean);
    }

    // Fungsi pemicu detail yang disinkronkan dengan data record database bray
    window.lihatDetailSetoran = function(data) {
        if (!data) return;

        // Ambil nama petugas dari relasi, jika tidak ada pakai fallback
        let namaPetugas = data.petugas ? (data.petugas.nama_petugas || data.petugas.name) : '-';

        document.getElementById('detail_petugas').value         = 'Teller: ' + namaPetugas;
        document.getElementById('detail_rek').value             = data.id_rekening || '-';
        document.getElementById('detail_nama_lengkap').value    = data.nama_lengkap || '-';
        document.getElementById('detail_setoran').value         = data.setoran ? data.setoran.toUpperCase() : '-';
        document.getElementById('detail_mata_uang').value       = data.mata_uang ? data.mata_uang.toUpperCase() : 'IDR';
        document.getElementById('detail_pilihan_biaya_transaksi').value  = data.pilihan_biaya_transaksi || 'Cash';

        // Kalkulasi Biaya Transaksi: Total Biaya - Jumlah Penyetoran
        let jumlahPenyetoran = parseInt(data.jumlah_penyetoran) || 0;
        let totalBiaya       = parseInt(data.total_biaya) || 0;
        let biayaTransaksi   = totalBiaya - jumlahPenyetoran;
        if (biayaTransaksi < 0) biayaTransaksi = 0;

        document.getElementById('detail_nominal').value         = 'Rp ' + formatRupiahDetail(jumlahPenyetoran);
        document.getElementById('detail_biaya_transaksi').value = 'Rp ' + formatRupiahDetail(biayaTransaksi);
        document.getElementById('detail_total_biaya').value     = 'Rp ' + formatRupiahDetail(totalBiaya);
        
        document.getElementById('detail_terbilang').value       = data.uang_terbilang || '-';
        document.getElementById('detail_nama_penyetor').value   = data.nama_penyetor || '-';
        document.getElementById('detail_no_hp').value           = data.no_hp_penyetor || '-';
        document.getElementById('detail_alamat').value          = data.alamat_penyetor || '-';
        document.getElementById('detail_catatan').value         = data.catatan || '-';

        if (typeof switchView === "function") {
            switchView('detail'); 
        }
    }
})();
</script>