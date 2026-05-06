<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfer - Bank Mini</title>
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        background: '#f8f9fc', // Warna background
                        primary: '#15395b', // Biru gelap
                        cardLight: '#eef2f6', // Abu-abu kebiruan untuk card kanan
                        textDark: '#1f2937',
                        textGray: '#8892a0',
                        formBorder: '#e5e7eb',
                        btnGreen: '#1aa061', // Hijau tombol kirim
                        accentYellow: '#c88d22', // Garis kuning di form
                    },
                    backgroundImage: {
                        'primary-gradient': 'linear-gradient(to right, #143657, #1E5081, #143657)',
                    }
                }
            }
        }
    </script>
    <style>
        /* Custom scrollbar untuk area utama */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1; 
        }
        ::-webkit-scrollbar-thumb {
            background: #d1d5db; 
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #9ca3af; 
        }
        
        /* Menghilangkan panah atas/bawah pada input number */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>
<body class="bg-background text-textDark flex h-screen overflow-hidden relative">

    <!-- OVERLAY (Mobile) -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden" onclick="toggleSidebar()"></div>

    <!-- SIDEBAR -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 w-64 bg-white border-r border-gray-100 flex flex-col z-50 shadow-[4px_0_24px_rgba(0,0,0,0.02)] transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out lg:relative lg:z-10">
        <!-- Close Button (Mobile) -->
        <button class="lg:hidden absolute top-4 right-4 text-gray-400 hover:text-textDark" onclick="toggleSidebar()">
            <i class="ph ph-x text-2xl"></i>
        </button>

        <!-- Logo Area -->
        <div class="px-8 pt-8 pb-10 flex items-center gap-3">
            <img src="{{ asset('img/nasabahicon/bank 2.png') }}" alt="Bank Logo" class="w-10 h-10 object-contain">
            <div>
                <h1 class="font-bold text-lg leading-tight tracking-tight text-textDark">BANK MINI</h1>
                <p class="text-[10px] text-textGray">SMKN 1 Kawali</p>
            </div>
        </div>

        <!-- Menu -->
        <div class="px-8 flex-1">
            <p class="text-xs font-semibold text-gray-400 mb-4 tracking-wider">MENU</p>
            <ul class="space-y-2 relative">
                
                <!-- Indikator Aktif dipindah ke menu Transfer -->
                <div class="absolute -left-8 top-[3.25rem] w-2 h-10 bg-primary rounded-r-lg transition-all duration-300"></div>

                <!-- Inactive Item (Dashboard) -->
                <li>
                    <a href="{{ route('nasabah.dashboard') }}" class="flex items-center gap-3 text-[#a0aab8] font-medium py-3 hover:text-primary transition-colors">
                        <img src="{{ asset('img/nasabahicon/speedometer2 1.png') }}" alt="Dashboard" class="w-5 h-5 opacity-40">
                        Dashboard
                    </a>
                </li>
                <!-- Active Item (Transfer) -->
                <li>
                    <a href="{{ route('nasabah.transfer') }}" class="flex items-center gap-3 text-textDark font-semibold py-3 hover:text-primary transition-colors">
                        <img src="{{ asset('img/nasabahicon/arrow-left-right 1.png') }}" alt="Transfer" class="w-5 h-5">
                        Transfer
                    </a>
                </li>
                <!-- Logout -->
                <li class="mt-4">
                    <a href="{{ route('login') }}" class="flex items-center gap-3 text-red-500 font-medium py-3 hover:text-red-600 transition-colors">
                        <img src="{{ asset('img/nasabahicon/box-arrow-left 1.png') }}" alt="Logout" class="w-5 h-5">
                        Keluar
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 flex flex-col h-screen overflow-y-auto w-full">
        
        <!-- MOBILE TOP BAR -->
        <div class="lg:hidden flex items-center justify-between px-6 py-4 bg-white border-b border-gray-100 sticky top-0 z-30">
            <div class="flex items-center gap-2">
                <i class="ph ph-bank text-2xl text-primary"></i>
                <span class="font-bold text-sm tracking-tight text-textDark">BANK MINI</span>
            </div>
            <button class="p-2 bg-gray-50 rounded-lg text-primary" onclick="toggleSidebar()">
                <i class="ph ph-list text-2xl"></i>
            </button>
        </div>

        <!-- HEADER (Desktop) -->
        <header class="px-10 py-8 flex justify-between items-center bg-background/80 backdrop-blur-sm sticky top-0 z-20 hidden lg:flex">
            <div>
                <h2 class="text-2xl font-bold text-textDark">Transfer Rekening</h2>
                <p class="text-textGray text-sm mt-1">Lorem Ipsum is simply dummy text of the printing</p>
            </div>
            
            <div class="flex items-center gap-6">
                <!-- Status Tag -->
                <div class="flex items-center gap-2 bg-[#d1f4e0] text-[#0d7d42] px-4 py-2 rounded-full text-sm font-semibold">
                    <img src="{{ asset('img/nasabahicon/check2-circle 2.png') }}" alt="Status" class="w-4 h-4">
                    Rekening Aktif
                </div>
                
                <!-- User Profile -->
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 overflow-hidden border border-gray-100">
                        <img src="{{ asset('img/nasabahicon/person-circle 1.png') }}" alt="User" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <p class="text-sm font-bold text-textDark leading-tight">Nasabah Demo</p>
                        <p class="text-xs text-[#a0aab8]">nasabah@email.com</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- MOBILE HEADER INFO -->
        <div class="lg:hidden px-6 pt-4 pb-2">
            <h2 class="text-xl font-bold text-textDark">Transfer Rekening</h2>
            <p class="text-textGray text-[10px]">Lorem Ipsum is simply dummy text of the printing</p>
        </div>

        <!-- CONTENT AREA -->
        <div class="px-6 lg:px-10 pb-10">
            
            <!-- MAIN VIEW (Form & Recent History) -->
            <div id="transferMainView">
                <!-- TOP SECTION: Saldo Cards -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                <!-- Card Kiri: Saldo Diterima -->
                <div class="bg-primary-gradient rounded-2xl p-6 lg:p-7 relative overflow-hidden shadow-lg text-white">
                    <!-- Background Watermark (Premium Wallet - Moved Left) -->
                    <div class="absolute right-6 top-1/2 -translate-y-1/2 w-32 h-32 opacity-[0.06] text-white">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" class="w-full h-full">
                            <path d="M21 12V7H5a2 2 0 010-4h14v4"></path>
                            <path d="M3 5v14a2 2 0 002 2h16v-5"></path>
                            <path d="M18 12a2 2 0 000 4h4v-4h-4z"></path>
                        </svg>
                    </div>

                    <div class="relative z-10">
                        <div class="flex items-center gap-2 mb-3">
                            <p class="text-[10px] lg:text-xs font-semibold tracking-widest text-gray-300 uppercase">TOTAL SALDO DITERIMA</p>
                        </div>
                        <h3 class="text-3xl lg:text-4xl font-bold mb-4 lg:mb-6 tracking-tight">Rp. 10.500.000</h3>
                        <div class="flex items-center gap-2 text-xs lg:text-sm text-gray-300">
                            <img src="{{ asset('img/nasabahicon/speedometer2 1.png') }}" alt="Time" class="w-4 h-4 brightness-0 invert opacity-60">
                            <p>Akumulasi Transaksi Bulan Ini</p>
                        </div>
                    </div>
                </div>

                <!-- Card Kanan: Saldo Terkirim -->
                <div class="bg-cardLight rounded-2xl p-6 lg:p-7 relative overflow-hidden shadow-sm border border-white">
                    <!-- Background Watermark (Premium Wallet - Moved Left) -->
                    <div class="absolute right-6 top-1/2 -translate-y-1/2 w-32 h-32 opacity-[0.04] text-primary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" class="w-full h-full">
                            <path d="M21 12V7H5a2 2 0 010-4h14v4"></path>
                            <path d="M3 5v14a2 2 0 002 2h16v-5"></path>
                            <path d="M18 12a2 2 0 000 4h4v-4h-4z"></path>
                        </svg>
                    </div>

                    <div class="relative z-10">
                        <div class="flex items-center gap-2 mb-3">
                            <p class="text-[10px] lg:text-xs font-semibold tracking-widest text-textGray uppercase">TOTAL SALDO TERKIRIM</p>
                        </div>
                        <h3 class="text-3xl lg:text-4xl font-bold mb-4 lg:mb-6 tracking-tight text-primary">Rp. 500.000</h3>
                        <div class="flex items-center gap-2 text-xs lg:text-sm text-textGray">
                            <img src="{{ asset('img/nasabahicon/speedometer2 1.png') }}" alt="Time" class="w-4 h-4 opacity-40">
                            <p>Akumulasi Transaksi Bulan Ini</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- BOTTOM SECTION: Form & Riwayat -->
            <div class="mt-8 flex flex-col lg:flex-row gap-10">
                
                <!-- FORMULIR TRANSFER (Kiri) -->
                <div class="lg:w-7/12 bg-white rounded-3xl p-6 lg:p-8 shadow-[0_4px_24px_rgba(0,0,0,0.02)] border border-gray-50 h-fit">
                    
                    <!-- Judul Form -->
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-1.5 h-7 bg-accentYellow rounded-full"></div>
                        <h3 class="text-xl lg:text-2xl font-bold text-textDark">Formulir Transfer</h3>
                    </div>

                    <form action="#" method="GET" class="space-y-6">
                        @if($errors->any())
                            <div class="bg-red-50 text-red-500 p-4 rounded-xl text-sm border border-red-100">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="bg-green-50 text-green-600 p-4 rounded-xl text-sm border border-green-100">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Input Nomor Rekening / Nama Penerima -->
                        <div>
                            <label class="block text-sm font-semibold text-textGray mb-2">Nomor Rekening Penerima</label>
                            <input type="text" 
                                   name="no_rekening"
                                   id="no_rekening"
                                   required
                                   class="w-full border border-formBorder rounded-xl p-3 text-textDark outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors" 
                                   placeholder="Masukkan nomor rekening">
                        </div>

                        <!-- Input Nominal -->
                        <div>
                            <label class="block text-sm font-semibold text-textGray mb-2">Nominal Transfer (Rp)</label>
                            <input type="number" 
                                   name="nominal"
                                   id="nominal"
                                   required
                                   min="1000"
                                   class="w-full border border-formBorder rounded-xl p-3 text-textDark outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors" 
                                   placeholder="0">
                        </div>

                        <!-- Input Catatan -->
                        <div>
                            <label class="block text-sm font-semibold text-textGray mb-2">Catatan (Opsional)</label>
                            <textarea rows="4" 
                                      name="catatan"
                                      id="catatan"
                                      class="w-full border border-formBorder rounded-xl p-3 text-textDark outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors resize-none" 
                                      placeholder="Pesan tambahan..."></textarea>
                        </div>

                        <!-- Tombol Kirim -->
                        <button type="submit" class="w-full bg-btnGreen hover:bg-green-700 text-white font-bold text-lg py-3 lg:py-4 rounded-xl transition-colors mt-2 shadow-sm">
                            Kirim Sekarang
                        </button>
                    </form>
                </div>

                <!-- RIWAYAT TERBARU (Kanan) -->
                <div class="lg:w-5/12">
                    <div class="flex justify-between items-end mb-6 px-2">
                        <h3 class="text-xl font-bold text-textDark">Riwayat Terbaru</h3>
                        <a href="javascript:void(0)" onclick="showHistory()" class="text-sm font-semibold text-textDark hover:underline">Lihat Semua</a>
                    </div>

                    <div class="space-y-5 px-2">
                        <!-- Contoh Riwayat 1 -->
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-4">
                                <div class="w-10 lg:w-12 h-10 lg:h-12 rounded-full bg-primary flex items-center justify-center">
                                    <img src="{{ asset('img/nasabahicon/person-circle 1.png') }}" alt="User" class="w-6 h-6 brightness-0 invert">
                                </div>
                                <div>
                                    <p class="font-bold text-sm lg:text-base text-textDark">Pajar Azmi</p>
                                    <p class="text-[10px] text-textGray mt-0.5">25 Desember 2026</p>
                                </div>
                            </div>
                            <p class="font-bold text-sm lg:text-base text-[#1fae62]">+ Rp. 50.000</p>
                        </div>
                        <!-- Contoh Riwayat 2 -->
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-4">
                                <div class="w-10 lg:w-12 h-10 lg:h-12 rounded-full bg-primary flex items-center justify-center text-white">
                                    <i class="ph-fill ph-user text-xl lg:text-2xl"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-sm lg:text-base text-textDark">Anisa Siti</p>
                                    <p class="text-[10px] text-textGray mt-0.5">10 Desember 2026</p>
                                </div>
                            </div>
                            <p class="font-bold text-sm lg:text-base text-[#e22f2f]">- Rp. 100.000</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- HISTORY VIEW (Full List) -->
            <div id="transferHistoryView" class="hidden">
                <div class="bg-white rounded-3xl p-6 lg:p-10 shadow-[0_4px_24px_rgba(0,0,0,0.02)] border border-gray-50">
                    <div class="flex justify-between items-center mb-10">
                        <a href="javascript:void(0)" onclick="showMain()" class="flex items-center gap-2 text-textDark font-bold hover:text-primary transition-colors">
                            <span class="text-base">Kembali</span>
                        </a>
                        <h3 class="text-2xl font-bold text-textDark">Riwayat Transaksi</h3>
                    </div>

                    <div class="space-y-8">
                        <!-- List Riwayat Statis -->
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-5">
                                <div class="w-12 h-12 lg:w-14 lg:h-14 rounded-full bg-primary flex items-center justify-center text-white">
                                    <i class="ph-fill ph-user text-2xl lg:text-3xl"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-lg lg:text-xl text-textDark">Pajar Azmi</p>
                                    <p class="text-xs lg:text-sm text-textGray mt-0.5">25 Desember 2026, 14:30</p>
                                </div>
                            </div>
                            <p class="font-bold text-lg lg:text-xl text-[#1fae62]">+ Rp. 50.000</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        }

        function showHistory() {
            document.getElementById('transferMainView').classList.add('hidden');
            document.getElementById('transferHistoryView').classList.remove('hidden');
        }

        function showMain() {
            document.getElementById('transferHistoryView').classList.add('hidden');
            document.getElementById('transferMainView').classList.remove('hidden');
        }

        document.addEventListener('DOMContentLoaded', () => {
            console.log("Halaman Transfer siap dimuat.");
            
            // Cek jika ada parameter view=history di URL
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('view') === 'history') {
                showHistory();
            }
        });
    </script>
</body>
</html>