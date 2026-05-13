@extends('layouts.teller')

@section('title', 'Teller Dashboard')
@section('header_title')
    Selamat Datang, {{ $teller->nama_petugas }}!
@endsection
@section('header_subtitle', 'Lorem Ipsum is simply dummy text of the printing.')

@section('content')
<div id="viewMain" class="fade-in block">
<!-- Statistics Cards -->
<section class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-7">
    <!-- Jumlah Tabungan -->
    <div class="bg-primary-gradient rounded-2xl p-6 text-white relative overflow-hidden shadow-lg h-[130px] flex flex-col justify-center">
        <div class="relative z-10">
            <p class="text-[11px] font-semibold tracking-[0.08em] text-blue-100/80 mb-2.5 uppercase">Jumlah Tabungan</p>
            {{-- BACKEND: {{ number_format($totalTabungan, 0, ',', '.') }} --}}
            <h3 class="text-[24px] font-bold">Rp. 1.100.500.000</h3>
        </div>
        <div class="absolute -right-2 -bottom-2 flex opacity-10"><i class="ph-fill ph-users text-[120px] translate-y-6 translate-x-4"></i></div>
    </div>

    <!-- Setoran Hari Ini -->
    <div class="bg-success-gradient rounded-2xl p-6 text-white relative overflow-hidden shadow-lg h-[130px] flex flex-col justify-center">
        <div class="relative z-10">
            <p class="text-[11px] font-semibold tracking-[0.08em] text-green-100/80 mb-2.5 uppercase">Setoran Hari Ini</p>
            {{-- BACKEND: {{ number_format($setoranHariIni, 0, ',', '.') }} --}}
            <h3 class="text-[24px] font-bold">Rp. 500.000</h3>
        </div>
        <div class="absolute -right-2 -bottom-2 flex opacity-10"><i class="ph-fill ph-users text-[120px] translate-y-6 translate-x-4"></i></div>
    </div>

    <!-- Penarikan Hari Ini -->
    <div class="bg-warning-gradient rounded-2xl p-6 text-white relative overflow-hidden shadow-lg h-[130px] flex flex-col justify-center">
        <div class="relative z-10">
            <p class="text-[11px] font-semibold tracking-[0.08em] text-yellow-100/80 mb-2.5 uppercase">Penarikan Hari Ini</p>
            {{-- BACKEND: {{ number_format($penarikanHariIni, 0, ',', '.') }} --}}
            <h3 class="text-[24px] font-bold">Rp. 1.000.000</h3>
        </div>
        <div class="absolute -right-2 -bottom-2 flex opacity-10"><i class="ph-fill ph-users text-[120px] translate-y-6 translate-x-4"></i></div>
    </div>
</section>

<!-- Bottom Content -->
<section class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    <!-- Left Column: Transaksi Terbaru -->
    <div class="lg:col-span-8 flex flex-col gap-3.5">

        <div class="flex justify-between items-end mb-1 px-1">
            <h3 class="text-[20px] font-bold text-gray-800">Transaksi Terbaru</h3>
            <button onclick="switchView('history')" class="text-[12px] font-semibold text-gray-800 hover:text-brand-blue">Lihat Semua</button>
        </div>

        <div class="flex flex-col gap-3">
            <!--
                BAGIAN BACKEND: TRANSAKSI TERBARU
                - Data $transactions di bawah ini hanya data statis untuk preview UI.
                - Backend dev perlu mengambil data transaksi terbaru (setor, tarik, transfer) dari database.
            -->
            @php
                $transactions = [
                    ['name' => 'Pajar Azmi', 'action' => 'Setor Tunai', 'amount' => '+ Rp. 50.000', 'color' => '#10a163', 'route' => 'teller.setoran'],
                    ['name' => 'Anisa Siti', 'action' => 'Tarik Tunai', 'amount' => '- Rp. 100.000', 'color' => '#ef4444', 'route' => 'teller.penarikan'],
                    ['name' => 'Pajar Azmi', 'action' => 'Transfer', 'amount' => 'Rp. 50.000', 'color' => '#1c3a5a', 'icon' => true, 'route' => 'teller.transfer'],
                ];
            @endphp
            @foreach($transactions as $t)
            <div class="bg-white rounded-[16px] p-4 px-5 flex items-center justify-between shadow-card">
                <div class="flex items-center gap-3.5">
                    <i class="ph-fill ph-user-circle text-[40px] text-brand-blue"></i>
                    <div>
                        <h4 class="font-bold text-[15px] text-gray-800">{{ $t['name'] }}</h4>
                        <p class="text-[12px] text-gray-500 mt-0.5">{{ $t['action'] }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <span class="font-bold text-[15px] text-[{{ $t['color'] }}] flex items-center gap-1.5">
                        @if(isset($t['icon'])) <i class="ph ph-arrows-left-right text-[16px]"></i> @endif
                        {{ $t['amount'] }}
                    </span>
                    <!-- Ikon mata dihapus -->
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Right Column: Aksi Cepat -->
    <div class="lg:col-span-4 flex flex-col gap-3.5 mb-5">
        <div class="mb-1 px-1"><h3 class="text-[20px] font-bold text-gray-800">Aksi Cepat</h3></div>
        <div class="flex flex-col gap-3">
            @php
                $quickActions = [
                    ['route' => 'teller.setoran', 'title' => 'Setoran Baru', 'desc' => 'Proses simpanan tunai', 'icon' => '<rect x="2" y="6" width="20" height="12" rx="2"/><circle cx="12" cy="12" r="2"/><path d="M6 12h.01M18 12h.01"/>'],
                    ['route' => 'teller.penarikan', 'title' => 'Penarikan Baru', 'desc' => 'Proses simpanan tunai', 'icon' => '<path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"/><path d="M3 5v14a2 2 0 0 0 2 2h16v-5"/><path d="M18 12a2 2 0 0 0 0 4h4v-4Z"/>'],
                    ['route' => 'teller.transfer', 'title' => 'Transfer Cepat', 'desc' => 'Antar rekening nasabah', 'icon' => '<path d="M17 3l4 4-4 4"/><path d="M3 7h18"/><path d="M7 21l-4-4 4-4"/><path d="M21 17H3"/>'],
                ];
            @endphp
            @foreach($quickActions as $qa)
            <a href="{{ route($qa['route']) }}" class="bg-white rounded-[16px] p-4 flex items-center gap-4 shadow-card hover:bg-gray-50 transition-colors text-left w-full border border-transparent hover:border-gray-100">
                <div class="text-brand-blue bg-[#f8f9fb] p-2 rounded-lg">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">@php echo $qa['icon'] @endphp</svg>
                </div>
                <div>
                    <h4 class="font-bold text-[15px] text-brand-blue mb-0.5">{{ $qa['title'] }}</h4>
                    <p class="text-[11px] text-gray-500">{{ $qa['desc'] }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
</div>

<!-- VIEW HISTORY: Semua Transaksi (10 Terakhir) -->
<div id="viewHistory" class="fade-in hidden">
    <div class="bg-white rounded-[24px] shadow-[0_4px_24px_rgba(0,0,0,0.02)] border border-gray-50 p-8 lg:p-10">
        <div class="flex justify-between items-center gap-4 mb-8 md:mb-10">
            <button onclick="switchView('main')" class="text-[10px] lg:text-[14px] font-bold text-gray-800 hover:text-brand-blue transition-colors flex items-center gap-2 w-fit">
                <i class="ph ph-arrow-left"></i> Kembali
            </button>
            <h3 class="text-[12px] lg:text-[22px] font-bold text-gray-800">Semua Transaksi</h3>
        </div>

        <div class="lg:space-y-5">
            <!--
                BAGIAN BACKEND: RIWAYAT TRANSAKSI (TELLER)
                - Lakukan looping foreach untuk 5 transaksi terakhir per halaman.
            -->
            @php
                $allTransactions5 = [
                    ['name' => 'Pajar Azmi', 'action' => 'Setor Tunai', 'amount' => '+ Rp. 50.000', 'color' => '#10a163', 'time' => '14:30'],
                    ['name' => 'Anisa Siti', 'action' => 'Tarik Tunai', 'amount' => '- Rp. 100.000', 'color' => '#ef4444', 'time' => '11:20'],
                    ['name' => 'Salsabila', 'action' => 'Transfer', 'amount' => 'Rp. 50.000', 'color' => '#1c3a5a', 'time' => '09:15', 'icon' => true],
                    ['name' => 'Hamdan', 'action' => 'Setor Tunai', 'amount' => '+ Rp. 200.000', 'color' => '#10a163', 'time' => 'Kemarin'],
                    ['name' => 'Dinar', 'action' => 'Tarik Tunai', 'amount' => '- Rp. 50.000', 'color' => '#ef4444', 'time' => 'Kemarin'],
                ];
            @endphp
            @foreach($allTransactions5 as $at)
            <div class="flex justify-between items-center bg-white p-4 rounded-[20px] border border-gray-50 hover:border-gray-100 hover:shadow-sm transition-all">
                <div class="flex items-center gap-2">
                    <i class="ph-fill ph-user-circle text-[40px] text-brand-blue"></i>
                    <div>
                        <h4 class="font-bold text-[10px] lg:text-[15px] text-gray-800">{{ $at['name'] }}</h4>
                        <p class="text-[8px] lg:text-[12px] text-gray-500 mt-0.5">{{ $at['action'] }} • {{ $at['time'] }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="font-bold text-[10px] lg:text-[15px] text-[{{ $at['color'] }}] flex items-center gap-1.5">
                        @if(isset($at['icon'])) <i class="ph ph-arrows-left-right text-[10px] lg:text-[16px]"></i> @endif
                        {{ $at['amount'] }}
                    </span>
                </div>
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

        // Scroll top
        window.scrollTo({ top: 0, behavior: 'smooth' });
        const scrollableMain = document.querySelector('main');
        if(scrollableMain) scrollableMain.scrollTo({ top: 0, behavior: 'smooth' });
    }
</script>
@endsection
