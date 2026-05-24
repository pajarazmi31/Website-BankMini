@extends('layouts.nasabah')

@section('title', 'Dashboard - Bank Mini')
@section('header_title', 'Selamat Datang, Nasabah!')
@section('header_subtitle', 'Pantau saldo dan transaksi Anda hari ini.')

@section('content')
<div id="viewMain" class="fade-in block">
    <!-- TOP SECTION: Balance & Warning -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Saldo Card -->
        <div class="lg:col-span-2 bg-primary-gradient rounded-[20px] p-8 lg:p-10 relative overflow-hidden shadow-lg text-white">
            <!-- Background Watermark Icon -->
            <div class="absolute right-10 -translate-y-1/4 w-0 h-0 lg:w-40 lg:h-40 opacity-[0.08] text-white">
                <svg viewBox="0 0 256 256">
                    <rect width="256" height="256" fill="none" />
                    <circle cx="128" cy="128" r="32" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                    <rect x="16" y="64" width="224" height="128" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                    <path d="M240,104a48.85,48.85,0,0,1-40-40" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                    <path d="M200,192a48.85,48.85,0,0,1,40-40" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                    <path d="M16,152a48.85,48.85,0,0,1,40,40" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                    <path d="M56,64a48.85,48.85,0,0,1-40,40" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                </svg>
            </div>

            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-2">
                    <p class="text-xs font-medium tracking-widest text-gray-200 uppercase">Total Saldo Terkumpul</p>
                </div>
                <h3 class="text-3xl lg:text-4xl font-bold mt-4 mb-4 lg:mb-6 lg:mt-6 tracking-tight">Rp. {{number_format($rekening->saldo_saat_ini), ',', '.' }}</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                    <!-- Pemasukan -->
                    <div class="bg-primaryLight/70 rounded-xl p-4 lg:p-5 backdrop-blur-sm">
                        <p class="text-[10px] lg:text-xs font-bold tracking-widest text-gray-200 uppercase mb-1 lg:mb-2">Pemasukan Bulan Ini</p>
                        <p class="text-lg lg:text-xl font-bold">+ Rp 1.500.000</p>
                    </div>
                    <!-- Pengeluaran -->
                    <div class="bg-primaryLight/70 rounded-xl p-4 lg:p-5 backdrop-blur-sm">
                        <p class="text-[10px] lg:text-xs font-bold tracking-widest text-gray-200 uppercase mb-1 lg:mb-2">Pengeluaran Bulan Ini</p>
                        <p class="text-lg lg:text-xl font-bold">- Rp 500.000</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tips Keamanan Card -->
        <div class="bg-[#fef3c7] rounded-[20px] p-8 shadow-sm border border-orange-100/50 flex flex-col h-fit self-start">
            <div class="flex items-center gap-2 mb-3 text-[#92400e]">
                <i class="ph-fill ph-warning text-2xl text-[#b45309]"></i>
                <h4 class="font-bold text-[16px]">Tips Keamanan</h4>
            </div>
            <p class="text-[12px] text-[#92400e] leading-relaxed font-medium">
                Jangan pernah memberikan PIN atau password kepada siapapun, termasuk pihak yang mengaku sebagai petugas Bank Mini.
            </p>
        </div>
    </div>

    <!-- MIDDLE SECTION: Riwayat Transaksi -->
    <div class="mt-10">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg lg:text-xl font-bold text-gray-800">Riwayat Transaksi</h3>
            <button onclick="switchView('history')" class="text-xs font-semibold text-gray-400 hover:text-active-blue transition-colors">Lihat Semua</button>
        </div> 

        <div class="bg-transparent space-y-4">
            <!-- Item Statis 1 -->
            <div class="flex justify-between items-center bg-white p-5 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-50">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-[#ccf0dd] flex items-center justify-center">
                        <img src="{{ asset('img/icon/dashboard/income.png') }}" alt="Income" class="w-6 h-6">
                    </div>
                    <div>
                        <p class="font-bold text-base lg:text-lg text-textDark">Setor Tunai</p>
                        <p class="text-xs text-textGray mt-0.5">25 Oktober 2026</p>
                    </div>
                </div>
                <p class="font-bold text-sm lg:text-lg text-[#1fae62]">+ Rp. 50.000</p>
            </div>
            <!-- Item Statis 2 -->
            <div class="flex justify-between items-center bg-white p-5 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-50">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-[#fbd4d4] flex items-center justify-center">
                        <img src="{{ asset('img/icon/dashboard/expense.png') }}" alt="Expense" class="w-6 h-6">
                    </div>
                    <div>
                        <p class="font-bold text-base lg:text-lg text-textDark">Tarik Tunai</p>
                        <p class="text-xs text-textGray mt-0.5">20 Oktober 2026</p>
                    </div>
                </div>
                <p class="font-bold text-sm lg:text-lg text-[#e22f2f]">- Rp. 20.000</p>
            </div>
        </div>
    </div>

    <!-- BOTTOM SECTION: Banner Info -->
    <div class="mt-10 bg-white rounded-3xl overflow-hidden shadow-[0_4px_20px_rgba(0,0,0,0.03)] flex flex-col md:flex-row mb-10 border border-gray-100">
        <div class="md:w-[40%] bg-primary relative min-h-[250px]">
            <img src="{{ asset('img/banner_saving.png') }}" alt="Ilustrasi Menabung" class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-primary/60 to-transparent"></div>
        </div>

        <div class="md:w-[60%] p-10 flex flex-col justify-center">
            <h3 class="text-lg lg:text-2xl font-bold text-textDark mb-3">Mulai Menabung untuk Masa Depan.</h3>
            <p class="text-textGray mb-6 leading-relaxed text-xs lg:text-base">
                Mulai dari langkah kecil untuk hasil yang besar di kemudian hari. Disiplin menabung untuk membentuk masa depan yang cerah.
            </p>
            <ul class="space-y-3">
                <li class="flex items-center gap-3 text-sm font-semibold text-textDark">
                    <img src="{{ asset('img/icon/dashboard/check-status.png') }}" alt="Check" class="w-5 h-5">
                    Sistem Terenkripsi
                </li>
                <li class="flex items-center gap-3 text-sm font-semibold text-textDark">
                    <img src="{{ asset('img/icon/dashboard/check-status.png') }}" alt="Check" class="w-5 h-5">
                    Aman & Terpercaya
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- VIEW HISTORY -->
<div id="viewHistory" class="fade-in hidden">
    <div class="bg-white rounded-[32px] shadow-[0_4px_24px_rgba(0,0,0,0.02)] border border-gray-50 p-8 lg:p-12">
        <div class="flex justify-between items-center gap-4 bg-white p-5 rounded-2xl">
            <button onclick="switchView('main')" class="text-[10px] lg:text-[14px] font-bold text-textDark hover:text-primary transition-colors">
                Kembali
            </button>
            <h3 class="text-[12px] lg:text-[22px] font-bold text-textDark">Riwayat Transaksi</h3>
        </div>

        <div class="space-y-6">
            @php
            $history5 = [
            ['type' => 'income', 'title' => 'Setor Tunai', 'date' => '25 Oktober 2026', 'amount' => '+ Rp. 50.000', 'color' => '#1fae62', 'bg' => '#ccf0dd'],
            ['type' => 'expense', 'title' => 'Tarik Tunai', 'date' => '20 Oktober 2026', 'amount' => '- Rp. 50.000', 'color' => '#e22f2f', 'bg' => '#fbd4d4'],
            ['type' => 'income', 'title' => 'Setor Tunai', 'date' => '16 Desember 2026', 'amount' => '+ Rp. 50.000', 'color' => '#1fae62', 'bg' => '#ccf0dd'],
            ['type' => 'income', 'title' => 'Setor Tunai', 'date' => '16 Desember 2026', 'amount' => '+ Rp. 50.000', 'color' => '#1fae62', 'bg' => '#ccf0dd'],
            ['type' => 'expense', 'title' => 'Tarik Tunai', 'date' => '20 Oktober 2026', 'amount' => '- Rp. 50.000', 'color' => '#e22f2f', 'bg' => '#fbd4d4'],
            ];
            @endphp
            @foreach($history5 as $item)
            <div class="flex justify-between items-center bg-white p-4 px-6 rounded-[20px] border border-gray-50 hover:border-gray-100 hover:shadow-sm transition-all">
                <div class="flex items-center gap-4">
                    <div class="w-6 h-6 lg:w-12 lg:h-12 rounded-full bg-[{{ $item['bg'] }}] flex items-center justify-center">
                        <img src="{{ asset('img/icon/dashboard/' . $item['type'] . '.png') }}" alt="{{ $item['type'] }}" class="w-3 h-3 lg:w-6 lg:h-6">
                    </div>
                    <div>
                        <p class="font-bold text-sm lg:text-lg text-textDark">{{ $item['title'] }}</p>
                        <p class="text-[8px] lg:text-[11px] text-textGray mt-0.5">{{ $item['date'] }}</p>
                    </div>
                </div>
                <p class="font-bold text-xs lg:text-lg text-[{{ $item['color'] }}]">{{ $item['amount'] }}</p>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <x-pagination total="3" />

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

        document.querySelector('main').scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }
</script>
@endsection