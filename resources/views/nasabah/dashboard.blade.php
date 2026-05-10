<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Bank Mini</title>

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
                        background: '#f8f9fc', // Warna background abu-abu sangat muda
                        primary: '#15395b', // Biru gelap untuk card saldo
                        primaryLight: '#436585', // Biru lebih terang untuk kotak dalam card
                        warningBg: '#fcefc7', // Kuning untuk tips keamanan
                        textDark: '#1f2937',
                        textGray: '#6b7280',
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
                <h1 class="font-bold text-lg leading-tight tracking-tight">BANK MINI</h1>
                <p class="text-[10px] text-textGray">SMKN 1 Kawali</p>
            </div>
        </div>

        <!-- Menu -->
        <div class="px-8 flex-1">
            <p class="text-xs font-semibold text-gray-400 mb-4 tracking-wider">MENU</p>
            <ul class="space-y-2 relative">
                <!-- Indikator Aktif (Garis Biru di kiri) -->
                <div class="absolute -left-8 top-1 w-2 h-10 bg-primary rounded-r-lg"></div>

                <!-- Active Item -->
                <li>
                    <a href="{{ route('nasabah.dashboard') }}" class="flex items-center gap-3 text-textDark font-semibold py-3 hover:text-primary transition-colors">
                        <img src="{{ asset('img/nasabahicon/speedometer2 1.png') }}" alt="Dashboard" class="w-5 h-5">
                        Dashboard
                    </a>
                </li>
                <!-- Inactive Item -->
                <li>
                    <a href="{{ route('nasabah.transfer') }}" class="flex items-center gap-3 text-textGray font-medium py-3 hover:text-primary transition-colors">
                        <img src="{{ asset('img/nasabahicon/arrow-left-right 1.png') }}" alt="Transfer" class="w-5 h-5 opacity-50">
                        Transfer
                    </a>
                </li>
                <!-- Logout -->
                <li class="mt-4">
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                            <button
                            type="submit"
                            class="bg-red-500 text-white px-4 py-2 rounded">
                            Logout
                        </button>
                    </form>
                    {{-- <a href="{{ route('login') }}" class="flex items-center gap-3 text-red-500 font-medium py-3 hover:text-red-600 transition-colors">
                        <img src="{{ asset('img/nasabahicon/box-arrow-left 1.png') }}" alt="Logout" class="w-5 h-5">
                        Keluar
                    </a> --}}
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
                <span class="font-bold text-sm tracking-tight">BANK MINI</span>
            </div>
            <button class="p-2 bg-gray-50 rounded-lg text-primary" onclick="toggleSidebar()">
                <i class="ph ph-list text-2xl"></i>
            </button>
        </div>

        <!-- HEADER -->
        <header class="px-6 lg:px-10 py-6 lg:py-8 flex flex-col md:flex-row justify-between items-start md:items-center bg-background/80 backdrop-blur-sm sticky top-0 z-20 hidden lg:flex">
            <div>
                <h2 class="text-2xl font-bold text-textDark">Selamat Datang, {{ $nasabah->nama_nasabah }}!</h2>
                <p class="text-textGray text-sm mt-1">Kelola keuangan Anda dengan aman dan mudah di Bank Mini.</p>
            </div>

            <div class="flex items-center gap-6">
                <!-- Status Tag -->
                <div class="flex items-center gap-2 bg-[#d1f4e0] text-[#0d7d42] px-4 py-2 rounded-full text-sm font-semibold">
                    <img src="{{ asset('img/nasabahicon/check2-circle 2.png') }}" alt="Status" class="w-4 h-4">
                    Rekening Aktif
                </div>

                <!-- User Profile -->
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gray-50 rounded-full flex items-center justify-center overflow-hidden border border-gray-100">
                        <img src="{{ asset('img/nasabahicon/person-circle 1.png') }}" alt="User" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <p class="text-sm font-bold text-textDark leading-tight">{{ $nasabah->nama_nasabah }}</p>
                        <p class="text-xs text-textGray">{{ $user->email }}</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- MOBILE HEADER INFO (Visible on Mobile) -->
        <div class="lg:hidden px-6 pt-4 pb-2">
            <h2 class="text-xl font-bold text-textDark">Halo, {{ $nasabah->nama_nasabah }}!</h2>
            <p class="text-textGray text-[10px]">Pantau saldo dan transaksi Anda hari ini.</p>
        </div>

        <!-- CONTENT AREA -->
        <div class="px-6 lg:px-10 pb-10">

            <!-- TOP SECTION: Balance & Warning -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Saldo Card -->
                <div class="lg:col-span-2 bg-primary-gradient rounded-2xl p-6 lg:p-8 relative overflow-hidden shadow-lg text-white">
                    <!-- Background Watermark Icon (Premium Wallet - Moved Left) -->
                    <div class="absolute right-8 top-1/2 -translate-y-1/2 w-44 h-44 opacity-[0.08] text-white">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" class="w-full h-full">
                            <path d="M21 12V7H5a2 2 0 010-4h14v4"></path>
                            <path d="M3 5v14a2 2 0 002 2h16v-5"></path>
                            <path d="M18 12a2 2 0 000 4h4v-4h-4z"></path>
                        </svg>
                    </div>

                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-2">
                            <p class="text-xs font-medium tracking-widest text-gray-200 uppercase">Total Saldo Terkumpul</p>
                        </div>
                        <h3 class="text-3xl lg:text-5xl font-bold mb-8 lg:mb-10 tracking-tight">Rp. 10.500.000</h3>

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
                <div class="bg-warningBg rounded-2xl p-7 shadow-sm border border-orange-100 flex flex-col justify-center">
                    <div class="flex items-center gap-2 mb-3 text-amber-900">
                        <i class="ph-fill ph-warning text-xl"></i>
                        <h4 class="font-bold text-lg">Tips Keamanan</h4>
                    </div>
                    <p class="text-sm text-amber-900/80 leading-relaxed">
                        Jangan pernah memberikan PIN atau password kepada siapapun, termasuk pihak yang mengaku sebagai petugas Bank Mini.
                    </p>
                </div>
            </div>

            <!-- MIDDLE SECTION: Riwayat Transaksi -->
            <div class="mt-10">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold text-gray-800">Riwayat Transaksi Terbaru</h3>
                        <a href="{{ route('nasabah.transfer', ['view' => 'history']) }}" class="text-xs font-semibold text-gray-400 hover:text-active-blue transition-colors">Lihat Semua</a>
                    </div>

                <div class="bg-transparent space-y-4">
                    <!-- Item Statis 1 -->
                    <div class="flex justify-between items-center bg-white p-5 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.02)]">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-[#ccf0dd] flex items-center justify-center">
                                <img src="{{ asset('img/nasabahicon/box-arrow-in-down-left 1.png') }}" alt="Income" class="w-6 h-6">
                            </div>
                            <div>
                                <p class="font-bold text-lg text-textDark">Setor Tunai</p>
                                <p class="text-xs text-textGray mt-0.5">25 Oktober 2026</p>
                            </div>
                        </div>
                        <p class="font-bold text-lg text-[#1fae62]">+ Rp. 50.000</p>
                    </div>
                    <!-- Item Statis 2 -->
                    <div class="flex justify-between items-center bg-white p-5 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.02)]">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-[#fbd4d4] flex items-center justify-center">
                                <img src="{{ asset('img/nasabahicon/box-arrow-up-right 1.png') }}" alt="Expense" class="w-6 h-6">
                            </div>
                            <div>
                                <p class="font-bold text-lg text-textDark">Tarik Tunai</p>
                                <p class="text-xs text-textGray mt-0.5">20 Oktober 2026</p>
                            </div>
                        </div>
                        <p class="font-bold text-lg text-[#e22f2f]">- Rp. 20.000</p>
                    </div>
                </div>
            </div>

            <!-- BOTTOM SECTION: Banner Info -->
            <div class="mt-10 bg-white rounded-3xl overflow-hidden shadow-[0_4px_20px_rgba(0,0,0,0.03)] flex flex-col md:flex-row mb-10 border border-gray-100">
                <!-- Bagian Gambar Kiri -->
                <div class="md:w-[40%] bg-primary relative min-h-[250px]">
                    <img src="{{ asset('img/nasabahicon/banner_saving.png') }}"
                         alt="Ilustrasi Menabung"
                         class="absolute inset-0 w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-r from-primary/60 to-transparent"></div>
                </div>

                <!-- Bagian Teks Kanan -->
                <div class="md:w-[60%] p-10 flex flex-col justify-center">
                    <h3 class="text-2xl font-bold text-textDark mb-3">Mulai Menabung untuk Masa Depan.</h3>
                    <p class="text-textGray mb-6 leading-relaxed text-sm md:text-base">
                        Mulai dari langkah kecil untuk hasil yang besar di kemudian hari. Disiplin menabung untuk membentuk masa depan yang cerah.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-3 text-sm font-semibold text-textDark">
                            <img src="{{ asset('img/nasabahicon/check2-circle 2.png') }}" alt="Check" class="w-5 h-5">
                            Sistem Terenkripsi
                        </li>
                        <li class="flex items-center gap-3 text-sm font-semibold text-textDark">
                            <img src="{{ asset('img/nasabahicon/check2-circle 2.png') }}" alt="Check" class="w-5 h-5">
                            Aman & Terpercaya
                        </li>
                    </ul>
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

        document.addEventListener('DOMContentLoaded', () => {
            console.log("Dashboard siap dimuat.");
        });
    </script>
</body>
</html>
