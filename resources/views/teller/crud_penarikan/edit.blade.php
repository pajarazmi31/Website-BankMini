<div id="viewEditData" class="fade-in hidden flex-1 mt-4">

    <form id="editForm" method="POST">

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
                        id="edit_petugas"
                        name="id_petugas"
                        readonly
                        class="w-full border border-gray-200 rounded-lg px-4 py-2 text-[13px]"
                    >
                </div>

            </div>

            <input type="hidden" id="edit_id">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5 mb-5">

                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                        Nama Lengkap
                    </label>

                    <input
                        type="text"
                        name="nama_penarik"
                        id="edit_nama"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px]"
                    >
                </div>

                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                        No. Rekening
                    </label>

                    <input
                        type="number"
                        name="id_rekening"
                        id="edit_rek"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px]"
                    >
                </div>

            </div>

            <div class="mb-10">

                <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                    Nominal Penarikan
                </label>

                <input
                    type="number"
                    name="jumlah_penarikan"
                    id="edit_nominal"
                    class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px]"
                >

            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-8">

                <button
                    type="button"
                    onclick="switchView('tabel')"
                    class="w-full bg-[#797979] hover:bg-gray-600 text-white font-bold py-3.5 rounded-xl"
                >
                    Kembali
                </button>

                <button
                    type="submit"
                    class="w-full bg-button-gradient hover:bg-green-700 text-white font-bold py-3.5 rounded-xl"
                >
                    Simpan Perubahan
                </button>

            </div>

        </div>

    </form>

</div>