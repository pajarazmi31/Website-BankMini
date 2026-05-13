<div id="viewEditData" class="fade-in hidden flex-1 mt-4">
    <div class="bg-white rounded-[24px] shadow-card p-6 md:p-10 w-full border border-gray-50">
        
        <!-- SECTION 1: DATA PENYETORAN -->
        <div class="mb-10">
            <div class="flex justify-between items-start mb-8">
                <div class="flex items-center gap-3">
                    <div class="w-[5px] h-6 bg-[#c0860b] rounded-full"></div>
                    <h3 class="text-[20px] font-bold text-gray-800">Edit Data Penyetoran</h3>
                </div>
                <div class="w-full max-w-[200px]">
                    <input type="text" id="edit_petugas" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-[13px] text-gray-500 bg-gray-50/30 focus:outline-none focus:border-[#c0860b] transition-all">
                </div>

            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5 mb-5">
                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">Nama Lengkap</label>
                    <input type="text" id="edit_nama" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-[#c0860b] transition-all">
                </div>
                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">No. Rekening</label>
                    <input type="number" id="edit_rek" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-[#c0860b] transition-all">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-5 mb-5">
                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">Setoran</label>
                    <input type="number" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-[#c0860b] transition-all">
                </div>
                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">Mata Uang</label>
                    <input type="text" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-[#c0860b] transition-all">
                </div>
                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">Nominal Rupiah</label>
                    <input type="number" id="edit_nominal" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-[#c0860b] transition-all">
                </div>
            </div>

            <div>
                <label class="block text-[13px] font-semibold text-gray-500 mb-2">Terbilang</label>
                <input type="text" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-[#c0860b] transition-all">
            </div>
        </div>

        <!-- SECTION 2: DATA PENYETOR -->
        <div class="mb-10">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-[5px] h-6 bg-[#c0860b] rounded-full"></div>
                <h3 class="text-[20px] font-bold text-gray-800">Data Penyetor</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                <div class="flex flex-col gap-5">
                    <div>
                        <label class="block text-[13px] font-semibold text-gray-500 mb-2">Penyetor</label>
                        <input type="text" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-[#c0860b] transition-all">
                    </div>
                    <div class="hidden md:block">
                        <label class="block text-[13px] font-semibold text-gray-500 mb-2">Alamat</label>
                        <textarea class="w-full h-[155px] border border-gray-200 rounded-lg px-4 py-3 text-[14px] text-gray-800 resize-none focus:outline-none focus:border-[#c0860b] transition-all"></textarea>
                    </div>
                </div>
                <div class="flex flex-col gap-5">
                    <div>
                        <label class="block text-[13px] font-semibold text-gray-500 mb-2">No. Rekening/Identitas</label>
                        <input type="number" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-[#c0860b] transition-all">
                    </div>
                    <div>
                        <label class="block text-[13px] font-semibold text-gray-500 mb-2">Nama</label>
                        <input type="text" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-[#c0860b] transition-all">
                    </div>
                    <div>
                        <label class="block text-[13px] font-semibold text-gray-500 mb-2">No. Telepon</label>
                        <input type="number" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-[#c0860b] transition-all">
                    </div>
                </div>
                <div class="md:hidden">
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">Alamat</label>
                    <textarea class="w-full h-[120px] border border-gray-200 rounded-lg px-4 py-3 text-[14px] text-gray-800 resize-none focus:outline-none focus:border-[#c0860b] transition-all"></textarea>
                </div>
            </div>
        </div>

        <!-- SECTION 3: DETAIL TRANSAKSI -->
        <div class="mb-10">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-[5px] h-6 bg-[#c0860b] rounded-full"></div>
                <h3 class="text-[20px] font-bold text-gray-800">Detail Transaksi</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5 mb-5">
                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">Biaya Transaksi</label>
                    <input type="number" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-[#c0860b] transition-all">
                </div>
                <div>
                    <label class="block text-[13px] font-semibold text-gray-500 mb-2">Total Biaya</label>
                    <input type="number" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-[#c0860b] transition-all">
                </div>
            </div>

            <div>
                <label class="block text-[13px] font-semibold text-gray-500 mb-2">Catatan</label>
                <textarea class="w-full h-[120px] border border-gray-200 rounded-lg px-4 py-3 text-[14px] text-gray-800 resize-none focus:outline-none focus:border-[#c0860b] transition-all"></textarea>
            </div>
        </div>

        <!-- BUTTONS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-12">
            <button type="button" onclick="switchView('tabel')" class="w-full bg-[#797979] hover:bg-gray-600 text-white font-bold py-3.5 rounded-xl transition-colors text-[15px]">Kembali</button>
            <button type="submit" class="w-full bg-button-gradient hover:bg-green-700 text-white font-bold py-3.5 rounded-xl transition-colors text-[15px]">Simpan Perubahan</button>
        </div>
    </div>
</div>
