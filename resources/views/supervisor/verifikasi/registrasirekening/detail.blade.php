<div id="viewDetailData" class="fade-in hidden flex-1 mt-4">
    <div class="bg-white rounded-[24px] shadow-card p-6 md:p-10 w-full border border-gray-50 overflow-y-auto custom-scrollbar">
        <form>
            <!-- SECTION 1: DATA PRIBADI -->
            <div class="mb-12">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-[5px] h-6 bg-[#c0860b] rounded-full"></div>
                    <h3 class="text-[20px] font-bold text-gray-800">Data Pribadi</h3>
                </div>
                
                <div class="space-y-5">
                    <!-- Row 1 -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-500 mb-2">Nama Lengkap</label>
                            <input type="text" id="detail_nama" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-400 bg-white cursor-default focus:outline-none" readonly>
                        </div>
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-500 mb-2">NIS/NIP</label>
                            <input type="text" id="detail_nip" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-400 bg-white cursor-default focus:outline-none" readonly>
                        </div>
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-500 mb-2">Jurusan</label>
                            <input type="text" value="RPL" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-400 bg-white cursor-default focus:outline-none" readonly>
                        </div>
                    </div>

                    <!-- Row 2 -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-500 mb-2">Tempat Lahir</label>
                            <input type="text" value="Ciamis" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-400 bg-white cursor-default focus:outline-none" readonly>
                        </div>
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-500 mb-2">Tanggal Lahir</label>
                            <input type="text" value="12-05-2005" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-400 bg-white cursor-default focus:outline-none" readonly>
                        </div>
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-500 mb-2">Jenis Kelamin</label>
                            <input type="text" value="Laki-laki" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-400 bg-white cursor-default focus:outline-none" readonly>
                        </div>
                    </div>

                    <!-- Row 3 -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-500 mb-2">Jenis Identitas Utama</label>
                            <input type="text" value="Kartu Pelajar" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-400 bg-white cursor-default focus:outline-none" readonly>
                        </div>
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-500 mb-2">Agama</label>
                            <input type="text" value="Islam" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-400 bg-white cursor-default focus:outline-none" readonly>
                        </div>
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-500 mb-2">Pendidikan</label>
                            <input type="text" value="SMK" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-400 bg-white cursor-default focus:outline-none" readonly>
                        </div>
                    </div>

                    <!-- Row 4 -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-500 mb-2">Jabatan</label>
                            <input type="text" id="detail_jabatan" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-400 bg-white cursor-default focus:outline-none" readonly>
                        </div>
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-500 mb-2">Telepon Selular</label>
                            <input type="text" value="08123456789" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-400 bg-white cursor-default focus:outline-none" readonly>
                        </div>
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-500 mb-2">Email</label>
                            <input type="text" value="nasabah@gmail.com" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-400 bg-white cursor-default focus:outline-none" readonly>
                        </div>
                    </div>

                    <!-- Row 5: Alamat Complex -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-500 mb-2">Alamat</label>
                            <textarea class="w-full h-[155px] border border-gray-200 rounded-lg px-4 py-3 text-[14px] text-gray-400 bg-white cursor-default resize-none focus:outline-none" readonly>Dusun Sukajadi, RT 01 RW 02, Desa Kawali, Kecamatan Kawali, Kabupaten Ciamis, Jawa Barat</textarea>
                        </div>
                        <div class="flex flex-col gap-5">
                            <div>
                                <label class="block text-[13px] font-semibold text-gray-500 mb-2">Kelurahan</label>
                                <input type="text" value="Kawali" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-400 bg-white cursor-default focus:outline-none" readonly>
                            </div>
                            <div>
                                <label class="block text-[13px] font-semibold text-gray-500 mb-2">Kecamatan</label>
                                <input type="text" value="Kawali" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-400 bg-white cursor-default focus:outline-none" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Row 6 -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-500 mb-2">Kab/Kota</label>
                            <input type="text" value="Ciamis" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-400 bg-white cursor-default focus:outline-none" readonly>
                        </div>
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-500 mb-2">Provinsi</label>
                            <input type="text" value="Jawa Barat" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-400 bg-white cursor-default focus:outline-none" readonly>
                        </div>
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-500 mb-2">Kode Pos</label>
                            <input type="text" value="46253" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-400 bg-white cursor-default focus:outline-none" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 2: DATA PIHAK YANG DAPAT DIHUBUNGI -->
            <div class="mb-12">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-[5px] h-6 bg-[#c0860b] rounded-full"></div>
                    <h3 class="text-[20px] font-bold text-gray-800">Data Pihak yang Dapat Dihubungi</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                    <div class="space-y-5">
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-500 mb-2">Nama Lengkap</label>
                            <input type="text" value="Asep Saepuloh" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-400 bg-white cursor-default focus:outline-none" readonly>
                        </div>
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-500 mb-2">Telepon Selular</label>
                            <input type="text" value="08987654321" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-400 bg-white cursor-default focus:outline-none" readonly>
                        </div>
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-500 mb-2">Hubungan dengan Pemohon</label>
                            <input type="text" value="Orang Tua" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-400 bg-white cursor-default focus:outline-none" readonly>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[13px] font-semibold text-gray-500 mb-2">Alamat</label>
                        <textarea class="w-full h-[220px] border border-gray-200 rounded-lg px-4 py-3 text-[14px] text-gray-400 bg-white cursor-default resize-none focus:outline-none" readonly>Dusun Sukajadi, RT 01 RW 02, Desa Kawali, Kecamatan Kawali, Kabupaten Ciamis, Jawa Barat</textarea>
                    </div>
                </div>
            </div>

            <!-- SECTION 3: DATA REKENING -->
            <div class="mb-12">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-[5px] h-6 bg-[#c0860b] rounded-full"></div>
                    <h3 class="text-[20px] font-bold text-gray-800">Data Rekening</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[13px] font-semibold text-gray-500 mb-2">No. Rekening</label>
                        <input type="text" id="detail_rek" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-400 bg-white cursor-default focus:outline-none font-bold" readonly>
                    </div>
                    <div>
                        <label class="block text-[13px] font-semibold text-gray-500 mb-2">Status Rekening</label>
                        <input type="text" value="Pending" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-400 bg-white cursor-default focus:outline-none font-bold" readonly>
                    </div>
                </div>
            </div>

            <!-- BUTTONS -->
            <div class="flex justify-center mt-12">
                <button type="button" onclick="switchView('tabel')" class="w-full md:w-[400px] bg-[#797979] hover:bg-gray-600 text-white font-bold py-4 rounded-xl transition-colors text-[15px]">Kembali</button>
            </div>
        </form>
    </div>
</div>
