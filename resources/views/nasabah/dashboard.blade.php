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
                        <p class="text-lg lg:text-xl font-bold">+ Rp {{ number_format($totalPemasukanBulanIni, 0, ',', '.') }}</p>
                    </div>
                    <!-- Pengeluaran -->
                    <div class="bg-primaryLight/70 rounded-xl p-4 lg:p-5 backdrop-blur-sm">
                        <p class="text-[10px] lg:text-xs font-bold tracking-widest text-gray-200 uppercase mb-1 lg:mb-2">Pengeluaran Bulan Ini</p>
                        <p class="text-lg lg:text-xl font-bold">- Rp {{ number_format($totalPengeluaranBulanIni, 0, ',', '.') }}</p>
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

        @forelse($riwayatTransfer as $item)

        @php
            $isSetoran = isset($item->jenis_transaksi)
                        && $item->jenis_transaksi == 'setoran';

            $isPenarikan = isset($item->jenis_transaksi)
                        && $item->jenis_transaksi == 'penarikan';

            $isTransferTellerKeluar = isset($item->jenis_transaksi)
                        && $item->jenis_transaksi == 'transfer_teller_keluar';

            $isTransferTellerMasuk = isset($item->jenis_transaksi)
                        && $item->jenis_transaksi == 'transfer_teller_masuk';

            $isKeluar =
                $isTransferTellerKeluar ||
                (
                    !$isSetoran &&
                    !$isPenarikan &&
                    isset($item->id_pengirim) &&
                    $item->id_pengirim == $rekening->id
                );
        @endphp

            <div class="flex justify-between items-center bg-white p-4 px-6 rounded-[20px] border border-gray-50 hover:border-gray-100 hover:shadow-sm transition-all">

                <div class="flex items-center gap-4">

                    <div class="w-6 h-6 lg:w-12 lg:h-12 rounded-full flex items-center justify-center
                        @if($isSetoran)
                            bg-blue-100
                        @elseif($isPenarikan)
                            bg-orange-100
                        @elseif($isKeluar)
                            bg-red-100
                        @else
                            bg-green-100
                        @endif">

                        @if($isSetoran)

                            <i class="ph-bold ph-plus text-blue-600"></i>

                        @elseif($isPenarikan)

                            <i class="ph-bold ph-money text-orange-600"></i>

                        @elseif($isKeluar)

                            <i class="ph-bold ph-arrow-up text-red-600"></i>

                        @else

                            <i class="ph-bold ph-arrow-down text-green-600"></i>

                        @endif

                    </div>

                    <div>

                        <p class="font-bold text-sm lg:text-lg text-textDark">

                       @if($isSetoran)

                            Top Up Saldo

                        @elseif($isPenarikan)

                            Penarikan Tunai

                        @elseif($isTransferTellerKeluar)

                            Transfer Teller Keluar

                        @elseif($isTransferTellerMasuk)

                            Transfer Teller Masuk

                        @elseif($isKeluar)

                            Transfer Keluar

                        @else

                            Transfer Masuk

                        @endif

                        </p> 

                        @if($isSetoran)

                            <p class="text-[8px] lg:text-[10px] text-gray-400">
                                Top Up melalui Teller
                            </p>

                        @elseif($isPenarikan)

                            <p class="text-[8px] lg:text-[10px] text-gray-400">
                                Penarikan melalui Teller
                            </p>

                        @elseif($isTransferTellerKeluar)

                            <p class="text-[8px] lg:text-[10px] text-gray-400">
                                Transfer Teller ke {{ $item->id_rekening_penerima }}
                            </p>

                        @elseif($isTransferTellerMasuk)

                            <p class="text-[8px] lg:text-[10px] text-gray-400">
                                Transfer Teller dari {{ $item->id_rekening_pengirim }}
                            </p>

                        @elseif(
                            isset($item->jenis_transaksi) &&
                            $item->jenis_transaksi == 'transfer' &&
                            !empty($item->catatan)
                        )

                            <p class="text-[8px] lg:text-[10px] text-gray-400">
                                {{ $item->catatan }}
                            </p>

                        @endif

                    </div>

                </div>

                <p class="font-bold text-xs lg:text-lg
                    {{ $isKeluar ? 'text-red-500' : 'text-green-500' }}">

                @if($isSetoran)

                    + Rp {{ number_format($item->jumlah_penyetoran, 0, ',', '.') }}

                @elseif($isPenarikan)

                    - Rp {{ number_format($item->jumlah_penarikan, 0, ',', '.') }} 

                @else

                    {{ $isKeluar ? '-' : '+' }}
                    Rp {{ number_format($item->jumlah_transfer, 0, ',', '.') }}

                @endif

                </p>

            </div>

        @empty

            <div class="text-center py-8 text-gray-500">
                Belum ada riwayat transaksi.
            </div>

        @endforelse

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
    @forelse($semuaRiwayat as $item)

        @php
            $isSetoran = isset($item->jenis_transaksi)
                        && $item->jenis_transaksi == 'setoran';

            $isPenarikan = isset($item->jenis_transaksi)
                        && $item->jenis_transaksi == 'penarikan';

            $isTransferTellerKeluar = isset($item->jenis_transaksi)
                        && $item->jenis_transaksi == 'transfer_teller_keluar';

            $isTransferTellerMasuk = isset($item->jenis_transaksi)
                        && $item->jenis_transaksi == 'transfer_teller_masuk';

            $isKeluar =
                $isTransferTellerKeluar ||
                (
                    !$isSetoran &&
                    !$isPenarikan &&
                    isset($item->id_pengirim) &&
                    $item->id_pengirim == $rekening->id
                );
        @endphp

        <div class="flex justify-between items-center bg-white p-4 px-6 rounded-[20px] border border-gray-50 hover:border-gray-100 hover:shadow-sm transition-all">

            <div class="flex items-center gap-4">

                <div class="w-6 h-6 lg:w-12 lg:h-12 rounded-full flex items-center justify-center

                    @if($isSetoran)
                        bg-blue-100
                    @elseif($isPenarikan)
                        bg-orange-100
                    @elseif($isKeluar)
                        bg-red-100
                    @else
                        bg-green-100
                    @endif">

                   @if($isSetoran)

                        <i class="ph-bold ph-plus text-blue-600"></i>

                    @elseif($isPenarikan)

                        <i class="ph-bold ph-money text-orange-600"></i>

                    @elseif($isKeluar)

                        <i class="ph-bold ph-arrow-up text-red-600"></i>

                    @else

                        <i class="ph-bold ph-arrow-down text-green-600"></i>

                    @endif
                </div>

                <div>

                    <p class="font-bold text-sm lg:text-lg text-textDark">

                        @if($isSetoran)

                            Top Up Saldo

                        @elseif($isPenarikan)

                            Penarikan Tunai

                        @elseif($isTransferTellerKeluar)

                            Transfer Teller Keluar

                        @elseif($isTransferTellerMasuk)

                            Transfer Teller Masuk

                        @elseif($isKeluar)

                            Transfer Keluar

                        @else

                            Transfer Masuk

                        @endif

                    </p>

                    @if($isTransferTellerKeluar)

                        <p class="text-[8px] lg:text-[10px] text-gray-400">
                            Transfer Teller ke {{ $item->id_rekening_penerima }}
                        </p>

                    @elseif($isTransferTellerMasuk)

                        <p class="text-[8px] lg:text-[10px] text-gray-400">
                            Transfer Teller dari {{ $item->id_rekening_pengirim }}
                        </p>

                    @elseif(!$isSetoran && !empty($item->catatan))

                        <p class="text-[8px] lg:text-[10px] text-gray-400">
                            {{ $item->catatan }}
                        </p>

                    @endif

                </div>

            </div>

            <p class="font-bold text-xs lg:text-lg
                {{ $isKeluar ? 'text-red-500' : 'text-green-500' }}">

                @if($isSetoran)

                    + Rp {{ number_format($item->jumlah_penyetoran, 0, ',', '.') }}

                @elseif($isPenarikan)

                    - Rp {{ number_format($item->jumlah_penarikan, 0, ',', '.') }}

                @else

                    {{ $isKeluar ? '-' : '+' }}
                    Rp {{ number_format($item->jumlah_transfer, 0, ',', '.') }}

                @endif

            </p>

        </div>

    @empty

        <div class="text-center py-8 text-gray-500">
            Belum ada riwayat transaksi.
        </div>

    @endforelse
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
