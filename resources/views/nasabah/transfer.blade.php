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
                    <h3 class="text-2xl lg:text-4xl font-bold mb-3 lg:mb-6 tracking-tight">Rp. {{ number_format($totalPemasukanBulanIni, 0, ',', '.') }}</h3>
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
                    <h3 class="text-2xl lg:text-4xl font-bold mb-3 lg:mb-6 tracking-tight text-primary">Rp. {{ number_format($totalPengeluaranBulanIni, 0, ',', '.') }}</h3>
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
                <form action="{{ route('transfer.proses') }}" method="POST" class="space-y-6">
                    <!-- 
                        BAGIAN BACKEND: CSRF TOKEN
                    -->
                    @csrf
                    <div class="space-y-3 mb-4">
                        {{-- 1. ALERT UNTUK LOGIKA ERROR / PROSES GAGAL --}}
                        @if (session('error'))
                            <div class="flex items-center gap-3 p-4 text-[13px] text-red-800 border border-red-200 rounded-xl bg-red-50" role="alert">
                                <i class="ph-bold ph-warning-circle text-xl flex-shrink-0"></i>
                                <div class="font-medium">
                                    {{ session('error') }}
                                </div>
                            </div>
                        @endif

                        {{-- 2. ALERT UNTUK VALIDASI FORM YANG SALAH --}}
                        @if ($errors->any())
                            <div class="flex gap-3 p-4 text-[13px] text-red-800 border border-red-200 rounded-xl bg-red-50" role="alert">
                                <i class="ph-bold ph-warning-circle text-xl flex-shrink-0 mt-0.5"></i>
                                <div>
                                    <span class="font-bold block mb-1">Periksa kembali inputan Anda:</span>
                                    <ul class="list-disc list-inside space-y-0.5 pl-1 opacity-90">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        {{-- BONUS: ALERT UNTUK NOTIFIKASI SUKSES (Biar serasi) --}}
                        @if (session('success'))
                            <div class="flex items-center gap-3 p-4 text-[13px] text-green-800 border border-green-200 rounded-xl bg-green-50" role="alert">
                                <i class="ph-bold ph-check-circle text-xl flex-shrink-0"></i>
                                <div class="font-medium">
                                    {{ session('success') }}
                                </div>
                            </div>
                        @endif
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-textGray mb-2">No Rekening Penerima</label>
                        <!-- 
                            BAGIAN BACKEND: INPUT PENERIMA
                            - Ditangkap sebagai $request->id_penerima di controller.
                        -->
                        <input type="text" name="id_penerima" id="id_penerima" value="{{ old('id_penerima') }}" required class="w-full border border-formBorder rounded-xl p-3 text-textDark outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors" placeholder="">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-textGray mb-2">Nama Penerima</label>
                        <!-- 
                            BAGIAN BACKEND: INPUT PENERIMA
                            - Ditangkap sebagai $request->nama_penerima di controller.
                        -->
                        <input type="text" name="nama_penerima" id="nama_penerima" value="{{ old('nama_penerima') }}" readonly required class="w-full border border-formBorder rounded-xl p-3 text-textDark outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors" placeholder="">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-textGray mb-2">Nominal Transfer (Rp)</label>
                        <!-- 
                            BAGIAN BACKEND: INPUT NOMINAL
                            - Ditangkap sebagai $request->nominal di controller.
                        -->
                        <input type="text" name="jumlah_transfer" id="jumlah_transfer" value="{{ old('jumlah_transfer') }}" required min="1000" class="w-full border border-formBorder rounded-xl p-3 text-textDark outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors" placeholder="">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-textGray mb-2">Nominal Admin (Rp)</label>
                        <input type="text" name="nominal_admin" id="nominal_admin" value="Rp {{ number_format($biaya_admin->nominal, 0, ',', '.') }}"  readonly required min="1000" class="w-full border border-formBorder rounded-xl p-3 text-textDark outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors" placeholder="">
                        <input type="hidden" name="transaksi_id" value="{{ $biaya_admin->id }}">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-textGray mb-2">Catatan (Opsional)</label>
                        <!-- 
                            BAGIAN BACKEND: INPUT CATATAN
                            - Ditangkap sebagai $request->catatan di controller.
                        -->
                        <textarea rows="4" name="catatan" id="catatan" class="w-full border border-formBorder rounded-xl p-3 text-textDark outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors resize-none" placeholder="">{{ old('catatan') }}</textarea>
                    </div>
                    <button type="submit" id="btnSubmit" class="w-full bg-success-gradient hover:bg-green-700 text-white font-bold text-sm py-4 rounded-xl transition-colors mt-2 shadow-sm">Kirim</button>
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
                    @if($riwayatTransfer->isEmpty())
                        <div class="text-center py-6 text-gray-500 text-[13px]">
                            <p>Belum ada riwayat transaksi.</p>
                        </div>
                    @endif
                        @foreach( $riwayatTransfer as $item)
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                <i class="ph-fill ph-user-circle text-[32px] lg:text-[44px] text-[#1c3a5a]"></i>
                                <div>
                                     <p class="font-bold text-[13px] lg:text-[14px] text-gray-800">
                                        @if ($item->id_pengirim == auth()->user()->nasabah->rekening->id)
                                            {{ $item->nama_penerima }}
                                        @else
                                            {{ $item->pengirim->nasabah->user->name }}
                                            @endif
                                    </p>
                                    <p class="text-[9px] lg:text-[10px] text-gray-500 mt-0.5">{{ $item->created_at }}</p>
                                </div>
                            </div>
                            @if ($item->id_pengirim == auth()->user()->nasabah->rekening->id)
                                <p class="font-bold text-[12px] lg:text-[13px] text-red-500">
                                    - Rp. {{ number_format($item->jumlah_transfer, 0, ',', '.') }}
                                </p>
                            @else
                                <p class="font-bold text-[12px] lg:text-[13px] text-green-500">
                                    + Rp. {{ number_format($item->jumlah_transfer, 0, ',', '.') }}
                                </p>
                            @endif
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

                    @if($riwayatTransfer->isEmpty())
                        <div class="text-center py-6 text-gray-500 text-[13px]">
                            <p>Belum ada riwayat transaksi.</p>
                        </div>
                    @endif
                        @foreach( $riwayatTransfer as $item)
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                <i class="ph-fill ph-user-circle text-[32px] lg:text-[44px] text-[#1c3a5a]"></i>
                                <div>
                                        <p class="font-bold text-[13px] lg:text-[14px] text-gray-800">
                                        @if ($item->id_pengirim == auth()->user()->nasabah->rekening->id)
                                            {{ $item->nama_penerima }}
                                        @else
                                            {{ $item->pengirim->nasabah->user->name }}
                                            @endif
                                    </p>
                                    <p class="text-[9px] lg:text-[10px] text-gray-500 mt-0.5">{{ $item->created_at }}</p>
                                    <p class="text-[9px] lg:text-[10px] text-gray-500 mt-0.5">Catatan: {{$item->catatan}}</p>
                                </div>
                            </div>
                            @if ($item->id_pengirim == auth()->user()->nasabah->rekening->id)
                                <p class="font-bold text-[12px] lg:text-[13px] text-red-500">
                                    - Rp. {{ number_format($item->jumlah_transfer, 0, ',', '.') }}
                                </p>
                            @else
                                <p class="font-bold text-[12px] lg:text-[13px] text-green-500">
                                    + Rp. {{ number_format($item->jumlah_transfer, 0, ',', '.') }}
                                </p>
                            @endif
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

            const inputTransfer = document.getElementById('jumlah_transfer');

        // Fungsi untuk memformat angka menjadi format ribuan dengan titik
        function formatRupiah(angka) {
            // Hapus semua karakter selain angka
            let numberString = angka.replace(/[^,\d]/g, '').toString();
            let split = numberString.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            return split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
        }

        // Event saat pengguna mengetik
        inputTransfer.addEventListener('keyup', function(e) {
            this.value = formatRupiah(this.value);
        });

        // Jalankan fungsi saat halaman pertama kali dimuat (jika ada nilai old dari backend)
        window.addEventListener('DOMContentLoaded', function() {
            if (inputTransfer.value) {
                inputTransfer.value = formatRupiah(inputTransfer.value);
            }
        });

       // Buat variabel timer di luar agar bisa di-reset setiap kali mengetik
    let delayTimer;

    const rekeningLogin = "{{ auth()->user()->nasabah->rekening->id ?? '' }}";
    const btnSubmit = document.getElementById('btnSubmit');

    document.getElementById('id_penerima').addEventListener('input', function() {
        let noRekening = this.value;
        let inputNoRekening = this;
        let inputNama = document.getElementById('nama_penerima');

        // 1. KELOLA INPUT KOSONG
        if (noRekening.trim() === '') {
            clearTimeout(delayTimer); // batalkan pencarian jika dihapus semua
            inputNama.value = '';
            inputNoRekening.style.borderColor = '#e5e7eb';
            inputNama.style.borderColor = '#e5e7eb';
            return;
        }

            // 2. VALIDASI: JIKA REKENING PENERIMA SAMAN DENGAN REKENING LOGIN
        if (noRekening === rekeningLogin) {
            clearTimeout(delayTimer); // Hentikan timer pencarian API
            inputNama.value = 'Tidak bisa transfer ke rekening sendiri!';
            inputNoRekening.style.borderColor = '#ef4444'; // Border merah halus
            inputNama.style.borderColor = '#ef4444';
            btnSubmit.disabled = true;
            return; // Hentikan eksekusi, jangan jalankan fetch API
        }

        // Tampilkan status "Mencari..." agar user tahu sistem sedang bekerja
        inputNama.value = 'Mencari data...';

        // 2. TEKNIK DEBOUNCE: Hapus timer yang lama jika user masih mengetik
        clearTimeout(delayTimer);

        // Set timer baru: Tunggu 500ms (0.5 detik) setelah ketikan terakhir berhenti
        delayTimer = setTimeout(function() {
            
            // Panggil Route API Laravel setelah user BERHENTI mengetik
            fetch(window.location.origin + '/cek-rekening/' + noRekening)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // REKENING ADA
                        inputNama.value = data.nama;
                        inputNoRekening.style.borderColor = '#10b981'; // Hijau halus
                        inputNama.style.borderColor = '#10b981';
                        btnSubmit.disabled = false;
                    } else {
                        // REKENING TIDAK ADA
                        inputNama.value = 'Rekening Tidak Ditemukan!';
                        inputNoRekening.style.borderColor = '#ef4444'; // Merah halus
                        inputNama.style.borderColor = '#ef4444';
                        btnSubmit.disabled = true;
                    }
                })
                .catch(error => {
                    console.error('Error fetch:', error);
                    inputNama.value = 'Gagal memuat data internet';
                });

        }, 500); // <-- 500 milidetik (0.5 detik). Silakan dipercepat ke 300 jika dirasa kurang kilat
    });
</script>
@endsection
