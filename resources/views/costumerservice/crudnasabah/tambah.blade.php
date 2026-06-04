<div id="viewTambahData" class="fade-in hidden flex-1 mt-4">
    <div class="bg-white rounded-[24px] shadow-card p-6 md:p-10 w-full border border-gray-50">
        <form action="{{ route('tambah.rekening') }}" method="POST" id="nasabahFormTambah">
            @csrf

            <!-- SECTION 1: DATA PRIBADI -->
            <div class="mb-10">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-[5px] h-6 bg-[#c0860b] rounded-full"></div>
                    <h3 class="text-[20px] font-bold text-gray-800">Data Pribadi</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-5">
                    <div>
                        <label class="block text-[13px] font-semibold text-gray-500 mb-2">NIS/NIP</label>
                        <input type="number" name="nis_nip" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition-colors">
                    </div>
                    <div>
                        <label class="block text-[13px] font-semibold text-gray-500 mb-2">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition-colors">
                    </div>
                    <div>
                        <label class="block text-[13px] font-semibold text-gray-500 mb-2">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-400 focus:outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition-colors bg-white"
                            onchange="this.classList.remove('text-gray-400'); this.classList.add('text-gray-800')">
                            <option value="" disabled selected>Pilih Jenis Kelamin</option>
                            <option value="Laki-Laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[13px] font-semibold text-gray-500 mb-2">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition-colors">
                    </div>
                    <div>
                        <label class="block text-[13px] font-semibold text-gray-500 mb-2">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-400 focus:outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition-colors"
                            onchange="this.classList.remove('text-gray-400'); this.classList.add('text-gray-800')">
                    </div>
                    <div>
                        <label class="block text-[13px] font-semibold text-gray-500 mb-2">Agama</label>
                        <select name="agama" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-400 focus:outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition-colors bg-white"
                            onchange="this.classList.remove('text-gray-400'); this.classList.add('text-gray-800')">
                            <option value="" disabled selected>Pilih Agama</option>
                            <option value="Islam">Islam</option>
                            <option value="Protestan">Protestan</option>
                            <option value="Katolik">Katolik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Buddha">Buddha</option>
                            <option value="Khonghucu">Khonghucu</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[13px] font-semibold text-gray-500 mb-2">Jurusan</label>
                        <select name="jurusan" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-400 focus:outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition-colors bg-white"
                            onchange="this.classList.remove('text-gray-400'); this.classList.add('text-gray-800')">
                            <option value="" disabled selected>Pilih Jurusan</option>
                            <option value="1">TKRO</option>
                            <option value="2">TJKT</option>
                            <option value="3">PPLG</option>
                            <option value="4">DPIB</option>
                            <option value="5">MPLB</option>
                            <option value="6">AKL</option>
                            <option value="7">SK</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[13px] font-semibold text-gray-500 mb-2">Pendidikan</label>
                        <select name="pendidikan" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition-colors bg-white">
                            <option value="SD">SD</option>
                            <option value="SMP">SMP</option>
                            <option value="SMK">SMK</option>
                            <option value="SMA">SMA</option>
                            <option value="D1">D1</option>
                            <option value="D2">D2</option>
                            <option value="D3">D3</option>
                            <option value="S1">S1</option>
                            <option value="S2">S2</option>
                            <option value="S3">S3</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[13px] font-semibold text-gray-500 mb-2">Jabatan</label>
                        <select name="jabatan" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition-colors bg-white">
                            <option value="Siswa">Siswa</option>
                            <option value="Guru">Guru</option>
                            <option value="TU">TU</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[13px] font-semibold text-gray-500 mb-2">Jenis Identitas Utama</label>
                        <select name="jenis_identitas" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition-colors bg-white">
                            <option value="KTP">KTP</option>
                            <option value="Kartu Keluarga">Kartu Keluarga</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[13px] font-semibold text-gray-500 mb-2">Telepon Selular</label>
                        <input type="tel" name="no_hp" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition-colors">
                    </div>
                    <div>
                        <label class="block text-[13px] font-semibold text-gray-500 mb-2">Kode Pos</label>
                        <input type="text" name="kode_pos" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition-colors">
                    </div>
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-500 mb-2">Provinsi</label>
                            <select name="provinsi" id="provinsi" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition-colors bg-white">
                                <option value="">Pilih Provinsi</option>
                                @foreach ($provinsi as $prov)
                                <option value="{{ $prov->id }}">
                                    {{ $prov->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-500 mb-2">Kabupaten/Kota</label>
                            <select name="kab_kota" id="kabupaten" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition-colors bg-white">
                                <option value="">Pilih Kabupaten</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-500 mb-2">Kecamatan</label>
                            <select name="kecamatan" id="kecamatan" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition-colors bg-white">
                                <option value="">Pilih Kecamatan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-500 mb-2">Kelurahan/Desa</label>
                            <select name="kelurahan" id="desa" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition-colors bg-white">
                                <option value="">Pilih Desa</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-500 mb-2">Email</label>
                            <input type="email" name="email" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition-colors">
                        </div>
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-500 mb-2">Password</label>
                            <input type="password" name="password" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition-colors">
                        </div>
                    <div class="col-span-2 md:col-span-2">
                        <label class="block text-[13px] font-semibold text-gray-500 mb-2">Alamat</label>
                        <textarea name="alamat" class="w-full h-[115px] border border-gray-200 rounded-lg px-4 py-3 text-[14px] text-gray-800 resize-none focus:outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition-colors"></textarea>
                    </div>
                </div>
            </div>

            <!-- SECTION 2: DATA PIHAK YANG DAPAT DIHUBUNGI -->
            <div class="mb-10">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-[5px] h-6 bg-[#c0860b] rounded-full"></div>
                    <h3 class="text-[20px] font-bold text-gray-800">Data Pihak yang Dapat Dihubungi</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                    <div class="flex flex-col gap-5">
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-500 mb-2">Nama Lengkap</label>
                            <input type="text" name="nama_kontak_darurat" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition-colors">
                        </div>
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-500 mb-2">Telepon Selular</label>
                            <input type="tel" name="nomor_kontak_darurat" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition-colors">
                        </div>
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-500 mb-2">Hubungan dengan Pemohon</label>
                            <input type="text" name="hubungan_kontak_darurat" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-[14px] text-gray-800 focus:outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition-colors">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[13px] font-semibold text-gray-500 mb-2">Alamat</label>
                        <textarea name="alamat_kontak_darurat" class="w-full h-[225px] border border-gray-200 rounded-lg px-4 py-3 text-[14px] text-gray-800 resize-none focus:outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition-colors"></textarea>
                    </div>
                </div>
            </div>

            <!-- BUTTONS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-12">
                <button type="button" onclick="switchView('tabel')" class="w-full bg-[#797979] hover:bg-gray-600 text-white font-bold py-3.5 rounded-xl transition-colors text-[15px]">Kembali</button>
                <button type="submit" class="w-full bg-button-gradient hover:bg-[#0e8f56] text-white font-bold py-3.5 rounded-xl transition-colors text-[15px]">Kirim</button>
            </div>
        </form>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
    $(document).ready(function() {
        // --- Bagian 1: Alert Notifikasi Laravel ---
        @if(session('success'))
            alert("{{ session('success') }}");
        @endif

        @if(session('failed'))
            alert("{{ session('failed') }}");
        @endif


        // --- Bagian 2: Fungsi Dinamis AJAX Wilayah ---
        function handleWilayahChange(elementId, targetId, urlPath, placeholder, dependentIds = []) {
            $(`#${elementId}`).change(function() {
                let id = $(this).val();
                
                // Kosongkan target langsung dan semua elemen turunannya jika ada
                $(`#${targetId}`).empty().append(`<option value="">Pilih ${placeholder}</option>`);
                dependentIds.forEach(depId => {
                    let depPlaceholder = $(`#${depId} option:first`).text() || 'Data';
                    $(`#${depId}`).empty().append(`<option value="">${depPlaceholder}</option>`);
                });

                if (!id) return;

                $.ajax({
                    url: `${urlPath}/${id}`,
                    type: 'GET',
                    success: function(data) {
                        data.forEach(function(item) {
                            $(`#${targetId}`).append(`<option value="${item.id}">${item.name}</option>`);
                        });
                    },
                    error: function(xhr) {
                        console.error(`Gagal memuat data ${placeholder}:`, xhr);
                    }
                });
            });
        }

        // --- Bagian 3: Inisialisasi Event Perubahan Wilayah ---
        // Jika provinsi berubah -> isi kabupaten (serta kosongkan kecamatan & desa)
        handleWilayahChange('provinsi', 'kabupaten', '/get-kabupaten', 'Kabupaten', ['kecamatan', 'desa']);
        
        // Jika kabupaten berubah -> isi kecamatan (serta kosongkan desa)
        handleWilayahChange('kabupaten', 'kecamatan', '/get-kecamatan', 'Kecamatan', ['desa']);
        
        // Jika kecamatan berubah -> isi desa
        handleWilayahChange('kecamatan', 'desa', '/get-desa', 'Desa');
    });
</script>