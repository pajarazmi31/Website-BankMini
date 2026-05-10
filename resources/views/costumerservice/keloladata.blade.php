@extends('layouts.cs')

@section('title', 'Customer Service - Kelola Data')
@section('header_title', 'Selamat Datang, Costumer Service!')
@section('header_subtitle', 'Lorem Ipsum is simply dummy text of the printing.')

@section('styles')
<style>
    .fade-in { animation: fadeIn 0.3s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endsection

@section('header_actions')
<div id="searchBarContainer" class="relative w-full md:w-auto hidden md:block transition-all">
    <i class="ph ph-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-lg"></i>
    <input type="text" placeholder="Search" class="pl-10 pr-4 py-2 border border-gray-200 rounded-lg text-[13px] w-[260px] focus:outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue text-gray-700 placeholder-gray-400">
</div>
@endsection

@section('content')
<!-- VIEW 1: TABEL DATA NASABAH -->
<div id="viewTabelData" class="fade-in block flex-1 flex flex-col justify-start">
    <!-- Search Bar Mobile -->
    <div class="md:hidden relative mb-5">
        <i class="ph ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-lg"></i>
        <input type="text" placeholder="Cari nama atau no. rekening..." class="w-full pl-12 pr-4 py-3.5 bg-white border border-gray-100 rounded-2xl text-[14px] focus:outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue text-gray-700 placeholder-gray-400 shadow-sm transition-all">
    </div>

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4 px-1">
        <h3 class="text-[22px] font-bold text-gray-800">Data Nasabah</h3>
        <button onclick="switchView('tambah')" class="bg-gradient-to-r from-[#143657] to-[#316392] text-white px-6 py-2.5 rounded-[10px] text-[13px] font-bold flex items-center gap-2 hover:opacity-90 transition-all shadow-md w-full sm:w-auto justify-center">
            <i class="ph ph-plus text-base"></i> Tambah Data
        </button>
    </div>

    <div class="bg-white rounded-[20px] shadow-card p-4 md:p-6 w-full flex flex-col">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr>
                        <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] w-12 border-b border-gray-100 text-center">No</th>
                        <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">Nama</th>
                        <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">Jabatan</th>
                        <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">No. Rekening</th>
                        <th class="py-4 px-4 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100 text-left">Status</th>
                        <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] text-center w-36 border-b border-gray-100">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-[14px] text-gray-800 font-medium">
                    <!-- Row 1 -->
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="py-4 px-2 border-b border-gray-50 text-center">1.</td>
                        <td class="py-4 px-2 border-b border-gray-50">Pajar Azmi Anugraha</td>
                        <td class="py-4 px-2 border-b border-gray-50">Siswa</td>
                        <td class="py-4 px-2 border-b border-gray-50">03-03-232410204</td>
                        <td class="py-4 px-4 border-b border-gray-50 text-left">
                            <button class="w-[28px] h-[28px] rounded-full bg-[#fef3c7] text-[#d97706] inline-flex items-center justify-center cursor-default" title="Pending">
                                <i class="ph-bold ph-clock text-[15px]"></i>
                            </button>
                        </td>
                        <td class="py-4 px-2 border-b border-gray-50">
                            <div class="flex items-center justify-center gap-2">
                                <button onclick="showDetail('Pajar Azmi Anugraha', '0103232410204', 'Siswa', '03-03-232410204', 'Pending')" class="w-[28px] h-[28px] rounded-full bg-[#e2e8f0] text-brand-blue flex items-center justify-center hover:bg-gray-300 transition-colors" title="Lihat Detail">
                                    <i class="ph-fill ph-eye text-[15px]"></i>
                                </button>
                                <button onclick="editData('Pajar Azmi Anugraha', '0103232410204', 'Siswa')" class="w-[28px] h-[28px] rounded-full bg-[#d1fae5] text-[#10a163] flex items-center justify-center hover:bg-green-200 transition-colors" title="Edit">
                                    <i class="ph-fill ph-pencil-simple text-[15px]"></i>
                                </button>
                                <button class="w-[28px] h-[28px] rounded-full bg-[#fee2e2] text-red-500 flex items-center justify-center hover:bg-red-200 transition-colors" title="Hapus">
                                    <i class="ph-fill ph-trash text-[15px]"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <!-- Row 2 -->
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="py-4 px-2 border-b border-gray-50 text-center">2.</td>
                        <td class="py-4 px-2 border-b border-gray-50">Salsabila Rosi Cahyani</td>
                        <td class="py-4 px-2 border-b border-gray-50">Siswa</td>
                        <td class="py-4 px-2 border-b border-gray-50">03-03-232410243</td>
                        <td class="py-4 px-4 border-b border-gray-50 text-left">
                            <button class="w-[28px] h-[28px] rounded-full bg-[#fef3c7] text-[#d97706] inline-flex items-center justify-center cursor-default" title="Pending">
                                <i class="ph-bold ph-clock text-[15px]"></i>
                            </button>
                        </td>
                        <td class="py-4 px-2 border-b border-gray-50">
                            <div class="flex items-center justify-center gap-2">
                                <button onclick="showDetail('Salsabila Rosi Cahyani', '0103232410243', 'Siswa', '03-03-232410243', 'Pending')" class="w-[28px] h-[28px] rounded-full bg-[#e2e8f0] text-brand-blue flex items-center justify-center hover:bg-gray-300 transition-colors" title="Lihat Detail">
                                    <i class="ph-fill ph-eye text-[15px]"></i>
                                </button>
                                <button onclick="editData('Salsabila Rosi Cahyani', '0103232410243', 'Siswa')" class="w-[28px] h-[28px] rounded-full bg-[#d1fae5] text-[#10a163] flex items-center justify-center hover:bg-green-200 transition-colors" title="Edit">
                                    <i class="ph-fill ph-pencil-simple text-[15px]"></i>
                                </button>
                                <button class="w-[28px] h-[28px] rounded-full bg-[#fee2e2] text-red-500 flex items-center justify-center hover:bg-red-200 transition-colors" title="Hapus">
                                    <i class="ph-fill ph-trash text-[15px]"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <!-- Row 3 -->
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="py-4 px-2 border-b border-gray-50 text-center">3.</td>
                        <td class="py-4 px-2 border-b border-gray-50">Anisa Siti Nur Fajriyanti</td>
                        <td class="py-4 px-2 border-b border-gray-50">Siswa</td>
                        <td class="py-4 px-2 border-b border-gray-50">03-03-232410229</td>
                        <td class="py-4 px-4 border-b border-gray-50 text-left">
                            <button class="w-[28px] h-[28px] rounded-full bg-[#fef3c7] text-[#d97706] inline-flex items-center justify-center cursor-default" title="Pending">
                                <i class="ph-bold ph-clock text-[15px]"></i>
                            </button>
                        </td>
                        <td class="py-4 px-2 border-b border-gray-50">
                            <div class="flex items-center justify-center gap-2">
                                <button onclick="showDetail('Anisa Siti Nur Fajriyanti', '0103232410229', 'Siswa', '03-03-232410229', 'Pending')" class="w-[28px] h-[28px] rounded-full bg-[#e2e8f0] text-brand-blue flex items-center justify-center hover:bg-gray-300 transition-colors" title="Lihat Detail">
                                    <i class="ph-fill ph-eye text-[15px]"></i>
                                </button>
                                <button onclick="editData('Anisa Siti Nur Fajriyanti', '0103232410229', 'Siswa')" class="w-[28px] h-[28px] rounded-full bg-[#d1fae5] text-[#10a163] flex items-center justify-center hover:bg-green-200 transition-colors" title="Edit">
                                    <i class="ph-fill ph-pencil-simple text-[15px]"></i>
                                </button>
                                <button class="w-[28px] h-[28px] rounded-full bg-[#fee2e2] text-red-500 flex items-center justify-center hover:bg-red-200 transition-colors" title="Hapus">
                                    <i class="ph-fill ph-trash text-[15px]"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <!-- Row 4 -->
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="py-4 px-2 border-b border-gray-50 text-center">4.</td>
                        <td class="py-4 px-2 border-b border-gray-50">Yanto Supriyanto</td>
                        <td class="py-4 px-2 border-b border-gray-50">Guru</td>
                        <td class="py-4 px-2 border-b border-gray-50">01-02-030081983</td>
                        <td class="py-4 px-4 border-b border-gray-50 text-left">
                            <button class="w-[28px] h-[28px] rounded-full bg-[#fef3c7] text-[#d97706] inline-flex items-center justify-center cursor-default" title="Pending">
                                <i class="ph-bold ph-clock text-[15px]"></i>
                            </button>
                        </td>
                        <td class="py-4 px-2 border-b border-gray-50">
                            <div class="flex items-center justify-center gap-2">
                                <button onclick="showDetail('Yanto Supriyanto', '0102030081983', 'Guru', '01-02-030081983', 'Pending')" class="w-[28px] h-[28px] rounded-full bg-[#e2e8f0] text-brand-blue flex items-center justify-center hover:bg-gray-300 transition-colors" title="Lihat Detail">
                                    <i class="ph-fill ph-eye text-[15px]"></i>
                                </button>
                                <button onclick="editData('Yanto Supriyanto', '0102030081983', 'Guru')" class="w-[28px] h-[28px] rounded-full bg-[#d1fae5] text-[#10a163] flex items-center justify-center hover:bg-green-200 transition-colors" title="Edit">
                                    <i class="ph-fill ph-pencil-simple text-[15px]"></i>
                                </button>
                                <button class="w-[28px] h-[28px] rounded-full bg-[#fee2e2] text-red-500 flex items-center justify-center hover:bg-red-200 transition-colors" title="Hapus">
                                    <i class="ph-fill ph-trash text-[15px]"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <!-- Row 5 -->
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="py-4 px-2 border-b border-gray-50 text-center">5.</td>
                        <td class="py-4 px-2 border-b border-gray-50">Ali Mahendra</td>
                        <td class="py-4 px-2 border-b border-gray-50">TU</td>
                        <td class="py-4 px-2 border-b border-gray-50">01-03-050081993</td>
                        <td class="py-4 px-4 border-b border-gray-50 text-left">
                            <button class="w-[28px] h-[28px] rounded-full bg-[#fef3c7] text-[#d97706] inline-flex items-center justify-center cursor-default" title="Pending">
                                <i class="ph-bold ph-clock text-[15px]"></i>
                            </button>
                        </td>
                        <td class="py-4 px-2 border-b border-gray-50">
                            <div class="flex items-center justify-center gap-2">
                                <button onclick="showDetail('Ali Mahendra', '0103050081993', 'TU', '01-03-050081993', 'Pending')" class="w-[28px] h-[28px] rounded-full bg-[#e2e8f0] text-brand-blue flex items-center justify-center hover:bg-gray-300 transition-colors" title="Lihat Detail">
                                    <i class="ph-fill ph-eye text-[15px]"></i>
                                </button>
                                <button onclick="editData('Ali Mahendra', '0103050081993', 'TU')" class="w-[28px] h-[28px] rounded-full bg-[#d1fae5] text-[#10a163] flex items-center justify-center hover:bg-green-200 transition-colors" title="Edit">
                                    <i class="ph-fill ph-pencil-simple text-[15px]"></i>
                                </button>
                                <button class="w-[28px] h-[28px] rounded-full bg-[#fee2e2] text-red-500 flex items-center justify-center hover:bg-red-200 transition-colors" title="Hapus">
                                    <i class="ph-fill ph-trash text-[15px]"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-end gap-1.5 mt-5 pt-2">
            <button class="w-[26px] h-[26px] rounded bg-brand-blue text-white flex items-center justify-center text-[12px] hover:bg-[#152a42] transition-colors">
                <i class="ph-bold ph-caret-left"></i>
            </button>
            <span class="w-[26px] h-[26px] flex items-center justify-center text-[13px] font-bold text-brand-blue">1</span>
            <button class="w-[26px] h-[26px] rounded bg-brand-blue text-white flex items-center justify-center text-[13px] font-medium hover:bg-[#152a42] transition-colors">2</button>
            <button class="w-[26px] h-[26px] rounded bg-brand-blue text-white flex items-center justify-center text-[13px] font-medium hover:bg-[#152a42] transition-colors">3</button>
            <button class="w-[26px] h-[26px] rounded bg-brand-blue text-white flex items-center justify-center text-[13px] font-medium hover:bg-[#152a42] transition-colors">4</button>
            <span class="w-[20px] flex items-center justify-center text-[13px] font-bold text-gray-500 tracking-widest">...</span>
            <button class="w-[26px] h-[26px] rounded bg-brand-blue text-white flex items-center justify-center text-[13px] font-medium hover:bg-[#152a42] transition-colors">40</button>
            <button class="w-[26px] h-[26px] rounded bg-brand-blue text-white flex items-center justify-center text-[12px] hover:bg-[#152a42] transition-colors">
                <i class="ph-bold ph-caret-right"></i>
            </button>
        </div>
    </div>
</div>

<!-- ================= CRUD VIEWS (Separated Files) ================= -->
@include('costumerservice.crudnasabah.tambah')
@include('costumerservice.crudnasabah.edit')
@include('costumerservice.crudnasabah.detail')

@endsection

@section('scripts')
<script>
    function switchView(viewName) {
        const views = {
            'tabel': document.getElementById('viewTabelData'),
            'tambah': document.getElementById('viewTambahData'),
            'edit': document.getElementById('viewEditData'),
            'detail': document.getElementById('viewDetailData')
        };

        Object.values(views).forEach(v => {
            if(v) {
                v.classList.remove('block', 'flex');
                v.classList.add('hidden');
            }
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
        document.querySelector('main').scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Handle view parameter from URL
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const view = urlParams.get('view');
        if (view) {
            switchView(view);
        }
    });

    function showDetail(nama, nis, jurusan, rek, status) {
        document.getElementById('detail_nama').value = nama;
        document.getElementById('detail_nis').value = nis;
        document.getElementById('detail_jurusan').value = jurusan;
        document.getElementById('detail_rekening').value = rek;
        document.getElementById('detail_status').value = status;
        switchView('detail');
    }

    function editData(nama, nis, jurusan) {
        document.getElementById('edit_nama').value = nama;
        document.getElementById('edit_nis').value = nis;
        document.getElementById('edit_jurusan').value = jurusan;
        switchView('edit');
    }
</script>
@endsection