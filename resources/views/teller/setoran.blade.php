@extends('layouts.teller')

@section('title', 'Teller - Data Setoran')
@section('header_title')
    Selamat Datang, {{ $teller->nama_petugas }}!
@endsection
@section('header_subtitle', 'Sistem Administrasi Data Transaksi Penyetoran Kas.')

@section('styles')
<style>
    .fade-in { animation: fadeIn 0.3s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endsection

@section('content')

<!-- ================= VIEW 1: TABEL DATA SETORAN ================= -->
<div id="viewTabelData" class="fade-in block flex-1 flex flex-col justify-start">
    <!-- Search Bar Mobile -->
    <div class="md:hidden relative mb-5">
        <i class="ph ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-lg"></i>
        <input type="text" placeholder="Cari nama atau no. rekening..." class="w-full pl-12 pr-4 py-3.5 bg-white border border-gray-100 rounded-2xl text-[14px] focus:outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue text-gray-700 placeholder-gray-400 shadow-sm transition-all">
    </div>

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4 px-1">
        <h3 class="text-[22px] font-bold text-gray-800">Data Setoran</h3>
        <button onclick="switchView('tambah')" class="bg-gradient-to-r from-[#143657] to-[#316392] text-white px-3 py-1.5 rounded-[10px] text-[13px] font-bold flex items-center gap-2 hover:opacity-90 transition-all shadow-md w-full sm:w-auto justify-center">
            <i class="ph ph-plus text-base"></i> Tambah Setoran
        </button>
    </div>

    <div class="bg-white rounded-[20px] shadow-card p-6 w-full flex flex-col">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr>
                        <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] w-12 border-b border-gray-100">No</th>
                        <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">Nama</th>
                        <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">No. Rekening</th>
                        <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">Nominal Rupiah</th>
                        <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">Tanggal</th>
                        <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">Petugas</th>
                        <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] text-center w-36 border-b border-gray-100">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-[14px] text-gray-800 font-medium">
                    @forelse($data as $index => $d)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="py-4 px-2 border-b border-gray-50">{{ $index + 1 }}.</td>
                        <td class="py-4 px-2 border-b border-gray-50">{{ $d->nama_lengkap }}</td>
                        <td class="py-4 px-2 border-b border-gray-50">{{ $d->id_rekening }}</td>
                        <td class="py-4 px-2 border-b border-gray-50 text-gray-800">Rp. {{ number_format($d->jumlah_penyetoran, 0, ',', '.') }}</td>
                        <td class="py-4 px-2 border-b border-gray-50">{{ \Carbon\Carbon::parse($d->datetime_tgl)->format('d-m-Y') }}</td>
                        <td class="py-4 px-2 border-b border-gray-50">{{ $d->petugas->nama_petugas ?? $teller->nama_petugas }}</td>
                        <td class="py-4 px-2 border-b border-gray-50 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <!-- Button Detail -->
                                <button type="button" onclick="lihatDetailSetoran(
                                    '{{ $d->petugas->nama_petugas ?? $teller->nama_petugas }}',
                                    '{{ $d->nama_lengkap }}',
                                    '{{ $d->id_rekening }}',
                                    '{{ $d->setoran }}',
                                    '{{ $d->mata_uang }}',
                                    '{{ $d->jumlah_penyetoran }}',
                                    '{{ $d->uang_terbilang }}',
                                    '{{ $d->nama_penyetor }}',
                                    '{{ $d->no_hp_penyetor }}',
                                    '{{ $d->alamat_penyetor }}',
                                    '{{ optional($d->transaksi)->nominal ?? 0 }}',
                                    '{{ $d->total_biaya }}',
                                    '{{ $d->catatan }}'
                                )" class="w-[28px] h-[28px] rounded-full bg-[#e2e8f0] text-brand-blue flex items-center justify-center hover:bg-gray-300 transition-colors" title="Lihat Detail">
                                    <i class="ph-fill ph-eye text-[15px]"></i>
                                </button>

                                <!-- Button Edit -->
                                <button onclick='editData(
                                    "{{ $d->id }}",
                                    "{{ $d->nama_lengkap }}",
                                    "{{ $d->id_rekening }}",
                                    "{{ $d->setoran }}",
                                    "{{ $d->mata_uang }}",
                                    "{{ $d->jumlah_penyetoran }}",
                                    "{{ $d->uang_terbilang }}",
                                    "{{ $d->nama_penyetor }}",
                                    "{{ $d->no_hp_penyetor }}",
                                    "{{ $d->alamat_penyetor }}",
                                    "{{ optional($d->transaksi)->nominal ?? 0 }}",
                                    "{{ $d->total_biaya }}",
                                    "{{ $d->catatan }}",
                                    "{{ $d->petugas->nama_petugas ?? $teller->nama_petugas }}"
                                )' class="w-[28px] h-[28px] rounded-full bg-[#d1fae5] text-[#10a163] flex items-center justify-center hover:bg-green-200 transition-colors" title="Edit">
                                    <i class="ph-fill ph-pencil-simple text-[15px]"></i>
                                </button>

                                <!-- Button Delete -->
                                <form action="{{ route('setoran.destroy', $d->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Yakin ingin menghapus history transaksi ini? Saldo nasabah akan otomatis dikurangi kembali!')" class="w-[28px] h-[28px] rounded-full bg-[#fee2e2] text-red-500 flex items-center justify-center hover:bg-red-200 transition-colors" title="Hapus">
                                        <i class="ph-fill ph-trash text-[15px]"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-10 text-center text-gray-400 font-medium">Tidak ada data setoran</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <x-pagination total="3" />
    </div>
</div>

<!-- ================= CRUD VIEWS (Separated Files) ================= -->
@include('teller.crud_setoran.tambah')
@include('teller.crud_setoran.detail')
@include('teller.crud_setoran.edit')

@endsection

@section('scripts')
<script>
    // =========================================================================
    // 1. NAVIGATION & UTILITIES (FUNGSI NAVIGASI & ALAT BANTU)
    // =========================================================================
    function switchView(viewName) {
        const views = {
            'tabel': document.getElementById('viewTabelData'),
            'tambah': document.getElementById('viewTambahData'),
            'edit': document.getElementById('viewEditData'),
            'detail': document.getElementById('viewDetailData')
        };

        Object.values(views).forEach(v => {
            if(v) v.classList.add('hidden');
        });

        const activeView = views[viewName];
        const searchBar = document.getElementById('searchBarContainer');

        if (activeView) {
            activeView.classList.remove('hidden');
            if (viewName === 'tabel') {
                activeView.classList.add('flex');
                if (searchBar) searchBar.classList.remove('md:hidden');
            } else {
                activeView.classList.add('block');
                if (searchBar) searchBar.classList.add('md:hidden');
            }
        }
        document.querySelector('main').scrollTo({ top: 0, behavior: 'smooth' });
    }

    function terbilang(nilai) {
        nilai = parseInt(nilai);
        let huruf = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];
        if (nilai < 12) return huruf[nilai];
        if (nilai < 20) return terbilang(nilai - 10) + " Belas";
        if (nilai < 100) return terbilang(Math.floor(nilai / 10)) + " Puluh " + terbilang(nilai % 10);
        if (nilai < 200) return "Seratus " + terbilang(nilai - 100);
        if (nilai < 1000) return terbilang(Math.floor(nilai / 100)) + " Ratus " + terbilang(nilai % 100);
        if (nilai < 2000) return "Seribu " + terbilang(nilai - 1000);
        if (nilai < 1000000) return terbilang(Math.floor(nilai / 1000)) + " Ribu " + terbilang(nilai % 1000);
        if (nilai < 1000000000) return terbilang(Math.floor(nilai / 1000000)) + " Juta " + terbilang(nilai % 1000000);
        return "";
    }

    function bersihkan(angka) {
        if (!angka) return 0;
        return parseInt(angka.toString().replace(/\D/g, '')) || 0;
    }

    function formatAngka(angka) {
    angka = parseInt(angka) || 0;
    return 'Rp. ' + new Intl.NumberFormat('id-ID').format(angka);
    }

    // =========================================================================
    // 2. LIVE INTEGRATION FOR EDIT FORM (AUTO-CALCULATE, FORMAT, & AJAX)
    // =========================================================================
    document.addEventListener("DOMContentLoaded", function() {
        const formEdit         = document.getElementById('editForm');
        const editNominal      = document.getElementById('edit_nominal');
        const editTerbilang    = document.getElementById('edit_terbilang');
        const editBiaya        = document.getElementById('edit_biaya');
        const editTotal        = document.getElementById('edit_total');
        const editRekening     = document.getElementById('edit_id_rekening');
        const editNamaLengkap  = document.getElementById('edit_nama_lengkap');

        if(editNominal) editNominal.type = 'text';
        if(editBiaya) editBiaya.type     = 'text';
        if(editTotal) editTotal.type     = 'text';

        function hitungTotalEdit() {
            if(!editNominal || !editBiaya || !editTotal) return;
            let setoran = bersihkan(editNominal.value);
            let biaya   = bersihkan(editBiaya.value);
            let total   = setoran + biaya;
            editTotal.value = formatAngka(total);
        }

        if(editNominal) {
            editNominal.addEventListener('input', function(e) {
                let angka = e.target.value.replace(/\D/g, '');
                if (!angka) {
                    editNominal.value = '';
                    editTerbilang.value = '';
                    hitungTotalEdit();
                    return;
                }
                editNominal.value = formatAngka(angka);
                editTerbilang.value = terbilang(angka) + ' Rupiah';
                hitungTotalEdit();
            });
        }

        if(editBiaya) {
            editBiaya.addEventListener('input', function(e) {
                let angka = e.target.value.replace(/\D/g, '');
                if (!angka) {
                    editBiaya.value = '';
                    hitungTotalEdit();
                    return;
                }
                editBiaya.value = formatAngka(angka);
                hitungTotalEdit();
            });
        }

        if(editRekening) {
            editRekening.addEventListener('change', async function () {
                let rekening = this.value.trim();
                if (rekening.length === 0) {
                    if(editNamaLengkap) editNamaLengkap.value = '';
                    return;
                }
                try {
                    let response = await fetch(`/cari-rekening/${rekening}`);
                    let data = await response.json();
                    if (data.success) {
                        if(editNamaLengkap) editNamaLengkap.value = data.nama;
                    } else {
                        if(editNamaLengkap) editNamaLengkap.value = '';
                        alert('Nomor rekening tidak ditemukan!');
                    }
                } catch (error) {
                    console.error("Gagal memuat data rekening:", error);
                }
            });
        }

        if(formEdit) {
            formEdit.addEventListener('submit', function() {
                if(editNominal) editNominal.value = bersihkan(editNominal.value);
                if(editBiaya) editBiaya.value     = bersihkan(editBiaya.value);
                if(editTotal) editTotal.value     = bersihkan(editTotal.value);
            });
        }
    });

    // =========================================================================
    // 3. CORE CRUD ACTION TRIGGERS (FIXED & SYNCED FOR DETAIL VIEW)
    // =========================================================================
    function bersihkan(angka) {
        if (!angka) return 0;
        
        // Kalau tipenya string dan mengandung titik ribuan (misal: 200.000)
        let str = angka.toString().trim();
        
        // JIKA string mengandung titik tapi BUKAN format pecahan desimal murni, 
        // kita buang titiknya dulu sebelum di-parse agar tidak dikira desimal bray
        if (str.includes('.') && !str.includes(',')) {
            str = str.replace(/\./g, '');
        }
        
        return parseInt(str.replace(/\D/g, '')) || 0;
    }

    // =========================================================================
    // 3. CORE CRUD ACTION TRIGGERS (FIXED FINAL NOMINAL & NO TELLER PREFIX)
    // =========================================================================
    window.lihatDetailSetoran = function(
        petugas, namalengkap, rek, setoran, mataUang, 
        nominal, terbilangStr, namapenyetor, noHp, alamat, 
        biayatransaksi, totalbiaya, catatan
    ) {
        const setVal = (id, val) => {
            const el = document.getElementById(id);
            if (el) el.value = val ?? '-';
        };

        // Tampilkan nama petugas langsung tanpa prefix bray
        setVal('detail_petugas', petugas);
        setVal('detail_nama_lengkap', namalengkap);
        setVal('detail_rek', rek);
        setVal('detail_setoran', setoran);
        setVal('detail_mata_uang', mataUang);
        
        // JALUR NUKLIR: Kita buang semua karakter non-angka, tapi jika diakhiri .00 kita potong duluan bray
        const paksaAngka = (str) => {
            if (!str) return "Rp 0";
            let s = str.toString().trim();
            // Kalau stringnya berakhiran ,00 atau .00 khas format akutansi, kita potong bray
            if (s.endsWith(',00') || s.endsWith('.00')) {
                s = s.slice(0, -3);
            }
            // Bersihkan sisa titik/huruf
            let angkaMurni = parseInt(s.replace(/\D/g, '')) || 0;
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(angkaMurni);
        };

        // Pasang langsung hasil paksaan ke input detail
        document.getElementById('detail_nominal').value         = paksaAngka(nominal);
        document.getElementById('detail_biaya_transaksi').value = paksaAngka(biayatransaksi);
        document.getElementById('detail_total_biaya').value     = paksaAngka(totalbiaya);
        
        setVal('detail_terbilang', terbilangStr);
        setVal('detail_nama_penyetor', namapenyetor);
        setVal('detail_no_hp', noHp);
        
        setVal('detail_alamat', alamat);
        setVal('detail_alamat_desktop', alamat);
        setVal('detail_alamat_mobile', alamat);
        setVal('detail_catatan', catatan);
        
        switchView('detail');
    }

   function editData(
    id,
    nama_lengkap,
    id_rekening,
    setoran,
    mata_uang,
    jumlah_penyetoran,
    uang_terbilang,
    nama_penyetor,
    no_hp_penyetor,
    alamat_penyetor,
    biaya_transaksi,
    total_biaya,
    catatan,
    petugas
) {
    const setVal = (id, value) => {
        const el = document.getElementById(id);
        if (el) el.value = value ?? '';
    };

    const form = document.getElementById('editForm');

    if (form) {
        form.action = `/setoran/${id}`;
    }

    setVal('edit_id', id);

    setVal('nama_lengkap', nama_lengkap);
    setVal('id_rekening', id_rekening);

    setVal('edit_setoran', setoran);
    setVal('edit_mata_uang', mata_uang);

    setVal('edit_petugas', petugas);

    setVal('edit_catatan', catatan);

    setVal('edit_penyetor', nama_penyetor);

    setVal('edit_nohp', no_hp_penyetor);

    setVal('edit_alamat', alamat_penyetor);

    setVal('edit_nominal', formatAngka(jumlah_penyetoran));

    setVal('edit_biaya', formatAngka(biaya_transaksi));

    setVal('edit_total', formatAngka(total_biaya));

    setVal(
        'edit_terbilang',
        uang_terbilang
            ? uang_terbilang
            : (terbilang(jumlah_penyetoran) + ' Rupiah')
    );

    switchView('edit');
}
</script>
@endsection