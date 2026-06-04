<form id="editForm" method="POST">
    @csrf
    @method('PUT')

    <input type="hidden" id="edit_id" name="id">
    <input type="hidden" id="edit_transaksi_id" name="transaksi_id">

    <div id="viewEditData" class="fade-in flex-1 mt-4 hidden">

        <div class="bg-white rounded-[24px] shadow-card p-6 md:p-10 w-full border border-gray-50">

            <!-- HEADER -->
            <div class="lg:flex lg:justify-between items-start mb-8">

                <div class="flex items-center gap-3 mb-3">
                    <div class="w-[5px] h-6 bg-[#c0860b] rounded-full"></div>

                    <h3 class="text-[20px] font-bold text-gray-800">
                        Edit Data Transfer
                    </h3>
                </div>

                <div class="w-full lg:max-w-[200px]">
                    <input type="text"
                        value="{{ $teller->nama_petugas }}"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2 text-[13px] text-gray-500 bg-gray-50"
                        readonly>
                </div>
            </div>

            <!-- REKENING -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5 mb-5">

                <!-- PENGIRIM -->
                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                        Norek. Pengirim
                    </label>

                    <input
                        type="text"
                        id="edit_id_rekening_pengirim"
                        name="id_rekening_pengirim"
                        onkeyup="cekRekeningTransfer('edit', 'pengirim')"
                        required
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-[#c0860b] transition-all"
                    >

                    <div id="edit_info_pengirim"
                        class="text-xs text-gray-400 mt-1 mb-1 min-h-[16px]">
                    </div>
                </div>

                <!-- PENERIMA -->
                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                        Norek. Penerima
                    </label>

                    <input
                        type="text"
                        id="edit_id_rekening_penerima"
                        name="id_rekening_penerima"
                        onkeyup="cekRekeningTransfer('edit', 'penerima')"
                        required
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-[#c0860b] transition-all"
                    >

                    <div id="edit_info_penerima"
                        class="text-xs text-gray-400 mt-1 mb-1 min-h-[16px]">
                    </div>
                </div>
            </div>

            <!-- NOMINAL -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5 mb-10">

                <!-- JUMLAH -->
                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                        Nominal Transfer (Rp)
                    </label>

                    <input
                        type="text"
                        id="edit_jumlah_transfer"
                        name="jumlah_transfer"
                        required
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-[#c0860b] transition-all"
                    >
                </div>

                <!-- CATATAN -->
                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                        Catatan (Opsional)
                    </label>

                    <input
                        type="text"
                        id="edit_catatan"
                        name="catatan"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-[#c0860b] transition-all"
                    >
                </div>

                <!-- BIAYA -->
                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                        Biaya Transaksi (Rp)
                    </label>

                    <input
                        type="text"
                        id="edit_biaya_transaksi_view"
                        readonly
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 bg-gray-50"
                    >

                    <input
                        type="hidden"
                        id="edit_biaya_transaksi"
                        name="biaya_transaksi"
                    >
                </div>

                <!-- TOTAL -->
                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                        Total Biaya (Rp)
                    </label>

                    <input
                        type="text"
                        id="edit_total_biaya_view"
                        readonly
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 bg-gray-50"
                    >

                    <input
                        type="hidden"
                        id="edit_total_biaya"
                        name="total_biaya"
                    >
                </div>
            </div>

            <!-- BUTTON -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-8 w-full">

                <button
                    type="button"
                    onclick="switchView('tabel')"
                    class="w-full bg-[#797979] hover:bg-gray-600 text-white font-bold py-3.5 rounded-xl transition-colors text-[15px]">
                    Kembali
                </button>

                <button
                    type="submit"
                    class="w-full bg-button-gradient hover:bg-green-700 text-white font-bold py-3.5 rounded-xl transition-colors text-[15px]">
                    Simpan Perubahan
                </button>

            </div>
        </div>
    </div>
</form>

<script>
    // ================= EDIT TOTAL =================
    function calculateEditTotal() {

        const transferInput = document.getElementById('edit_jumlah_transfer');

        const biayaInput = document.getElementById('edit_biaya_transaksi');

        const biayaView = document.getElementById('edit_biaya_transaksi_view');

        const totalInput = document.getElementById('edit_total_biaya');

        const totalView = document.getElementById('edit_total_biaya_view');

        if (!transferInput || !biayaInput) return;

        let nominal = cleanNumber(transferInput.value);

        let biaya = BIAYA_ADMIN_MASTER;

        let total = nominal + biaya;

        biayaInput.value = biaya;

        biayaView.value = formatNumber(biaya);

        totalInput.value = total;

        totalView.value = formatNumber(total);
    }

    // FORMAT RUPIAH EDIT
    document.getElementById('edit_jumlah_transfer')
    ?.addEventListener('input', function () {

        let angka = this.value.replace(/\D/g, '');

        this.value = angka ? formatNumber(angka) : '';

        calculateEditTotal();
    });
</script>