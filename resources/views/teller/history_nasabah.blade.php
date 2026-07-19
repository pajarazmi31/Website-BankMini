@extends('layouts.teller')

@section('title', 'Teller - History Nasabah')
@section('header_title')
History Transaksi Nasabah
@endsection
@section('header_subtitle', 'Sistem Laporan Riwayat Transaksi Buku Tabungan Nasabah.')

@section('styles')
<style>
    .fade-in {
        animation: fadeIn 0.3s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endsection

@section('content')

<!-- ================= VIEW 1: TABEL HISTORY ================= -->
<div id="viewTabelData" class="fade-in block flex-1 flex flex-col justify-start">
    <!-- Search Bar Mobile -->
    <form action="" method="GET" class="md:hidden relative mb-5 m-0 p-0" id="searchBarContainer">
        <i class="ph ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-lg"></i>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau no. rekening..." class="w-full pl-12 pr-4 py-3.5 bg-white border border-gray-100 rounded-2xl text-[14px] focus:outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue text-gray-700 placeholder-gray-400 shadow-sm transition-all">
    </form>

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4 px-1">

        <h3 class="text-[22px] font-bold text-gray-800">
            Riwayat Transaksi
        </h3>

        <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">

            <!-- EXPORT EXCEL (Opsional, format disamakan) -->
            <div class="relative">
                <button
                    id="btnExportExcel"
                    type="button"
                    class="bg-green-600 text-white px-3 py-1.5 rounded-[10px] text-[13px] font-bold flex items-center gap-2 hover:bg-green-700 transition-all shadow-md w-full sm:w-auto justify-center">
                    <i class="ph ph-file-xls text-base"></i>
                    Export Excel
                    <i class="ph ph-caret-down"></i>
                </button>

                <!-- DROPDOWN EXPORT -->
                <div id="dropdownExport" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-100 z-50">
                    <a href="#" class="block px-4 py-3 hover:bg-gray-50 text-sm">Bulan Ini</a>
                    <a href="#" class="block px-4 py-3 hover:bg-gray-50 text-sm">Tahun Ini</a>
                </div>
            </div>

        </div>

    </div>

    <div class="bg-white rounded-[20px] shadow-card p-6 w-full flex flex-col" id="historyTableCard">
        <div class="flex items-center gap-2 mb-4">
            <span class="text-[13px] text-gray-600 font-medium">Tampilkan:</span>
            <select onchange="changePerPage(this.value)" class="bg-white border border-gray-200 text-gray-700 text-[13px] rounded-[10px] px-3 py-1.5 font-semibold focus:outline-none focus:border-brand-blue shadow-sm cursor-pointer">
                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 data</option>
                <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20 data</option>
                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 data</option>
            </select>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr>
                        <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] w-12 border-b border-gray-100">No</th>
                        <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">Nama</th>
                        <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">No. Rek</th>
                        <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">J. Transaksi</th>
                        <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">Admin</th>
                        <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">Debit (Keluar)</th>
                        <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">Kredit (Masuk)</th>
                        <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">Saldo</th>
                        <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] text-center w-24 border-b border-gray-100">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-[14px] text-gray-800 font-medium">
                    <!-- Nanti data dilempar dari Controller, ini struktur untuk Blade-nya -->
                    @forelse($data ?? [] as $index => $d)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="py-4 px-2 border-b border-gray-50">{{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}.</td>
                        <td class="py-4 px-2 border-b border-gray-50">{{ $d->nama_nasabah }}</td>
                        <td class="py-4 px-2 border-b border-gray-50">{{ $d->no_rek }}</td>
                        
                        <!-- Pewarnaan Jenis Transaksi -->
                        <td class="py-4 px-2 border-b border-gray-50">
                            @if($d->jenis_transaksi == 'Setoran')
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-md text-xs font-bold">Setoran</span>
                            @elseif($d->jenis_transaksi == 'Penarikan')
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded-md text-xs font-bold">Penarikan</span>
                            @else
                                <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-md text-xs font-bold">{{ $d->jenis_transaksi }}</span>
                            @endif
                        </td>

                        <td class="py-4 px-2 border-b border-gray-50 text-gray-500">Rp {{ number_format($d->admin, 0, ',', '.') }}</td>
                        <td class="py-4 px-2 border-b border-gray-50 text-red-500 font-semibold">Rp {{ number_format($d->debit, 0, ',', '.') }}</td>
                        <td class="py-4 px-2 border-b border-gray-50 text-green-500 font-semibold">Rp {{ number_format($d->kredit, 0, ',', '.') }}</td>
                        <td class="py-4 px-2 border-b border-gray-50 text-gray-800 font-bold">Rp {{ number_format($d->saldo, 0, ',', '.') }}</td>
                        
                        <td class="py-4 px-2 border-b border-gray-50 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <!-- Button Detail -->
                                <button type="button" onclick="lihatDetail('{{ $d->id }}', '{{ $d->jenis_transaksi }}')" 
                                    class="w-[28px] h-[28px] rounded-full bg-[#e2e8f0] text-brand-blue flex items-center justify-center hover:bg-gray-300 transition-colors" title="Lihat Detail">
                                    <i class="ph-fill ph-eye text-[15px]"></i>
                                </button>

                                <!-- Button Print (Bisa diarahkan ke route cetak struk masing-masing transaksi) -->
                                <a href="#" target="_blank"
                                    class="download-pdf w-[28px] h-[28px] rounded-full bg-[#dbeafe] text-blue-600 flex items-center justify-center hover:bg-blue-200 transition-colors" title="Cetak Struk">
                                    <i class="ph-fill ph-printer text-[15px]"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="py-10 text-center text-gray-400 font-medium">Tidak ada data transaksi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if(isset($data))
            <div class="mt-4">
                {{ $data->links() }}
            </div>
        @endif
    </div>
</div>

<!-- ================= VIEW 2: DETAIL TRANSAKSI (Nanti disesuaikan) ================= -->
<div id="viewDetailData" class="hidden fade-in flex-1 flex flex-col justify-start">
    <div class="flex items-center gap-3 mb-4 px-1">
        <button onclick="switchView('tabel')" class="w-8 h-8 flex items-center justify-center rounded-full bg-white shadow-sm border border-gray-200 text-gray-600 hover:bg-gray-50 transition-all">
            <i class="ph ph-arrow-left text-lg"></i>
        </button>
        <h3 class="text-[22px] font-bold text-gray-800">Detail Transaksi</h3>
    </div>
    
    <div class="bg-white rounded-[20px] shadow-card p-6">
        <p class="text-gray-500 text-center py-10">Tampilan detail akan dirender di sini menggunakan JavaScript/Ajax.</p>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // FUNGSI NAVIGASI
    function switchView(viewName) {
        const views = {
            'tabel': document.getElementById('viewTabelData'),
            'detail': document.getElementById('viewDetailData')
        };

        Object.values(views).forEach(v => {
            if (v) v.classList.add('hidden');
        });

        const activeView = views[viewName];
        if (activeView) {
            activeView.classList.remove('hidden');
            if (viewName === 'tabel') {
                activeView.classList.add('flex');
            } else {
                activeView.classList.add('block');
            }
        }
    }

    // FUNGSI GANTI JUMLAH DATA PER HALAMAN
    function changePerPage(value) {
        const url = new URL(window.location.href);
        url.searchParams.set('per_page', value);
        url.searchParams.set('page', 1);
        window.location.href = url.toString();
    }

    // FUNGSI MUNCULKAN DROPDOWN EXPORT
    document.addEventListener("DOMContentLoaded", function() {
        const btnExportExcel = document.getElementById('btnExportExcel');
        const dropdownExport = document.getElementById('dropdownExport');

        if (btnExportExcel) {
            btnExportExcel.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdownExport.classList.toggle('hidden');
            });
        }

        document.addEventListener('click', function(e) {
            if (!e.target.closest('#dropdownExport') && !e.target.closest('#btnExportExcel')) {
                if(dropdownExport) dropdownExport.classList.add('hidden');
            }
        });
    });

    // FUNGSI LIHAT DETAIL
    function lihatDetail(id, jenis) {
        // Nanti disini kamu bisa buat logika AJAX untuk memanggil data detail
        // berdasarkan ID dan Jenis Transaksi-nya, lalu memunculkan modal/viewDetailData
        switchView('detail');
    }
</script>
@endsection