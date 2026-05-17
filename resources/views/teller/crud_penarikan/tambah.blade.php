<div id="viewTambahData" class="fade-in hidden flex-1 mt-4">
    <div class="bg-white rounded-[24px] shadow-card p-6 md:p-10 w-full border border-gray-50">
        
        <div class="lg:flex lg:justify-between items-start mb-8">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-[5px] h-6 bg-[#c0860b] rounded-full"></div>
                <h3 class="text-[20px] font-bold text-gray-800">Data Penarikan</h3>
            </div>
            <div class="w-full lg:max-w-[200px]">
                <div class="relative">
                    <select class="w-full border border-gray-200 rounded-lg px-4 py-2 text-[13px] text-gray-500 bg-gray-50/30 focus:outline-none focus:border-[#c0860b] appearance-none transition-all">
                        <option value="" disabled selected>Petugas</option>
                        <option value="Aditya">Aditya</option>
                        <option value="Dinar">Dinar</option>
                    </select>
                    <i class="ph ph-caret-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5 mb-5">
            <div>
                <label class="block text-[13px] font-semibold text-gray-500 mb-2">Nama Lengkap</label>
                <input type="text" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-[#c0860b] transition-all">
            </div>
            <div>
                <label class="block text-[13px] font-semibold text-gray-500 mb-2">No. Rekening</label>
                <input type="number" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-[#c0860b] transition-all">
            </div>
        </div>

        <div class="mb-10">
            <label class="block text-[13px] font-semibold text-gray-500 mb-2">Nominal Penarikan</label>
            <input type="number" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-[#c0860b] transition-all">
        </div>

        <!-- BUTTONS -->
        <div class="grid grid-cols-2 gap-4 mt-8">
            <button type="button" onclick="switchView('tabel')" class="w-full bg-[#797979] hover:bg-gray-600 text-white font-bold py-3.5 rounded-xl transition-colors text-[15px]">Kembali</button>
            <button type="submit" class="w-full bg-button-gradient hover:bg-green-700 text-white font-bold py-3.5 rounded-xl transition-colors text-[15px]">Kirim</button>
        </div>
    </div>
</div>
