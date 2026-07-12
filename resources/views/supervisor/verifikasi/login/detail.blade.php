<div id="viewDetailLogin"
    class="fade-in hidden flex-1 mt-4">

    <div class="bg-white rounded-[24px] shadow-card p-6 md:p-10 w-full">

        <div class="flex items-center gap-3 mb-8">
            <div class="w-[5px] h-6 bg-[#c0860b] rounded-full"></div>
            <h3 class="text-[20px] font-bold text-gray-800">
                Detail Verifikasi Login
            </h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                    ID Verifikasi
                </label>

                <input type="text"
                    id="detail_id"
                    readonly
                    class="w-full border border-gray-200 rounded-lg px-4 py-2.5">
            </div>

            <div>
                <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                    Nama
                </label>

                <input type="text"
                    id="detail_nama"
                    readonly
                    class="w-full border border-gray-200 rounded-lg px-4 py-2.5">
            </div>

            <div>
                <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                    Email
                </label>

                <input type="text"
                    id="detail_email"
                    readonly
                    class="w-full border border-gray-200 rounded-lg px-4 py-2.5">
            </div>

            <div>
                <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                    Role
                </label>

                <input type="text"
                    id="detail_role"
                    readonly
                    class="w-full border border-gray-200 rounded-lg px-4 py-2.5">
            </div>

            <div>
                <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                    Waktu Login
                </label>

                <input type="text"
                    id="detail_login"
                    readonly
                    class="w-full border border-gray-200 rounded-lg px-4 py-2.5">
            </div>

            <div>
                <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                    Waktu Verifikasi
                </label>

                <input type="text"
                    id="detail_verifikasi"
                    readonly
                    class="w-full border border-gray-200 rounded-lg px-4 py-2.5">
            </div>

            <div class="md:col-span-2">
                <label class="block text-[13px] font-semibold text-gray-500 mb-2">
                    Status
                </label>

                <input type="text"
                    id="detail_status"
                    readonly
                    class="w-full border border-gray-200 rounded-lg px-4 py-2.5">
            </div>

        </div>

        <div class="flex justify-end mt-10">

            <button
                type="button"
                onclick="switchView('viewTabel')"
                class="w-full sm:w-[350px] bg-gray-600 text-white font-bold py-4 rounded-xl">

                Kembali

            </button>

        </div>

    </div>

</div>