@extends('layouts.supervisor')

@section('header_title')
    Selamat Datang, {{ $super->nama_petugas }}!
@endsection
@section('header_title', 'Selamat Datang, Supervisor!')
@section('header_subtitle', 'Lorem Ipsum is simply dummy text of the printing.')

@section('content')
<div id="viewMain" class="fade-in block">
<!-- Statistics Cards -->
<section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">
    <!-- Total Saldo -->
    <div class="bg-primary-gradient rounded-2xl p-6 text-white relative overflow-hidden shadow-lg h-[130px] flex flex-col justify-center">
        <div class="relative z-10">
            <p class="text-[11px] font-semibold tracking-[0.08em] text-blue-100/80 mb-2.5 uppercase">Total Saldo Tabungan</p>
            <h3 class="text-[24px] md:text-[28px] font-bold">Rp. 1.100.500.000</h3>
        </div>
        <div class="absolute -right-2 -bottom-2 flex opacity-10"><i class="ph-fill ph-users text-[120px] translate-y-6 translate-x-4"></i></div>
    </div>

    <!-- Total Nasabah -->
    <div class="bg-brand-green rounded-2xl p-6 text-white relative overflow-hidden shadow-lg h-[130px] flex flex-col justify-center">
        <div class="relative z-10">
            <p class="text-[11px] font-semibold tracking-[0.08em] text-green-100/80 mb-2.5 uppercase">Total Nasabah</p>
            <h3 class="text-[28px] md:text-[32px] font-bold">500</h3>
        </div>
        <div class="absolute -right-2 -bottom-2 flex opacity-10"><i class="ph-fill ph-users text-[120px] translate-y-6 translate-x-4"></i></div>
    </div>

    <!-- Pending Verifikasi -->
    <div class="bg-brand-gold rounded-2xl p-6 text-white relative overflow-hidden shadow-lg h-[130px] flex flex-col justify-center sm:col-span-2 lg:col-span-1">
        <div class="relative z-10">
            <p class="text-[11px] font-semibold tracking-[0.08em] text-yellow-100/80 mb-2.5 uppercase">Pending Verifikasi</p>
            <h3 class="text-[28px] md:text-[32px] font-bold">34</h3>
        </div>
        <div class="absolute -right-2 -bottom-2 flex opacity-10"><i class="ph-fill ph-users text-[120px] translate-y-6 translate-x-4"></i></div>
    </div>
</section>

<!-- Bottom Content -->
<section class="grid grid-cols-1 gap-6">
    <div class="flex flex-col gap-3.5">
        <div class="flex justify-between items-end mb-1 px-1">
            <h3 class="text-[20px] font-bold text-gray-800">Pending Verifikasi</h3>
            <button onclick="switchView('history')" class="text-[12px] font-semibold text-gray-800 hover:text-brand-blue transition-colors">Lihat Semua</button>
        </div>

        <div class="flex flex-col gap-3">
            <!-- Row 1 -->
            <div class="bg-white rounded-[16px] p-4 px-5 flex items-center justify-between shadow-card">
                <div class="flex items-center gap-3.5">
                    <i class="ph-fill ph-user-circle text-[40px] text-brand-blue"></i>
                    <div>
                        <h4 class="font-bold text-[15px] text-gray-800">Pajar Azmi</h4>
                        <p class="text-[12px] text-gray-500 mt-0.5">Registrasi Akun Baru</p>
                    </div>
                </div>
                <button onclick="window.location.href='{{ route('supervisor.verifikasi') }}'" class="w-[32px] h-[32px] rounded-full bg-[#e2e8f0] text-brand-blue flex items-center justify-center hover:bg-gray-300 transition-colors" title="Lihat"><i class="ph-fill ph-eye text-[16px]"></i></button>
            </div>
            <!-- Row 2 -->
            <div class="bg-white rounded-[16px] p-4 px-5 flex items-center justify-between shadow-card">
                <div class="flex items-center gap-3.5">
                    <i class="ph-fill ph-user-circle text-[40px] text-brand-blue"></i>
                    <div>
                        <h4 class="font-bold text-[15px] text-gray-800">Anisa Siti</h4>
                        <p class="text-[12px] text-gray-500 mt-0.5">Transfer Masuk</p>
                    </div>
                </div>
                <button onclick="window.location.href='{{ route('supervisor.verifikasi') }}'" class="w-[32px] h-[32px] rounded-full bg-[#e2e8f0] text-brand-blue flex items-center justify-center hover:bg-gray-300 transition-colors" title="Lihat"><i class="ph-fill ph-eye text-[16px]"></i></button>
            </div>
        </div>
    </div>
</section>
</div>

<!-- VIEW HISTORY: Semua Pending Verifikasi (10 Terakhir) -->
<div id="viewHistory" class="fade-in hidden">
    <div class="bg-white rounded-[24px] shadow-[0_4px_24px_rgba(0,0,0,0.02)] border border-gray-50 p-8 lg:p-10">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-8 md:mb-10">
            <button onclick="switchView('main')" class="text-[14px] font-bold text-gray-800 hover:text-brand-blue transition-colors flex items-center gap-2 w-fit">
                <i class="ph ph-arrow-left"></i> Kembali
            </button>
            <h3 class="text-[20px] md:text-[22px] font-bold text-gray-800">Semua Pending Verifikasi</h3>
        </div>

        <div class="space-y-6">
            <!-- Row 1 -->
            <div class="flex justify-between items-center bg-white p-4 rounded-xl border border-gray-50 hover:border-gray-100 transition-all">
                <div class="flex items-center gap-4">
                    <i class="ph-fill ph-user-circle text-[40px] text-brand-blue"></i>
                    <div>
                        <h4 class="font-bold text-[15px] text-gray-800">Pajar Azmi</h4>
                        <p class="text-[12px] text-gray-500 mt-0.5">Registrasi Akun Baru • 14:30</p>
                    </div>
                </div>
                <button onclick="window.location.href='{{ route('supervisor.verifikasi') }}'" class="w-[32px] h-[32px] rounded-full bg-[#e2e8f0] text-brand-blue flex items-center justify-center hover:bg-gray-300 transition-colors">
                    <i class="ph-fill ph-eye text-[16px]"></i>
                </button>
            </div>
            <!-- Row 2 -->
            <div class="flex justify-between items-center bg-white p-4 rounded-xl border border-gray-50 hover:border-gray-100 transition-all">
                <div class="flex items-center gap-4">
                    <i class="ph-fill ph-user-circle text-[40px] text-brand-blue"></i>
                    <div>
                        <h4 class="font-bold text-[15px] text-gray-800">Anisa Siti</h4>
                        <p class="text-[12px] text-gray-500 mt-0.5">Transfer Masuk • 11:20</p>
                    </div>
                </div>
                <button onclick="window.location.href='{{ route('supervisor.verifikasi') }}'" class="w-[32px] h-[32px] rounded-full bg-[#e2e8f0] text-brand-blue flex items-center justify-center hover:bg-gray-300 transition-colors">
                    <i class="ph-fill ph-eye text-[16px]"></i>
                </button>
            </div>
            <!-- Tambahkan lebih banyak baris statis jika perlu -->
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function switchView(viewName) {
        const mainView = document.getElementById('viewMain');
        const historyView = document.getElementById('viewHistory');

        if (viewName === 'history') {
            mainView.classList.remove('block');
            mainView.classList.add('hidden');
            historyView.classList.remove('hidden');
            historyView.classList.add('block');
        } else {
            historyView.classList.remove('block');
            historyView.classList.add('hidden');
            mainView.classList.remove('hidden');
            mainView.classList.add('block');
        }

        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
</script>
@endsection
