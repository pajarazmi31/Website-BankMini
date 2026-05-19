<form id="editForm" method="POST">

    @csrf
    @method('PUT')

    <input type="hidden" id="edit_id" name="id">

<div id="viewEditData" class="fade-in hidden flex-1 mt-4">
    <div class="bg-white rounded-[24px] shadow-card p-6 md:p-10 w-full border border-gray-50">

        <!-- SECTION 1 -->
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
                        id="edit_petugas"
                        name="id_petugas"
                        readonly
                        class="w-full border border-gray-200 rounded-lg px-4 py-2 text-[13px]"
                    >
                </div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5 mb-5">

                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                        Nama Lengkap
                    </label>

                    <input
                        type="text"
                        id="edit_nama"
                        name="nama_lengkap"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px]"
                    >
                </div>

                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                        No. Rekening
                    </label>

                    <input
                        type="number"
                        id="edit_rek"
                        name="id_rekening"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px]"
                    >
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
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px]"
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
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px]"
                    >
                </div>

                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                        Nominal Rupiah
                    </label>

                    <input
                        type="number"
                        id="edit_nominal"
                        name="jumlah_penyetoran"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px]"
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
                    class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px]"
                >
            </div>

        </div>

        <!-- SECTION 2 -->
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
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px]"
                        >
                    </div>


                </div>

                <div class="flex flex-col gap-5">

                    <div>
                        <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                            No. Telepon
                        </label>

                        <input
                            type="number"
                            id="edit_nohp"
                            name="no_hp_penyetor"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px]"
                        >
                    </div>

                </div>

                <div class="md:hidden">

                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                        Alamat
                    </label>

                    <textarea
                        id="alamat"
                        name="alamat_penyetor"
                        class="w-full h-[120px] border border-gray-200 rounded-lg px-4 py-3 text-[14px] resize-none"
                    ></textarea>

                </div>

            </div>

        </div>

        <!-- SECTION 3 -->
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

                    <input
                        type="number"
                        id="edit_biaya"
                        name="biaya_transaksi"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px]"
                    >
                </div>

                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                        Total Biaya
                    </label>

                    <input
                        type="number"
                        id="edit_total"
                        name="total_biaya"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px]"
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
                    class="w-full h-[120px] border border-gray-200 rounded-lg px-4 py-3 text-[14px] resize-none"
                ></textarea>

            </div>

        </div>

        <!-- BUTTON -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-12">

            <button
                type="button"
                onclick="switchView('tabel')"
                class="w-full bg-[#797979] text-white font-bold py-3.5 rounded-xl"
            >
                Kembali
            </button>

            <button
                type="submit"
                class="w-full bg-button-gradient text-white font-bold py-3.5 rounded-xl"
            >
                Simpan Perubahan
            </button>

        </div>

    </div>
</div>

</form>