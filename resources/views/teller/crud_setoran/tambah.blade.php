<!-- Container Utama: Pastikan class hidden dilepas via JS switchView -->
<div id="viewTambahData" class="fade-in hidden flex-1 mt-4">
    
    <!-- Form diletakkan langsung di dalam container utama -->
    <form id="formTambahSetoran" action="{{ route('setoran.store') }}" method="POST">
        @csrf

        <div class="bg-white rounded-[24px] shadow-card p-6 md:p-10 w-full border border-gray-50">
            
            <!-- SECTION 1: DATA PENYETORAN -->
            <div class="mb-10">
                <div class="lg:flex lg:justify-between items-start mb-8">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-[5px] h-6 bg-[#c0860b] rounded-full"></div>
                        <h3 class="text-[20px] font-bold text-gray-800">
                            Data Penyetoran
                        </h3>
                    </div>

                    <div class="w-full lg:max-w-[200px]">
                        <input type="text"
                            value="{{ $user->name }}"
                            readonly
                            placeholder="Petugas"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2 text-[13px] text-gray-500 bg-gray-50/30 focus:outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5 mb-5">
                    <!-- KIRI = NO REKENING -->
                    <div>
                        <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                            No. Rekening
                        </label>
                        <input type="text"
                            id="tambah_id_rekening"
                            name="id_rekening"
                            placeholder="Masukkan nomor rekening"
                            required
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-[#c0860b] transition-all">
                    </div>

                    <!-- KANAN = NAMA LENGKAP -->
                    <div>
                        <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                            Nama Lengkap
                        </label>
                        <input type="text"
                            id="tambah_nama_lengkap"
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
                        <select name="setoran"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-[#c0860b] transition-all">
                            <option value="tunai">tunai</option>
                            <option value="warkat">warkat</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                            Mata Uang
                        </label>
                        <input type="text"
                            name="mata_uang"
                            value="rupiah"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-[#c0860b] transition-all">
                    </div>

                    {{-- FIX: Memperbaiki input Nominal Rupiah yang hilang tadi bray --}}
                    <div>
                        <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                            Nominal Rupiah
                        </label>
                        <input type="text"
                            id="jumlah_penyetoran"
                            name="jumlah_penyetoran"
                            required
                            placeholder="0"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-[#c0860b] transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                        Terbilang
                    </label>
                    <input type="text"
                        id="uang_terbilang"
                        name="uang_terbilang"
                        readonly
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-500 bg-gray-50 focus:outline-none">
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
                            <input type="text"
                                name="nama_penyetor"
                                placeholder="Masukkan nama penyetor"
                                required
                                class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-[#c0860b] transition-all">
                        </div>

                        <div class="hidden md:block">
                            <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                                Alamat
                            </label>
                            <textarea name="alamat_penyetor"
                                class="w-full h-[155px] border border-gray-200 rounded-lg px-4 py-3 text-[14px] text-gray-800 resize-none focus:outline-none focus:border-[#c0860b] transition-all"></textarea>
                        </div>
                    </div>

                    <div class="flex flex-col gap-5">
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                                No. Telepon
                            </label>
                            <input type="text"
                                name="no_hp_penyetor"
                                placeholder="Masukkan nomor telepon penyetor"
                                required
                                class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-[#c0860b] transition-all">
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
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5 mb-5">
                    <div>
                        <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                            Biaya Transaksi
                        </label>
                        <input type="text"
                            id="transaksi"
                            value="{{ number_format(optional($transaksi)->nominal ?? 0, 0, ',', '.') }}"
                            readonly
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 bg-gray-50 focus:outline-none">
                        
                        <input type="hidden" name="transaksi_id" value="{{ optional($transaksi)->id ?? '' }}">
                    </div>

                    <div>
                        <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                            Total Biaya
                        </label>
                        <input type="text"
                            id="total_biaya"
                            name="total_biaya"
                            readonly
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 bg-gray-50 focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                        Catatan
                    </label>
                    <textarea name="catatan"
                        class="w-full h-[120px] border border-gray-200 rounded-lg px-4 py-3 text-[14px] text-gray-800 resize-none focus:outline-none focus:border-[#c0860b] transition-all"></textarea>
                </div>
            </div>

            <!-- BUTTONS -->
            <div class="grid grid-cols-2 gap-4 mt-12">
                <button type="button"
                    onclick="switchView('tabel')"
                    class="w-full bg-[#797979] hover:bg-gray-600 text-white font-bold py-3.5 rounded-xl transition-colors text-[15px]">
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
(function() {
    // 1. Fungsi Terbilang Angka
    function terbilang(nilai) {
        nilai = parseInt(nilai);
        if (isNaN(nilai)) return "";
        let huruf = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];
        if (nilai < 12) return huruf[nilai];
        if (nilai < 20) return terbilang(nilai - 10) + " Belas";
        if (nilai < 100) return terbilang(Math.floor(nilai / 10)) + " Puluh " + terbilang(nilai % 10);
        if (nilai < 200) return "Seratus " + terbilang(nilai - 100);
        if (nilai < 1000) return terbilang(Math.floor(nilai / 100)) + " Ratus " + terbilang(nilai % 100);
        if (nilai < 2000) return "Seribu " + terbilang(nilai - 1000);
        if (nilai < 1000000) return terbilang(Math.floor(nilai / 1000)) + " Ribu " + terbilang(nilai % 1000);
        if (nilai < 1000000000) return terbilang(Math.floor(nilai / 1000000)) + " Juta " + terbilang(nilai % 1000000);
        return "";
    }

    // 2. Utility Pembersihan Angka
    function bersihkan(angka) {
        if (!angka) return 0;
        return parseInt(angka.toString().replace(/\D/g, '')) || 0;
    }

    function formatAngka(angka) {
        return new Intl.NumberFormat('id-ID').format(angka);
    }

    // Element Selectors
    const formSetoran = document.getElementById('formTambahSetoran');
    const jumlahInput = document.getElementById('jumlah_penyetoran');
    const terbilangInput = document.getElementById('uang_terbilang');
    const biayaInput = document.getElementById('transaksi');
    const totalBiayaInput = document.getElementById('total_biaya');
    const rekeningInput = document.getElementById('tambah_id_rekening');
    const namaInput = document.getElementById('tambah_nama_lengkap');

    // 3. Fungsi Hitung Total
    function hitungTotalBiaya() {
        let setoran = bersihkan(jumlahInput.value);
        let biaya = bersihkan(biayaInput.value);
        totalBiayaInput.value = formatAngka(setoran + biaya);
    }

    // Jalankan saat load
    setTimeout(hitungTotalBiaya, 100);

    // 4. Input Nominal
    if (jumlahInput) {
        jumlahInput.addEventListener('input', function(e) {
            let angka = e.target.value.replace(/\D/g, '');
            if (!angka) {
                jumlahInput.value = '';
                terbilangInput.value = '';
            } else {
                jumlahInput.value = formatAngka(angka);
                terbilangInput.value = terbilang(parseInt(angka)) + ' Rupiah';
            }
            hitungTotalBiaya();
        });
    }

    // 5. AJAX Cari Rekening (DENGAN WARNA MERAH)
    if(rekeningInput) {
        rekeningInput.addEventListener('change', async function () {
            let rekening = this.value.trim();
            
            // Reset style saat mulai mencari
            namaInput.classList.remove('text-red-500');
            namaInput.classList.add('text-gray-800');

            if (rekening.length === 0) {
                namaInput.value = '';
                return;
            }

            try {
                let response = await fetch(`/cari-rekening/${rekening}`);
                let data = await response.json();

                if (data.success) {
                    namaInput.value = data.nama;
                } else {
                    namaInput.value = 'Rekening tidak ditemukan';
                    namaInput.classList.remove('text-gray-800');
                    namaInput.classList.add('text-red-500'); // Warna merah
                }
            } catch (error) {
                namaInput.value = 'Terjadi kesalahan';
                namaInput.classList.remove('text-gray-800');
                namaInput.classList.add('text-red-500'); // Warna merah
            }
        });
    }

    // 6. Submit (Sanitasi Angka)
    if(formSetoran) {
        formSetoran.addEventListener('submit', function() {
            jumlahInput.value = bersihkan(jumlahInput.value);
            totalBiayaInput.value = bersihkan(totalBiayaInput.value);
        });
    }
})();
</script>