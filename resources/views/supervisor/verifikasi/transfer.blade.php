@extends('layouts.supervisor')

@section('title','Supervisor Dashboard')
@section('header_title')
    Selamat Datang, {{ $supervisor->nama_petugas }}!
@endsection
@section('header_subtitle', 'Lorem Ipsum is simply dummy text of the printing.')

@section('styles')
<style>
    /* Fade animation */
    .fade-in {
        animation: fadeIn 0.3s ease-in-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection

@section('content')
<div id="viewTabelData" class="fade-in flex flex-1 flex-col justify-start">
    <!-- Search Bar Mobile -->
    <div class="md:hidden relative mb-5">
        <i class="ph ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-lg"></i>
        <input type="text" placeholder="Cari data..." class="w-full pl-12 pr-4 py-3.5 bg-white border border-gray-100 rounded-2xl text-[14px] focus:outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue text-gray-700 placeholder-gray-400 shadow-sm transition-all">
    </div>

    
    <!-- Section Title & Tabs -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-5 px-1 gap-4">
        <h3 class="text-[24px] font-bold text-gray-800">Pending Verifikasi</h3>
        
        <div class="flex bg-gray-100 p-1 rounded-xl w-full sm:w-[300px]">
            <a href="{{ route('supervisor.verifikasi.registrasi') }}" class="flex-1 px-4 py-2 text-gray-500 font-medium text-[13px] hover:text-brand-blue transition-colors text-center">Registrasi</a>
            <a href="{{ route('supervisor.verifikasi') }}" class="flex-1 px-4 py-2 bg-white rounded-lg shadow-sm text-brand-blue font-bold text-[13px] text-center transition-all">Transfer</a>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-[20px] shadow-card p-6 w-full flex flex-col mb-5">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr>
                        <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] w-12 border-b border-gray-100">No</th>
                        <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">Nama Pengirim</th>
                        <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">Nama Penerima</th>
                        <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">Nominal Transfer</th>
                        <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">Nomor Telepon</th>
                        <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">Status</th>
                        <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] text-center w-[140px] border-b border-gray-100">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-[14px] text-gray-800 font-medium">
                    <!-- Row 1 -->
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="py-4 px-2 border-b border-gray-50">1.</td>
                        <td class="py-4 px-2 border-b border-gray-50">Pajar Azmi Anugraha</td>
                        <td class="py-4 px-2 border-b border-gray-50">Salsabila Rosi Cahyani</td>
                        <td class="py-4 px-2 border-b border-gray-50">Rp. 200.000</td>
                        <td class="py-4 px-2 border-b border-gray-50">081234567890</td>
                        <td class="py-4 px-2 border-b border-gray-50 text-center">
                            <button class="w-[28px] h-[28px] rounded-full bg-[#fef3c7] text-[#d97706] inline-flex items-center justify-center cursor-default" title="Pending">
                                <i class="ph-bold ph-clock text-[15px]"></i>
                            </button>
                        </td>
                        <td class="py-4 px-2 border-b border-gray-50">
                            <div class="flex items-center justify-center gap-2">
                                <button onclick="viewDetail('Pajar Azmi Anugraha', 'Salsabila Rosi Cahyani', 'Rp. 200.000', '03-03-232410243', '081234567890')" class="w-[30px] h-[30px] rounded-full bg-[#e2e8f0] text-brand-blue flex items-center justify-center hover:bg-gray-300 transition-colors" title="Lihat Detail"><i class="ph-fill ph-eye text-[16px]"></i></button>
                                <button class="w-[30px] h-[30px] rounded-full bg-[#d1fae5] text-[#10a163] flex items-center justify-center hover:bg-green-200 transition-colors" title="Setujui"><i class="ph-bold ph-check-circle text-[16px]"></i></button>
                                <button class="w-[30px] h-[30px] rounded-full bg-[#fee2e2] text-red-500 flex items-center justify-center hover:bg-red-200 transition-colors" title="Tolak"><i class="ph-bold ph-x-circle text-[16px]"></i></button>
                            </div>
                        </td>
                    </tr>
                    <!-- Row 2 -->
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="py-4 px-2 border-b border-gray-50">2.</td>
                        <td class="py-4 px-2 border-b border-gray-50">Salsabila Rosi Cahyani</td>
                        <td class="py-4 px-2 border-b border-gray-50">Anisa Siti Nur Fajriyanti</td>
                        <td class="py-4 px-2 border-b border-gray-50">Rp. 10.000</td>
                        <td class="py-4 px-2 border-b border-gray-50">081234567890</td>
                        <td class="py-4 px-2 border-b border-gray-50 text-center">
                            <button class="w-[28px] h-[28px] rounded-full bg-[#fef3c7] text-[#d97706] inline-flex items-center justify-center cursor-default" title="Pending">
                                <i class="ph-bold ph-clock text-[15px]"></i>
                            </button>
                        </td>
                        <td class="py-4 px-2 border-b border-gray-50">
                            <div class="flex items-center justify-center gap-2">
                                <button onclick="viewDetail('Salsabila Rosi Cahyani', 'Anisa Siti Nur Fajriyanti', 'Rp. 10.000', '03-03-232410229', '081234567890')" class="w-[30px] h-[30px] rounded-full bg-[#e2e8f0] text-brand-blue flex items-center justify-center hover:bg-gray-300 transition-colors" title="Lihat Detail"><i class="ph-fill ph-eye text-[16px]"></i></button>
                                <button class="w-[30px] h-[30px] rounded-full bg-[#d1fae5] text-[#10a163] flex items-center justify-center hover:bg-green-200 transition-colors" title="Setujui"><i class="ph-bold ph-check-circle text-[16px]"></i></button>
                                <button class="w-[30px] h-[30px] rounded-full bg-[#fee2e2] text-red-500 flex items-center justify-center hover:bg-red-200 transition-colors" title="Tolak"><i class="ph-bold ph-x-circle text-[16px]"></i></button>
                            </div>
                        </td>
                    </tr>
                    <!-- Row 3 -->
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="py-4 px-2 border-b border-gray-50">3.</td>
                        <td class="py-4 px-2 border-b border-gray-50">Anisa Siti Nur Fajriyanti</td>
                        <td class="py-4 px-2 border-b border-gray-50">Yanto Supriyanto</td>
                        <td class="py-4 px-2 border-b border-gray-50">Rp. 5.000</td>
                        <td class="py-4 px-2 border-b border-gray-50">081234567890</td>
                        <td class="py-4 px-2 border-b border-gray-50 text-center">
                            <button class="w-[28px] h-[28px] rounded-full bg-[#fef3c7] text-[#d97706] inline-flex items-center justify-center cursor-default" title="Pending">
                                <i class="ph-bold ph-clock text-[15px]"></i>
                            </button>
                        </td>
                        <td class="py-4 px-2 border-b border-gray-50">
                            <div class="flex items-center justify-center gap-2">
                                <button onclick="viewDetail('Anisa Siti Nur Fajriyanti', 'Yanto Supriyanto', 'Rp. 5.000', '01-02-030081983', '081234567890')" class="w-[30px] h-[30px] rounded-full bg-[#e2e8f0] text-brand-blue flex items-center justify-center hover:bg-gray-300 transition-colors" title="Lihat Detail"><i class="ph-fill ph-eye text-[16px]"></i></button>
                                <button class="w-[30px] h-[30px] rounded-full bg-[#d1fae5] text-[#10a163] flex items-center justify-center hover:bg-green-200 transition-colors" title="Setujui"><i class="ph-bold ph-check-circle text-[16px]"></i></button>
                                <button class="w-[30px] h-[30px] rounded-full bg-[#fee2e2] text-red-500 flex items-center justify-center hover:bg-red-200 transition-colors" title="Tolak"><i class="ph-bold ph-x-circle text-[16px]"></i></button>
                            </div>
                        </td>
                    </tr>
                    <!-- Row 4 -->
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="py-4 px-2 border-b border-gray-50">4.</td>
                        <td class="py-4 px-2 border-b border-gray-50">Yanto Supriyanto</td>
                        <td class="py-4 px-2 border-b border-gray-50">Ali Mahendra</td>
                        <td class="py-4 px-2 border-b border-gray-50">Rp. 150.000</td>
                        <td class="py-4 px-2 border-b border-gray-50">081234567890</td>
                        <td class="py-4 px-2 border-b border-gray-50 text-center">
                            <button class="w-[28px] h-[28px] rounded-full bg-[#fef3c7] text-[#d97706] inline-flex items-center justify-center cursor-default" title="Pending">
                                <i class="ph-bold ph-clock text-[15px]"></i>
                            </button>
                        </td>
                        <td class="py-4 px-2 border-b border-gray-50">
                            <div class="flex items-center justify-center gap-2">
                                <button onclick="viewDetail('Yanto Supriyanto', 'Ali Mahendra', 'Rp. 150.000', '01-03-050081993', '081234567890')" class="w-[30px] h-[30px] rounded-full bg-[#e2e8f0] text-brand-blue flex items-center justify-center hover:bg-gray-300 transition-colors" title="Lihat Detail"><i class="ph-fill ph-eye text-[16px]"></i></button>
                                <button class="w-[30px] h-[30px] rounded-full bg-[#d1fae5] text-[#10a163] flex items-center justify-center hover:bg-green-200 transition-colors" title="Setujui"><i class="ph-bold ph-check-circle text-[16px]"></i></button>
                                <button class="w-[30px] h-[30px] rounded-full bg-[#fee2e2] text-red-500 flex items-center justify-center hover:bg-red-200 transition-colors" title="Tolak"><i class="ph-bold ph-x-circle text-[16px]"></i></button>
                            </div>
                        </td>
                    </tr>
                    <!-- Row 5 -->
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="py-4 px-2 border-b border-gray-50">5.</td>
                        <td class="py-4 px-2 border-b border-gray-50">Ali Mahendra</td>
                        <td class="py-4 px-2 border-b border-gray-50">Pajar Azmi Anugraha</td>
                        <td class="py-4 px-2 border-b border-gray-50">Rp. 25.000</td>
                        <td class="py-4 px-2 border-b border-gray-50">081234567890</td>
                        <td class="py-4 px-2 border-b border-gray-50 text-center">
                            <button class="w-[28px] h-[28px] rounded-full bg-[#fef3c7] text-[#d97706] inline-flex items-center justify-center cursor-default" title="Pending">
                                <i class="ph-bold ph-clock text-[15px]"></i>
                            </button>
                        </td>
                        <td class="py-4 px-2 border-b border-gray-50">
                            <div class="flex items-center justify-center gap-2">
                                <button onclick="viewDetail('Ali Mahendra', 'Pajar Azmi Anugraha', 'Rp. 25.000', '03-03-232410204', '081234567890')" class="w-[30px] h-[30px] rounded-full bg-[#e2e8f0] text-brand-blue flex items-center justify-center hover:bg-gray-300 transition-colors" title="Lihat Detail"><i class="ph-fill ph-eye text-[16px]"></i></button>
                                <button class="w-[30px] h-[30px] rounded-full bg-[#d1fae5] text-[#10a163] flex items-center justify-center hover:bg-green-200 transition-colors" title="Setujui"><i class="ph-bold ph-check-circle text-[16px]"></i></button>
                                <button class="w-[30px] h-[30px] rounded-full bg-[#fee2e2] text-red-500 flex items-center justify-center hover:bg-red-200 transition-colors" title="Tolak"><i class="ph-bold ph-x-circle text-[16px]"></i></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <x-pagination total="3" />

    </div>
</div>

<!-- ================= CRUD VIEWS (Separated Files) ================= -->
@include('supervisor.verifikasi.transfer.detail')
@endsection

@section('scripts')
<script>
    // Lihat Detail
    function viewDetail(pengirim, penerima, nominal, rek, telp) {
        document.getElementById('detail_pengirim').value = pengirim;
        document.getElementById('detail_penerima').value = penerima;
        document.getElementById('detail_nominal').value = nominal;
        document.getElementById('detail_rek_penerima').value = rek;
        document.getElementById('detail_telepon').value = telp;
        
        // Dummy data untuk field tambahan
        document.getElementById('detail_tanggal').value = '12 Mei 2024, 14:30';
        document.getElementById('detail_catatan').value = 'Pembayaran uang praktikum RPL Semester Genap.';
        
        switchView('detail');
    }

    // Pindah antara Tabel Data dan Detail
    function switchView(viewName) {
        const views = {
            'tabel': document.getElementById('viewTabelData'),
            'detail': document.getElementById('viewDetailData')
        };

        // Sembunyikan semua view
        Object.values(views).forEach(v => {
            if(v) {
                v.classList.add('hidden');
                v.classList.remove('flex', 'block');
            }
        });

        // Tampilkan view yang dipilih
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
</script>
@endsection