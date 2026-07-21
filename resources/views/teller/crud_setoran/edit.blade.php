<form id="editForm" method="POST">
    @csrf
    @method('PUT')

    <input type="hidden" id="edit_id" name="id">

    <div id="viewEditData" class="fade-in hidden flex-1 mt-4">
        <div class="bg-white rounded-[24px] shadow-card p-6 md:p-10 w-full border border-gray-50">

            <!-- SECTION 1: DATA PENYETORAN -->
            <div class="mb-10">
                <div class="lg:flex lg:justify-between items-start mb-8">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-[5px] h-6 bg-[#c0860b] rounded-full"></div>
                        <h3 class="text-[20px] font-bold text-gray-800">
                            Edit Data Penyetoran
                        </h3>
                    </div>

                    <div class="w-full lg:max-w-[200px]">
                        <input
                            type="text"
                            value="{{ $user->name }}"
                            id="edit_petugas"
                            name="id_petugas"
                            readonly
                            class="w-full border border-gray-200 rounded-lg px-4 py-2 text-[13px] text-gray-500 bg-gray-50 focus:outline-none"
                        >
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5 mb-5">
                    <!-- KIRI = NO REKENING -->
                    <div>
                        <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                            No. Rekening
                        </label>
                            <input type="text"
                                id="id_rekening"
                                name="id_rekening"
                                inputmode="numeric"
                                autocomplete="off"
                                required
                                class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-[#c0860b] transition-all">                    
                            </div>

                    <!-- KANAN = NAMA LENGKAP -->
                    <div>
                        <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                            Nama Lengkap
                        </label>
                        <input type="text"
                            id="nama_lengkap"
                            name="nama_lengkap"
                            readonly
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 bg-gray-50 focus:outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-5 mb-5">
                    <div>
                        <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                            Setoran
                        </label>
                        <input
                            type="text"
                            id="edit_setoran"
                            name="setoran"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-[#c0860b] transition-all"
                        >
                    </div>

                    <div>
                        <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                            Mata Uang
                        </label>
                        <input
                            type="text"
                            id="edit_mata_uang"
                            name="mata_uang"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-[#c0860b] transition-all"
                        >
                    </div>

                    <div>
                        <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                            Nominal Rupiah
                        </label>
                        <input
                            type="text"
                            id="edit_nominal"
                            name="jumlah_penyetoran"
                            required
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-[#c0860b] transition-all"
                        >
                    </div>
                </div>

                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                        Terbilang
                    </label>
                    <input
                        type="text"
                        id="edit_terbilang"
                        name="uang_terbilang"
                        readonly
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-500 bg-gray-50 focus:outline-none"
                    >
                </div>
            </div>

            <!-- SECTION 2: DATA PENYETOR -->
            <div class="mb-10">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-[5px] h-6 bg-[#c0860b] rounded-full"></div>
                    <h3 class="text-[20px] font-bold text-gray-800">
                        Data Penyetor
                    </h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                    <div class="flex flex-col gap-5">
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                                Penyetor
                            </label>
                            <input
                                type="text"
                                id="edit_penyetor"
                                name="nama_penyetor"
                                required
                                class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-[#c0860b] transition-all"
                            >
                        </div>

                        <!-- FIX ID SINKRON: ID diubah menjadi edit_alamat agar unik dan mudah dipanggil javascript -->
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                                Alamat
                            </label>
                            <textarea
                                id="edit_alamat"
                                name="alamat_penyetor"
                                class="w-full h-[155px] border border-gray-200 rounded-lg px-4 py-3 text-[14px] text-gray-800 resize-none focus:outline-none focus:border-[#c0860b] transition-all"
                            ></textarea>
                        </div>
                    </div>

                    <div class="flex flex-col gap-5">
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                                No. Telepon
                            </label>
                            <input
                                type="text"
                                id="edit_nohp"
                                name="no_hp_penyetor"
                                required
                                class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-[#c0860b] transition-all"
                            >
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 3: DETAIL TRANSAKSI -->
            <div class="mb-10">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-[5px] h-6 bg-[#c0860b] rounded-full"></div>
                    <h3 class="text-[20px] font-bold text-gray-800">
                        Detail Transaksi
                    </h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-5 mb-5">
                    <div>
                        <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                            Pilihan Biaya Transaksi
                        </label>
                        <select
                            name="pilihan_biaya_transaksi"
                            id="edit_pilihan_biaya_transaksi"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-[#c0860b] transition-all"
                            required>
                            <option value="Cash">Cash</option>
                            <option value="Potong Saldo">Potong Saldo</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                            Biaya Transaksi
                        </label>
                        <input
                            type="text"
                            id="edit_biaya"
                            name="biaya_transaksi"
                            readonly
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 bg-gray-50 focus:outline-none"
                        >
                        <!-- Tambahkan ini di dalam <form id="editForm"> -->
                            <input type="hidden" name="transaksi_id" id="edit_transaksi_id">
                    </div>

                    <div>
                        <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                            Total Biaya
                        </label>
                        <input
                            type="text"
                            id="edit_total"
                            name="total_biaya"
                            readonly
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 bg-gray-50 focus:outline-none"
                        >
                    </div>
                </div>

                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                        Catatan
                    </label>
                    <textarea
                        id="edit_catatan"
                        name="catatan"
                        class="w-full h-[120px] border border-gray-200 rounded-lg px-4 py-3 text-[14px] text-gray-800 resize-none focus:outline-none focus:border-[#c0860b] transition-all"
                    ></textarea>
                </div>
            </div>

            <!-- BUTTONS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-12">
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
                    Simpan Perubahan
                </button>
            </div>

        </div>
    </div>
</form>

<script>
    // 1. FUNGSI HELPER (Dibuat Global agar bisa diakses fungsi edit)
    window.terbilangEdit = function(nilai) {
        nilai = parseInt(nilai);
        if (isNaN(nilai) || nilai === 0) return "Nol";
        let huruf = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];
        if (nilai < 12) return huruf[nilai];
        if (nilai < 20) return terbilangEdit(nilai - 10) + " Belas";
        if (nilai < 100) return terbilangEdit(Math.floor(nilai / 10)) + " Puluh " + terbilangEdit(nilai % 10);
        if (nilai < 200) return "Seratus " + terbilangEdit(nilai - 100);
        if (nilai < 1000) return terbilangEdit(Math.floor(nilai / 100)) + " Ratus " + terbilangEdit(nilai % 100);
        if (nilai < 2000) return "Seribu " + terbilangEdit(nilai - 1000);
        if (nilai < 1000000) return terbilangEdit(Math.floor(nilai / 1000)) + " Ribu " + terbilangEdit(nilai % 1000);
        if (nilai < 1000000000) return terbilangEdit(Math.floor(nilai / 1000000)) + " Juta " + terbilangEdit(nilai % 1000000);
        return "";
    };

    window.bersihkanEdit = function(angka) {
        if (!angka) return 0;
        let str = angka.toString().trim();
        if (str.includes('.') && !str.includes(',')) str = str.replace(/\./g, '');
        return parseInt(str.replace(/\D/g, '')) || 0;
    };

    window.formatMataUangEdit = function(angka) {
        return new Intl.NumberFormat('id-ID').format(angka);
    };


    function hitungTotalEdit() {
        let setoran = bersihkanEdit(document.getElementById('edit_nominal').value);
        let biaya = bersihkanEdit(document.getElementById('edit_biaya').value);
        document.getElementById('edit_total').value = formatMataUangEdit(setoran + biaya);
    }

    // 3. EVENT LISTENERS
    document.addEventListener('DOMContentLoaded', function() {
        const editNominal = document.getElementById('edit_nominal');
        const editBiaya = document.getElementById('edit_biaya');
        const editRekening = document.getElementById('id_rekening');

                document.getElementById('edit_nohp')
        ?.addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, '');
        });

        editNominal.addEventListener('input', (e) => {
            let val = e.target.value.replace(/\D/g, '');
            editNominal.value = formatMataUangEdit(val);
            document.getElementById('edit_terbilang').value = terbilangEdit(val) + ' Rupiah';
            hitungTotalEdit();
        });

        editBiaya.addEventListener('input', () => {
            editBiaya.value = formatMataUangEdit(bersihkanEdit(editBiaya.value));
            hitungTotalEdit();
        });

        editRekening.addEventListener('input', async function () {

            // Hapus semua selain angka
            this.value = this.value.replace(/\D/g, '');

            let rekening = this.value.trim();

    if (rekening.length === 0) {
        document.getElementById('nama_lengkap').value = '';
        return;
    }

    try {

        let res = await fetch(`/cari-rekening/${rekening}`);
        let data = await res.json();

        if (data.success) {

            document.getElementById('nama_lengkap').value = data.nama;

        } else {

            document.getElementById('nama_lengkap').value =
                'Rekening tidak ditemukan';

        }

    } catch (err) {

        console.log(err);

        document.getElementById('nama_lengkap').value =
            'Rekening tidak ditemukan';

    }

    });
});
</script>