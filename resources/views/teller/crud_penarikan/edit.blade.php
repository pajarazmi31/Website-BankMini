<div id="viewEditData" class="fade-in hidden flex-1 mt-4">

    <!-- ID Form disesuaikan menjadi editForm agar pas dengan script utama lu -->
    <form id="editPenarikanForm" method="POST">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-[24px] shadow-card p-6 md:p-10 w-full border border-gray-50">

            <div class="lg:flex lg:justify-between items-start mb-8">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-[5px] h-6 bg-[#c0860b] rounded-full"></div>
                    <h3 class="text-[20px] font-bold text-gray-800">
                        Edit Data Penarikan
                    </h3>
                </div>

                <div class="w-full lg:max-w-[200px]">
                    <input
                        type="text"
                        value="{{ $user->name }}"
                        id="edit_petugas"
                        name="id_petugas"
                        readonly
                        class="w-full border border-gray-200 rounded-lg px-4 py-2 text-[13px] text-gray-500 bg-gray-50">
                </div>
            </div>

            <!-- Ditambahkan name="id" agar ID datanya terkirim ke backend -->
            <input type="hidden" id="edit_id" name="id">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5 mb-5">


                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                        No. Rekening
                    </label>

                    <input
                        type="text"
                        name="id_rekening"
                        id="edit_id_rekening"
                        inputmode="numeric"
                        autocomplete="off"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px]">
                </div>

                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                        Nama Lengkap
                    </label>

                    <input
                        type="text"
                        name="nama_penarik"
                        id="edit_nama_penarik"
                        readonly
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 bg-gray-50 text-[14px]">
                </div>

            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5 mb-5">
                <div class="mb-5">
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                        Nominal Penarikan
                    </label>

                    <input
                        type="text"
                        name="jumlah_penarikan"
                        id="edit_jumlah_penarikan"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px]">
                </div>
                <div class="mb-5">
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                        Pilihan Biaya Transaksi
                    </label>

                    <select
                        name="pilihan_biaya_transaksi" id="edit_pilihan_biaya_transaksi"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-[#c0860b] transition-all"
                        required>
                        <option value="cash">Cash</option>
                        <option value="potong_saldo">Potong Saldo</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5 mb-5">

                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                        Biaya Transaksi
                    </label>

                    <input
                        type="text"
                        id="edit_biaya_transaksi"
                        readonly
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 bg-gray-50 text-[14px]">

                    <input type="hidden" id="edit_transaksi_id" name="transaksi_id">
                </div>

                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                        Total Biaya
                    </label>

                    <input
                        type="text"
                        id="edit_total_biaya"
                        readonly
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 bg-gray-50 text-[14px]">

                    <input type="hidden" id="edit_total" name="total_biaya">
                </div>

            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-8">

                <button
                    type="button"
                    onclick="switchView('tabel')"
                    class="w-full bg-[#797979] hover:bg-gray-600 text-white font-bold py-3.5 rounded-xl">
                    Kembali
                </button>

                <button
                    type="submit"
                    class="w-full bg-button-gradient hover:bg-green-700 text-white font-bold py-3.5 rounded-xl">
                    Simpan Perubahan
                </button>

            </div>

        </div>

    </form>

</div>

<script>
    const formEditPenarikan = document.getElementById('editPenarikanForm');

    const rekeningInputEdit = document.getElementById('edit_id_rekening');
    const namaInputEdit = document.getElementById('edit_nama_penarik');
    const jumlahInputEdit = document.getElementById('edit_jumlah_penarikan');

    const biayaViewEdit = document.getElementById('edit_biaya_transaksi');
    const pilihanBiayaEdit = document.getElementById('pilihan_biaya_transaksi');
    const biayaInputEdit = document.getElementById('edit_transaksi_id');

    const totalViewEdit = document.getElementById('edit_total_biaya');
    const totalInputEdit = document.getElementById('edit_total');

    rekeningInputEdit?.addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '');
    });

    function formatAngka(num) {
        return new Intl.NumberFormat('id-ID').format(num);
    }

    function bersihkanAngka(angka) {
        return parseInt(angka.toString().replace(/\D/g, '')) || 0;
    }

    function hitungTotal() {
        let nominal = bersihkanAngka(jumlahInputEdit.value);
        let biaya = bersihkanAngka(biayaViewEdit.value);

        let total = nominal + biaya;

        totalInputEdit.value = total;
        totalViewEdit.value = 'Rp. ' + formatAngka(total);
    }

    jumlahInputEdit?.addEventListener('input', function() {
        let value = this.value.replace(/\D/g, '');
        this.value = value ? formatAngka(value) : '';
        hitungTotal();
    });

    pilihanBiayaEdit?.addEventListener('change', function() {
        hitungTotal();
    });

    formEditPenarikan?.addEventListener('submit', function(e) {
        jumlahInputEdit.value = bersihkanAngka(jumlahInputEdit.value);
    });

    hitungTotal();
</script>