@extends('layouts.nasabah')

@section('title', 'Transfer - Bank Mini')
@section('header_title', 'Transfer Rekening')
@section('header_subtitle', 'Kirim uang dengan mudah dan aman ke sesama rekening Bank Mini.')

@section('content')
<div class="pb-10">
    <!-- MOBILE HEADER INFO -->
    <div class="lg:hidden pt-4 pb-2">
        <h2 class="text-xl font-bold text-textDark">Transfer Rekening</h2>
        <p class="text-textGray text-[10px]">Kirim uang dengan mudah dan aman.</p>
    </div>

    <!-- MAIN VIEW (Form & Recent History) -->
    <div id="viewMain" class="fade-in block">
    <div id="transferMainView">
        <!-- TOP SECTION: Saldo Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-4 lg:mt-0">
            <!-- Card Kiri: Saldo Diterima -->
            <div class="bg-primary-gradient rounded-2xl p-6 lg:p-7 relative overflow-hidden shadow-lg text-white">
                <div class="absolute right-6 top-1/2 -translate-y-1/2 w-32 h-32 opacity-[0.06] text-white">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" class="w-full h-full">
                        <path d="M21 12V7H5a2 2 0 010-4h14v4"></path>
                        <path d="M3 5v14a2 2 0 002 2h16v-5"></path>
                        <path d="M18 12a2 2 0 000 4h4v-4h-4z"></path>
                    </svg>
                </div>
                <div class="relative z-10">
                    <p class="text-[10px] lg:text-xs font-semibold tracking-widest text-gray-300 uppercase mb-2">TOTAL SALDO DITERIMA</p>
                    <h3 class="text-2xl lg:text-4xl font-bold mb-3 lg:mb-6 tracking-tight">Rp. 10.500.000</h3>
                    <div class="flex items-center gap-2 text-xs lg:text-sm text-gray-300">
                        <i class="ph ph-clock-counter-clockwise opacity-60"></i>
                        <p>Akumulasi Transaksi Bulan Ini</p>
                    </div>
                </div>
            </div>

            <!-- Card Kanan: Saldo Terkirim -->
            <div class="bg-secondary-gradient rounded-2xl p-6 lg:p-7 relative overflow-hidden shadow-sm border border-white">
                <div class="absolute right-6 top-1/2 -translate-y-1/2 w-32 h-32 opacity-[0.04] text-primary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" class="w-full h-full">
                        <path d="M21 12V7H5a2 2 0 010-4h14v4"></path>
                        <path d="M3 5v14a2 2 0 002 2h16v-5"></path>
                        <path d="M18 12a2 2 0 000 4h4v-4h-4z"></path>
                    </svg>
                </div>
                <div class="relative z-10">
                    <p class="text-[10px] lg:text-xs font-semibold tracking-widest text-textGray uppercase mb-2">TOTAL SALDO TERKIRIM</p>
                    <h3 class="text-2xl lg:text-4xl font-bold mb-3 lg:mb-6 tracking-tight text-primary">Rp. 500.000</h3>
                    <div class="flex items-center gap-2 text-xs lg:text-sm text-textGray">
                        <i class="ph ph-clock-counter-clockwise opacity-40"></i>
                        <p>Akumulasi Transaksi Bulan Ini</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- BOTTOM SECTION: Form & Riwayat -->
        <div class="mt-10 flex flex-col lg:flex-row gap-10">
            <!-- FORMULIR TRANSFER (Kiri) -->
            <div class="lg:w-7/12 bg-white rounded-3xl p-6 lg:p-8 shadow-[0_4px_24px_rgba(0,0,0,0.02)] border border-gray-50 h-fit">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-1.5 h-7 bg-accentYellow rounded-full"></div>
                    <h3 class="text-lg lg:text-2xl font-bold text-textDark">Formulir Transfer</h3>
                </div>

                <!-- 
                    BAGIAN BACKEND: FORM TRANSFER (NASABAH)
                    - action="#": Perlu diisi dengan route transfer untuk nasabah login (misal: route('nasabah.transfer.store')).
                    - method="POST": Menggunakan metode POST untuk transaksi.
                -->
                <form action="#" method="POST" class="space-y-6">
                    <!-- 
                        BAGIAN BACKEND: CSRF TOKEN
                    -->
                    @csrf
                    @if($errors->any())
                        <div class="bg-red-50 text-red-500 p-4 rounded-xl text-sm border border-red-100">
                            <ul class="list-disc pl-4">@foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
                        </div>
                    @endif
                    @if(session('success'))
                        <div class="bg-green-50 text-green-600 p-4 rounded-xl text-sm border border-green-100">{{ session('success') }}</div>
                    @endif

                    <div>
                        <label class="block text-xs font-semibold text-textGray mb-2">Nama Penerima</label>
                        <!-- 
                            BAGIAN BACKEND: INPUT PENERIMA
                            - Ditangkap sebagai $request->nama_penerima di controller.
                        -->
                        <input type="text" name="nama_penerima" id="nama_penerima" value="{{ old('nama_penerima') }}" required class="w-full border border-formBorder rounded-xl p-3 text-textDark outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors" placeholder="">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-textGray mb-2">Nominal Transfer (Rp)</label>
                        <!-- 
                            BAGIAN BACKEND: INPUT NOMINAL
                            - Ditangkap sebagai $request->nominal di controller.
                        -->
                        <input type="number" name="nominal" id="nominal" value="{{ old('nominal') }}" required min="1000" class="w-full border border-formBorder rounded-xl p-3 text-textDark outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors" placeholder="">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-textGray mb-2">Catatan (Opsional)</label>
                        <!-- 
                            BAGIAN BACKEND: INPUT CATATAN
                            - Ditangkap sebagai $request->catatan di controller.
                        -->
                        <textarea rows="4" name="catatan" id="catatan" class="w-full border border-formBorder rounded-xl p-3 text-textDark outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors resize-none" placeholder="">{{ old('catatan') }}</textarea>
                    </div>
                    <button type="submit" class="w-full bg-success-gradient hover:bg-green-700 text-white font-bold text-sm py-4 rounded-xl transition-colors mt-2 shadow-sm">Kirim</button>
                </form>
            </div>

            <!-- RIWAYAT TERBARU (Kanan) -->
            <div class="lg:w-5/12">
                <div class="flex justify-between items-center mb-8 px-2">
                    <h3 class="text-[16px] font-bold text-gray-800">Riwayat Transfer</h3>
                    <button onclick="switchView('history')" class="text-[11px] font-bold text-gray-800 hover:text-primary transition-colors">Lihat Semua</button>
                </div>

                <div class="space-y-4 px-2">
                    <!-- 
                        BAGIAN BACKEND: RIWAYAT TERBARU
                        - Data statis di bawah perlu diganti dengan data dari database (misal: mengambil 6 transaksi terakhir).
                    -->
                    @php
                        $recentHistory = [
                            ['name' => 'Pajar Azmi', 'date' => '25 Desember 2026', 'amount' => '+ Rp. 50.000', 'color' => '#10a163'],
                            ['name' => 'Anisa Siti', 'date' => '10 Desember 2026', 'amount' => '- Rp. 100.000', 'color' => '#ef4444'],
                            ['name' => 'Ramdan', 'date' => '01 Desember 2026', 'amount' => '- Rp. 1.000.000', 'color' => '#ef4444'],
                            ['name' => 'Dinar', 'date' => '28 November 2026', 'amount' => '+ Rp. 500.000', 'color' => '#10a163'],
                            ['name' => 'Aditya', 'date' => '20 November 2026', 'amount' => '- Rp. 10.000', 'color' => '#ef4444'],
                            ['name' => 'Rafka', 'date' => '16 November 2026', 'amount' => '+ Rp. 50.000', 'color' => '#10a163'],
                        ];
                    @endphp
                    @foreach($recentHistory as $item)
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <i class="ph-fill ph-user-circle text-[32px] lg:text-[44px] text-[#1c3a5a]"></i>
                            <div>
                                <p class="font-bold text-[13px] lg:text-[14px] text-gray-800">{{ $item['name'] }}</p>
                                <p class="text-[9px] lg:text-[10px] text-gray-500 mt-0.5">{{ $item['date'] }}</p>
                            </div>
                        </div>
                        <p class="font-bold text-[12px] lg:text-[13px] text-[{{ $item['color'] }}]">{{ $item['amount'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- VIEW HISTORY: Riwayat Transaksi (10 Terakhir) -->
    <div id="viewHistory" class="fade-in hidden">
        <div class="bg-white rounded-[32px] shadow-[0_4px_24px_rgba(0,0,0,0.02)] border border-gray-50 p-8 lg:p-12 mt-4 lg:mt-0">
            <div class="flex justify-between items-center mb-12">
                <button onclick="switchView('main')" class="text-[10px] lg:text-[14px] font-bold text-textDark hover:text-primary transition-colors">
                    Kembali
                </button>
                <h3 class="text-[12px] lg:text-[22px] font-bold text-textDark">Riwayat Transfer</h3>
            </div>

            <div class="space-y-8">
                <!-- 
                    BAGIAN BACKEND: RIWAYAT TRANSAKSI PANJANG
                    - Lakukan looping foreach untuk 10 transaksi terakhir (khusus transfer).
                -->
                @php
                    $history5 = [
                        ['name' => 'Pajar Azmi', 'date' => '25 Desember 2026', 'amount' => '- Rp. 50.000', 'color' => '#ef4444'],
                        ['name' => 'Anisa Siti', 'date' => '10 Desember 2026', 'amount' => '+ Rp. 100.000', 'color' => '#10a163'],
                        ['name' => 'Ramdan', 'date' => '05 Desember 2026', 'amount' => '- Rp. 200.000', 'color' => '#ef4444'],
                        ['name' => 'Pajar Azmi', 'date' => '25 November 2026', 'amount' => '- Rp. 50.000', 'color' => '#ef4444'],
                        ['name' => 'Anisa Siti', 'date' => '10 November 2026', 'amount' => '+ Rp. 100.000', 'color' => '#10a163'],
                    ];
                @endphp
                @foreach($history5 as $item)

                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        <i class="ph-fill ph-user-circle text-[32px] lg:text-[44px] text-[#1c3a5a]"></i>
                        <div>
                            <p class="font-bold text-[12px] lg:text-[16px] text-gray-800">{{ $item['name'] }}</p>
                            <p class="text-[8px] lg:text-[12px] text-gray-500 mt-0.5">{{ $item['date'] }}</p>
                        </div>
                    </div>
                    <p class="font-bold text-[10px] lg:text-[15px] text-[{{ $item['color'] }}]">{{ $item['amount'] }}</p>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <x-pagination total="3" />
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
        
        // Scroll top
        document.querySelector('main').scrollTo({ top: 0, behavior: 'smooth' });
    }
</script>
@endsection
