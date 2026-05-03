<div id="viewDetailData" class="fade-in hidden flex-1 mt-4">
    <div class="bg-white rounded-[24px] shadow-card p-6 md:p-10 w-full border border-gray-50">
        
        <div class="flex justify-between items-start mb-8">
            <div class="flex items-center gap-3">
                <div class="w-[5px] h-6 bg-[#c0860b] rounded-full"></div>
                <h3 class="text-[20px] font-bold text-gray-800">Detail Data Transfer</h3>
            </div>
            <div class="w-full max-w-[200px]">
                <input type="text" id="detail_petugas" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-[13px] text-gray-500 bg-gray-50" readonly>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5 mb-5">
            <div>
                <label class="block text-[13px] font-semibold text-gray-500 mb-2">Nama Pengirim</label>
                <input type="text" id="detail_pengirim" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 bg-gray-50" readonly>
            </div>
            <div>
                <label class="block text-[13px] font-semibold text-gray-500 mb-2">Nama Penerima</label>
                <input type="text" id="detail_penerima" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 bg-gray-50" readonly>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5 mb-10">
            <div>
                <label class="block text-[13px] font-semibold text-gray-500 mb-2">Nominal Transfer (Rp)</label>
                <input type="text" id="detail_nominal" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 bg-gray-50" readonly>
            </div>
            <div>
                <label class="block text-[13px] font-semibold text-gray-500 mb-2">Catatan</label>
                <input type="text" value="-" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 bg-gray-50" readonly>
            </div>
        </div>

        <!-- BUTTONS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-8">
            <div class="hidden sm:block"></div>
            <button type="button" onclick="switchView('tabel')" class="w-full bg-[#797979] hover:bg-gray-600 text-white font-bold py-3.5 rounded-xl transition-colors text-[15px]">Kembali</button>
        </div>
    </div>
</div>
