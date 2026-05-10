<div id="viewDetailData" class="fade-in hidden flex-1 mt-4">
    <div class="bg-white rounded-[24px] shadow-card p-6 md:p-10 w-full border border-gray-50 overflow-y-auto custom-scrollbar">
        <form>
            <!-- Header Form -->
            <div class="flex items-center gap-3 mb-8">
                <div class="w-[5px] h-6 bg-[#c0860b] rounded-full"></div>
                <h3 class="text-[20px] font-bold text-gray-800">Data Transfer</h3>
            </div>

            <!-- Form Input Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6 mb-6">
                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">Nama Pengirim</label>
                    <input type="text" id="detail_pengirim" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-400 bg-white cursor-default focus:outline-none" readonly>
                </div>
                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">Nama Penerima</label>
                    <input type="text" id="detail_penerima" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-400 bg-white cursor-default focus:outline-none" readonly>
                </div>
                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">Nominal Transfer (Rp)</label>
                    <input type="text" id="detail_nominal" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-400 bg-white cursor-default focus:outline-none" readonly>
                </div>
                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">Nomor Rekening Penerima</label>
                    <input type="text" id="detail_rek_penerima" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-400 bg-white cursor-default focus:outline-none" readonly>
                </div>
                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">Nomor Telepon</label>
                    <input type="text" id="detail_telepon" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-400 bg-white cursor-default focus:outline-none" readonly>
                </div>
                <div class="row-span-2">
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">Catatan</label>
                    <textarea id="detail_catatan" class="w-full h-[125px] border border-gray-200 rounded-lg px-4 py-3 text-[14px] text-gray-400 bg-white cursor-default resize-none focus:outline-none" readonly></textarea>
                </div>
                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">Tanggal Transfer</label>
                    <input type="text" id="detail_tanggal" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-400 bg-white cursor-default focus:outline-none" readonly>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-[13px] font-semibold text-gray-500 mb-2">Bukti Transfer</label>
                <div class="w-full h-[220px] border border-gray-200 rounded-xl bg-white flex items-center justify-center overflow-hidden">
                    <!-- 
                        BAGIAN BACKEND: BUKTI TRANSFER
                        - Tampilkan gambar bukti transfer dari database di sini.
                        - Jika tidak ada gambar, tampilkan placeholder.
                    -->
                    <div id="detail_bukti_container" class="flex flex-col items-center justify-center text-gray-400 gap-2">
                        <i class="ph ph-image text-4xl"></i>
                        <p class="text-[12px]">Bukti transfer belum diunggah</p>
                    </div>
                    <img id="detail_bukti_img" src="#" alt="Bukti Transfer" class="hidden w-full h-full object-contain">
                </div>
            </div>

            <div class="flex justify-end mt-10">
                <button type="button" onclick="switchView('tabel')" class="w-full sm:w-[350px] bg-[#797979] hover:bg-gray-600 text-white font-bold py-4 rounded-xl transition-colors text-[15px]">
                    Kembali
                </button>
            </div>
        </form>
    </div>
</div>
