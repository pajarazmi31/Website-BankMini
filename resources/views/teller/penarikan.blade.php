@extends('layouts.teller')

@section('title', 'Teller - Data Penarikan')
@section('header_title')
    Selamat Datang, {{ $user->name }}!
@endsection
@section('header_subtitle', 'Lorem Ipsum is simply dummy text of the printing.')

@section('styles')
<style>
    .fade-in { animation: fadeIn 0.3s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endsection

@section('content')


<!-- ================= VIEW 1: TABEL DATA PENARIKAN ================= -->
<div id="viewTabelData" class="fade-in block flex-1 flex flex-col justify-start">
    <!-- Search Bar Mobile -->
    <form action="" method="GET" class="md:hidden relative mb-5 m-0 p-0">
        <i class="ph ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-lg"></i>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau rekening..." class="w-full pl-12 pr-4 py-3.5 bg-white border border-gray-100 rounded-2xl text-[14px] focus:outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue text-gray-700 placeholder-gray-400 shadow-sm transition-all">
    </form>

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4 px-1">

    <h3 class="text-[22px] font-bold text-gray-800">
        Data Penarikan
    </h3>

        <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">

            <!-- EXPORT EXCEL -->
            <div class="relative">

                <button
                    id="btnExportExcel"
                    type="button"
                    class="bg-green-600 text-white px-3 py-1.5 rounded-[10px] text-[13px] font-bold flex items-center gap-2 hover:bg-green-700 transition-all shadow-md w-full sm:w-auto justify-center">

                    <i class="ph ph-file-xls text-base"></i>
                    Export Excel
                    <i class="ph ph-caret-down"></i>

                </button>

                <!-- DROPDOWN -->
                <div
                    id="dropdownExport"
                    class="hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-100 z-50">

                    <a href="{{ route('penarikan.export', ['filter' => 'hari_ini']) }}"
                        class="block px-4 py-3 hover:bg-gray-50 text-sm">
                        Hari Ini
                    </a>

                    <a href="{{ route('penarikan.export', ['filter' => 'minggu_ini']) }}"
                        class="block px-4 py-3 hover:bg-gray-50 text-sm">
                        Minggu Ini
                    </a>

                    <a href="{{ route('penarikan.export', ['filter' => 'bulan_ini']) }}"
                        class="block px-4 py-3 hover:bg-gray-50 text-sm">
                        Bulan Ini
                    </a>

                    <a href="{{ route('penarikan.export', ['filter' => 'tahun_ini']) }}"
                        class="block px-4 py-3 hover:bg-gray-50 text-sm">
                        Tahun Ini
                    </a>

                    <hr>

                    <button
                        type="button"
                        onclick="toggleCustomTanggal()"
                        class="w-full text-left px-4 py-3 hover:bg-gray-50 text-sm">
                        Custom Tanggal
                    </button>

                </div>

                <!-- CUSTOM TANGGAL -->
                 <div
                id="customTanggalBox"
                class="hidden absolute right-0 top-full mt-2 w-60 bg-white rounded-xl shadow-lg border border-gray-100 z-[60] p-3">
                
                    <form action="{{ route('penarikan.export.custom') }}" method="GET">
 
                        <label class="block text-xs font-semibold text-gray-500 mb-1">
                            Dari Tanggal
                        </label>

                        <input
                            type="date"
                            name="start_date"
                            class="w-full border rounded-lg px-3 py-1.5 text-sm mb-3">



                        <label class="block text-xs font-semibold text-gray-500 mb-1">
                            Sampai Tanggal
                        </label>

                        <input
                            type="date"
                            name="end_date"
                            class="w-full border rounded-lg px-3 py-1.5 text-sm mb-3">

                        <button
                            type="submit"
                            class="w-full bg-green-600 hover:bg-green-700 text-white py-1.5 rounded-lg text-xs font-medium">
                            Download Excel
                        </button>

                    </form>

                </div>

            </div>

            <!-- TAMBAH PENARIKAN -->
            <button
                onclick="switchView('tambah')"
                class="bg-gradient-to-r from-[#143657] to-[#316392] text-white px-3 py-1.5 rounded-[10px] text-[13px] font-bold flex items-center gap-2 hover:opacity-90 transition-all shadow-md w-full sm:w-auto justify-center">

                <i class="ph ph-plus text-base"></i>
                Tambah Penarikan

            </button>

        </div>

    </div>

    <div class="bg-white rounded-[20px] shadow-card p-6 w-full flex flex-col" id="penarikanTableCard">
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

                <td class="py-4 px-2 border-b border-gray-50">
                    {{ $data->firstItem() + $index }}.
                </td>

                <td class="py-4 px-2 border-b border-gray-50">
                    {{ $d->nama_penarik }}
                </td>

                <td class="py-4 px-2 border-b border-gray-50">
                    {{ $d->id_rekening }}
                </td>

                <td class="py-4 px-2 border-b border-gray-50 text-gray-800">
                    Rp. {{ number_format($d->jumlah_penarikan, 0, ',', '.') }}
                </td>

                <td class="py-4 px-2 border-b border-gray-50">
                    {{ \Carbon\Carbon::parse($d->created_at)->format('d-m-Y') }}
                </td>

                <td class="py-4 px-2 border-b border-gray-50">
                    {{ $user->name }}
                </td>

            <td class="py-4 px-2 border-b border-gray-50 text-center">
                <div class="flex items-center justify-center gap-2">

                    <!-- Tombol Detail di dalam baris tabel lu -->
                    <button
                        type="button"
                        onclick="showDetail(
                            '{{ $d->nama_penarik }}',
                            '{{ $d->id_rekening }}',
                            '{{ $d->jumlah_penarikan }}', 
                            '{{ $user->name }}',
                            '{{ $d->transaksi->nominal ?? 0 }}'
                        )"
                        class="w-[28px] h-[28px] rounded-full bg-[#e2e8f0] text-brand-blue flex items-center justify-center hover:bg-gray-300 transition-colors"
                        title="Lihat Detail">
                        <i class="ph-fill ph-eye text-[15px]"></i>
                    </button>

                    <!-- 2. TOMBOL EDIT (Sudah ditambahkan type="button" agar tidak memicu submit apa pun) -->
                    <button
                    onclick="editData(
                        '{{ $d->id }}',
                        '{{ $d->nama_penarik }}',
                        '{{ $d->id_rekening }}',
                        '{{ $d->jumlah_penarikan }}',
                        '{{ $user->name }}',
                        '{{ $d->transaksi->nominal ?? 0 }}',
                        '{{ $d->transaksi_id }}'
                    )"
                        class="w-[28px] h-[28px] rounded-full bg-[#d1fae5] text-[#10a163] flex items-center justify-center hover:bg-green-200 transition-colors"
                        title="Edit">
                        <i class="ph-fill ph-pencil-simple text-[15px]"></i>
                    </button>

                    <a href="{{ route('penarikan.struk', $d->id) }}"
                    target="_blank"
                    class="download-struk w-[28px] h-[28px] rounded-full bg-blue-100 text-blue-600 flex items-center justify-center hover:bg-blue-200 transition-colors"
                    title="Cetak Struk">
                        <i class="ph-fill ph-printer text-[15px]"></i>
                    </a>

                    <!-- 3. FORM & TOMBOL HAPUS -->
                    <form
                        id="delete-form-{{ $d->id }}"
                        action="{{ route('penarikan.delete', $d->id) }}"
                        method="POST"
                        class="inline-block m-0 p-0"
                    >
                        @csrf
                        @method('DELETE')
                        <button
                            type="button"
                            onclick="confirmDeletePenarikan('{{ $d->id }}')"
                            class="w-[28px] h-[28px] rounded-full bg-[#fee2e2] text-red-500 flex items-center justify-center hover:bg-red-200 transition-colors"
                            title="Hapus"
                        >
                            <i class="ph-fill ph-trash text-[15px]"></i>
                        </button>
                    </form>

                </div>
            </td>

            </tr>

            @empty

            <tr>

                <td colspan="6"
                    class="py-8 text-center text-gray-400">

                    Belum ada data penarikan

                </td>

            </tr>

            @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <x-pagination :paginator="$data" />

    </div>
</div>

<!-- ================= CRUD VIEWS (Separated Files) ================= -->
@include('teller.crud_penarikan.tambah')
@include('teller.crud_penarikan.detail')
@include('teller.crud_penarikan.edit')

@endsection

@section('scripts')
<script>
    function switchView(viewName) {
        const views = {
            tabel: document.getElementById('viewTabelData'),
            tambah: document.getElementById('viewTambahData'),
            edit: document.getElementById('viewEditData'),
            detail: document.getElementById('viewDetailData')
        };

        Object.values(views).forEach(v => {
            if (v) {
                v.classList.add('hidden');
                v.classList.remove('flex', 'block');
            }
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

        document.querySelector('main')
            .scrollTo({ top: 0, behavior: 'smooth' });
    }

    // =========================
    // FORMAT HELPER
    // =========================

    function formatRibuan(num) {
        return new Intl.NumberFormat('id-ID').format(num);
    }

    function bersihAngka(txt) {
        return parseInt(txt.toString().replace(/\D/g, '')) || 0;
    }

    // =========================
    // DETAIL
    // =========================

    function showDetail(nama, rek, nominal, petugas, biaya) {

        let angkaNominal = parseInt(nominal) || 0;
        let angkaBiaya   = parseInt(biaya) || 0;
        let angkaTotal   = angkaNominal + angkaBiaya;

        document.getElementById('detail_petugas').value = petugas;
        document.getElementById('detail_rek').value = rek;
        document.getElementById('detail_nama').value = nama;

        document.getElementById('detail_nominal').value =
            'Rp. ' + formatRibuan(angkaNominal);

        document.getElementById('detail_biaya').value =
            'Rp. ' + formatRibuan(angkaBiaya);

        document.getElementById('detail_total').value =
            'Rp. ' + formatRibuan(angkaTotal);

        switchView('detail');
    }

   // =========================
// EDIT
// =========================

function jalankanKalkulatorEdit() {

    const nominal = bersihAngka(
        document.getElementById('edit_jumlah_penarikan').value
    );

    const biaya = bersihAngka(
        document.getElementById('edit_biaya_transaksi').value
    );

    const total = nominal + biaya;

    document.getElementById('edit_total').value = total;

    document.getElementById('edit_total_biaya').value =
        'Rp. ' + formatRibuan(total);
}

document.addEventListener('input', function (e) {

    if (e.target.id === 'edit_jumlah_penarikan') {

        let val = e.target.value.replace(/\D/g, '');

        e.target.value = val
            ? formatRibuan(val)
            : '';

        jalankanKalkulatorEdit();
    }
});


    // =====================================
    // FUNCTION CARI NAMA REKENING
    // =====================================
    async function cariNamaRekening() {

    const rekeningInput =
        document.getElementById('edit_id_rekening');

    const namaInput =
        document.getElementById('edit_nama_penarik');

    let rekening = rekeningInput.value.trim();

    if (rekening.length === 0) {
        namaInput.value = '';
        return;
    }

    try {

        let response =
            await fetch(`/cari-rekening/${rekening}`);

        let data =
            await response.json();

        if (data.success) {

            namaInput.value = data.nama;

        } else {

            namaInput.value = 'Rekening tidak ditemukan';

        }

    } catch (err) {

        console.error(err);

        namaInput.value = 'Rekening tidak ditemukan';

    }
}

    // EVENT LISTENER DIPISAH
    document.addEventListener('input', function(e) {

        if (e.target.id === 'edit_id_rekening') {

            // hanya angka
            e.target.value = e.target.value.replace(/\D/g, '');

            cariNamaRekening();
        }

    });


    function editData(id, nama, rek, nominal, petugas, biaya, transaksiId) {

        document.getElementById('edit_id').value = id;

        document.getElementById('edit_id_rekening').value = rek;

        document.getElementById('edit_petugas').value = petugas;

        let biayaMurni = parseInt(biaya) || 0;

        document.getElementById('edit_biaya_transaksi').value =
            formatRibuan(biayaMurni);

        document.getElementById('edit_transaksi_id').value =
            transaksiId;

        document.getElementById('edit_jumlah_penarikan').value =
            formatRibuan(nominal);

        document.getElementById('editPenarikanForm').action =
            '/penarikan/update/' + id;

        // tampilkan nama awal
        document.getElementById('edit_nama_penarik').value = nama;

        // setelah itu fetch ulang berdasarkan rekening
        cariNamaRekening();

        jalankanKalkulatorEdit();

        switchView('edit');
    }

    const nominalTambah =
        document.getElementById('jumlah_penarikan');

    if (nominalTambah) {

        nominalTambah.addEventListener('input', function () {

            let val = this.value.replace(/\D/g, '');

            this.value = val
                ? formatRibuan(val)
                : '';

            const selected =
                transaksiSelect.options[
                    transaksiSelect.selectedIndex
                ];

            const biaya =
                parseInt(selected.dataset.biaya) || 0;

            const total =
                bersihAngka(val) + biaya;

            document.getElementById('total_biaya').value =
                'Rp. ' + formatRibuan(total);
        });
    }

    function confirmDeletePenarikan(id) {
        const msg = 'Apakah Anda yakin ingin menghapus history transaksi penarikan ini? <span class="font-bold text-red-500">Saldo nasabah akan otomatis ditambahkan kembali!</span>';
        openDeleteModal(function() {
            document.getElementById('delete-form-' + id).submit();
        }, msg);
    }

    // AJAX Live Search & PJAX Pagination
    document.addEventListener("DOMContentLoaded", function() {
        let debounceTimeout = null;

        function performAjaxSearch(searchVal) {
            const query = new URLSearchParams(window.location.search);
            query.set('search', searchVal);
            query.delete('page'); // Reset page to 1 on new search

            const targetUrl = `${window.location.pathname}?${query.toString()}`;
            window.history.replaceState({}, '', targetUrl);

            // Sync other search input fields
            document.querySelectorAll('input[name="search"]').forEach(input => {
                if (input.value !== searchVal) {
                    input.value = searchVal;
                }
            });

            fetch(targetUrl)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newCard = doc.getElementById('penarikanTableCard');
                    const currentCard = document.getElementById('penarikanTableCard');
                    if (newCard && currentCard) {
                        currentCard.innerHTML = newCard.innerHTML;
                    }
                })
                .catch(err => console.error('Gagal melakukan pencarian:', err));
        }

        // Attach input listener to both desktop & mobile search inputs
        document.querySelectorAll('input[name="search"]').forEach(input => {
            input.addEventListener('input', function() {
                clearTimeout(debounceTimeout);
                const val = this.value;
                debounceTimeout = setTimeout(() => {
                    performAjaxSearch(val);
                }, 300);
            });
        });

        // Prevent form reloads on Enter
        document.querySelectorAll('form').forEach(form => {
            const hasSearchInput = form.querySelector('input[name="search"]');
            if (hasSearchInput) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    performAjaxSearch(hasSearchInput.value);
                });
            }
        });

        // AJAX Pagination click interceptor
        document.addEventListener('click', function(e) {

            const link = e.target.closest('#penarikanTableCard a');

            if (!link) return;

            // BIARKAN LINK PDF NORMAL
            if (link.classList.contains('download-struk')) {
                return;
            }

            if (
                link.getAttribute('href') &&
                !link.getAttribute('href').startsWith('#')
            ) {

                e.preventDefault();

                const targetUrl = link.getAttribute('href');

                window.history.pushState({}, '', targetUrl);

                fetch(targetUrl)
                    .then(response => response.text())
                    .then(html => {

                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');

                        const newCard =
                            doc.getElementById('penarikanTableCard');

                        const currentCard =
                            document.getElementById('penarikanTableCard');

                        if (newCard && currentCard) {
                            currentCard.innerHTML = newCard.innerHTML;
                        }

                        document.querySelector('main')
                            .scrollTo({
                                top: 0,
                                behavior: 'smooth'
                            });

                    })
                    .catch(err =>
                        console.error('Gagal memuat halaman:', err)
                    );
            }
        });

        // ===========================
        // EXPORT EXCEL DROPDOWN
        // ===========================

        const btnExportExcel = document.getElementById('btnExportExcel');
        const dropdownExport = document.getElementById('dropdownExport');
        const customTanggalBox = document.getElementById('customTanggalBox');

        if (btnExportExcel) {

            btnExportExcel.addEventListener('click', function(e) {

                e.stopPropagation();

                dropdownExport.classList.toggle('hidden');

                if (!customTanggalBox.classList.contains('hidden')) {
                    customTanggalBox.classList.add('hidden');
                }

            });

        }

        function toggleCustomTanggal() {

            customTanggalBox.classList.toggle('hidden');

        }

        window.toggleCustomTanggal = function() {

            const customTanggalBox =
                document.getElementById('customTanggalBox');

            customTanggalBox.classList.toggle('hidden');

        }

        document.addEventListener('click', function(e) {

            if (
                !e.target.closest('#dropdownExport') &&
                !e.target.closest('#btnExportExcel') &&
                !e.target.closest('#customTanggalBox')
            ) {

                dropdownExport.classList.add('hidden');
                customTanggalBox.classList.add('hidden');

            }

        })


    });
</script>