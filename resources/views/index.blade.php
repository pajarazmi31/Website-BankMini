<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Mini SMKN 1 Kawali</title>

    <!-- Font Google: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Ikon Phosphor -->
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
                    backgroundImage: {
                        'gradient-merek': 'linear-gradient(to right, #143657, #1E5081, #143657)',
                    },
                    colors: {
                        merek: {
                            biru: '#1E3A5F',      // Latar belakang biru gelap utama
                            gelap: '#162D4A',      // Biru lebih gelap untuk beberapa kartu
                            terang: '#284B75',     // Biru lebih terang untuk skeleton
                            kuning: '#D9A036',    // Kuning aksen
                            hijau: '#1A8F6A',     // Hijau aksen
                            bg: '#F4F6F9'         // Latar belakang abu-abu terang utama
                        }
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="shortcut icon" href="{{ asset('img/landingpageicon/fav-icon 1.png') }}" type="image/x-icon">
</head>
<body class="font-sans text-gray-800 bg-merek-bg antialiased selection:bg-merek-kuning selection:text-white">

    <!-- Bilah Navigasi -->
    <!-- Ditambahkan id="navbar" dan class transition untuk efek animasi -->
    <nav id="navbar" class="bg-white border-b border-gray-100 sticky top-0 z-50 transition-all duration-300 ease-in-out">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center transition-all duration-300" id="navbar-container">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="#beranda" class="font-bold text-xl tracking-tight text-gray-900">
                        BANK MINI SMKN 1 KAWALI
                    </a>
                </div>

                <!-- Menu Desktop -->
                <div class="hidden md:flex space-x-8 items-center">
                    <a href="#beranda" class="desktop-nav-link text-sm font-semibold text-gray-900 border-b-2 border-merek-kuning pb-1 transition-all duration-200">Beranda</a>
                    <a href="#tentang" class="desktop-nav-link text-sm font-medium text-gray-500 hover:text-gray-900 border-b-2 border-transparent hover:border-gray-200 pb-1 transition-all duration-200">Tentang</a>
                    <a href="#alur-layanan" class="desktop-nav-link text-sm font-medium text-gray-500 hover:text-gray-900 border-b-2 border-transparent hover:border-gray-200 pb-1 transition-all duration-200">Alur Layanan</a>
                    <a href="#form-transfer" class="desktop-nav-link text-sm font-medium text-gray-500 hover:text-gray-900 border-b-2 border-transparent hover:border-gray-200 pb-1 transition-all duration-200">Form Transfer</a>
                </div>

                <!-- Tombol Autentikasi -->
                <div class="hidden md:flex items-center space-x-4">
                    <a href="{{ route('halaman.login') }}" class="text-sm font-medium text-white bg-merek-biru px-6 py-2 rounded-full hover:bg-opacity-90 hover:shadow-md transition">Masuk</a>
                </div>

                <!-- Tombol menu seluler -->
                <div class="flex items-center md:hidden">
                    <button type="button" onclick="toggleMobileMenu()" class="text-gray-400 hover:text-white focus:outline-none p-2 transition-transform duration-200 active:scale-95">
                        <i class="ph ph-list text-2xl transition-all" id="menu-icon"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Panel Menu Seluler -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-b border-gray-100 shadow-lg absolute w-full transition-all origin-top">
            <div class="px-4 pt-2 pb-6 space-y-2">
                <a href="#beranda" onclick="toggleMobileMenu()" class="mobile-nav-link block px-3 py-2 text-base font-medium text-merek-kuning bg-gray-50 rounded-md transition-colors">Beranda</a>
                <a href="#tentang" onclick="toggleMobileMenu()" class="mobile-nav-link block px-3 py-2 text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-md transition-colors">Tentang</a>
                <a href="#alur-layanan" onclick="toggleMobileMenu()" class="mobile-nav-link block px-3 py-2 text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-md transition-colors">Alur Layanan</a>
                <a href="#form-transfer" onclick="toggleMobileMenu()" class="mobile-nav-link block px-3 py-2 text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-md transition-colors">Form Transfer</a>
                <div class="mt-4 flex flex-col gap-2 px-3">
                    <a href="{{ route('halaman.login') }}" class="text-center text-base font-medium text-white bg-merek-biru py-2 rounded-lg hover:bg-opacity-90 transition-colors">Masuk</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Bagian Utama (Hero) -->
    <header id="beranda" class="bg-gradient-merek pt-16 pb-32 lg:pt-24 lg:pb-48 relative scroll-mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Konten Teks -->
                <div class="text-white z-10">
                    <h1 class="text-[28px] sm:text-4xl md:text-5xl lg:text-[40px] xl:text-5xl font-bold leading-tight mb-6">
                        <span class="whitespace-nowrap">Tabungan <span class="text-merek-kuning">Masa Depan</span></span><br>
                        Dimulai dari Sini.
                    </h1>
                    <p class="text-base md:text-lg text-gray-300 mb-8 max-w-lg leading-relaxed">
                        Membangun kebiasaan finansial yang cerdas melalui pengalaman perbankan nyata di lingkungan sekolah yang aman dan edukatif.
                    </p>
                    <a href="#form-transfer" class="inline-block bg-merek-kuning text-merek-biru font-semibold px-8 py-3 rounded-md hover:bg-opacity-90 transition shadow-lg hover:shadow-xl hover:-translate-y-1 transform duration-200">
                        Buka Tabungan
                    </a>
                </div>

                <!-- Gambar Utama -->
                <div class="relative z-10 rounded-2xl overflow-hidden shadow-2xl max-w-lg mx-auto lg:ml-auto -mt-4 lg:mt-0">
                    <img src="{{ asset('img/kone.png') }}" alt="Smkn 1 Kawali" class="w-full h-full object-cover sm:h-[300px] lg:h-[400px]">
                    <!-- Lapisan bayangan untuk meniru efek desain -->
                    <div class="absolute inset-0 bg-gradient-to-tr from-[#143657]/60 to-transparent"></div>
                </div>
            </div>
        </div>
    </header>

    <!-- Bagian Tentang / Fitur (Tumpang Tindih) -->
    <section id="tentang" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative -mt-12 lg:-mt-40 z-20 mb-20 scroll-mt-24">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden p-8 md:p-12">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-merek-biru">Apa Itu Bank Mini Sekolah?</h2>
            </div>

            <div class="grid md:grid-cols-12 gap-12 items-center">
                <!-- Konten Kiri -->
                <div class="md:col-span-7 flex flex-col justify-center">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 rounded-full bg-merek-hijau flex items-center justify-center shadow-md overflow-hidden">
                            <img src="{{ asset('img/landingpageicon/Bank Icon.png') }}" alt="Bank Icon" class="w-8 h-8 object-contain">
                        </div>
                        <h3 class="text-2xl font-bold text-merek-hijau">Fasilitas Belajar Praktis</h3>
                    </div>
                    <p class="text-gray-600 mb-8 leading-relaxed text-base">
                        Bank Mini Sekolah dirancang sebagai replika sistem perbankan profesional yang memberikan pengalaman nyata kepada siswa dalam memahami dunia perbankan. Melalui program ini, siswa tidak hanya belajar menabung, tetapi juga terlibat langsung dalam berbagai aktivitas operasional bank, seperti melayani nasabah sebagai teller, memberikan pelayanan sebagai customer service, hingga melakukan pencatatan keuangan di bidang akunting.
                    </p>
                    <div>
                        <span class="inline-block bg-merek-hijau text-white text-sm font-bold px-5 py-2 rounded-full shadow-sm">
                            100% Transaksi Aman
                        </span>
                    </div>
                </div>

                <!-- Konten Kanan (Kartu Gelap) -->
                <div class="md:col-span-5">
                    <div class="bg-gradient-merek rounded-[2rem] p-8 lg:p-10 text-white shadow-2xl border border-white/5 relative overflow-hidden group">
                        <!-- Dekorasi Gradient Halus -->
                        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-32 h-32 bg-white/5 rounded-full blur-3xl group-hover:bg-white/10 transition-colors duration-500"></div>

                        <div class="relative z-10">
                        <img src="{{ asset('img/landingpageicon/shield-shaded (1) 1.png') }}" alt="Shield Icon" class="w-10 h-10 object-contain">
                            <h3 class="text-2xl font-bold">Keamanan Terjamin</h3>
                        </div>
                        <p class="text-gray-300 text-base mb-8 leading-relaxed">
                            Setiap transaksi diawasi langsung oleh guru pembimbing dan sistem tercatat secara digital untuk transparansi penuh.
                        </p>

                        <!-- Garis Pemisah -->
                        <div class="border-t border-white/10 mb-8"></div>

                        <ul class="space-y-4">
                            <li class="flex items-center gap-4 text-sm font-medium text-gray-200">
                                <img src="{{ asset('img/landingpageicon/check2-circle 1.png') }}" alt="Check Icon" class="w-5 h-5 object-contain">
                                Audit Bulanan Berkala
                            </li>
                            <li class="flex items-center gap-4 text-sm font-medium text-gray-200">
                                <img src="{{ asset('img/landingpageicon/check2-circle 1.png') }}" alt="Check Icon" class="w-5 h-5 object-contain">
                                Sistem Terenkripsi
                            </li>
                        </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pembungkus Bagian Proses untuk Alur Layanan -->
    <div id="alur-layanan" class="scroll-mt-20">
        <!-- Bagian Proses -->
        <section class="py-24 bg-merek-bg">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mb-20 text-center md:text-left">
                    <h2 class="text-4xl font-bold text-merek-biru mb-4">Proses Buka Buku Tabungan</h2>
                    <p class="text-gray-600 text-lg">Proses pendaftaran yang mudah dan cepat.</p>
                </div>

                <!-- Langkah-langkah -->
                <div class="relative">
                    <!-- Garis Penghubung (Desktop) -->
                    <div class="hidden md:block absolute top-10 left-[12%] right-[12%] h-[2px] bg-gray-300 -translate-y-1/2 z-0"></div>

                    <div class="grid md:grid-cols-3 gap-12 text-center relative z-10">
                        <!-- Langkah 1 -->
                        <div class="flex flex-col items-center">
                            <div class="w-20 h-20 rounded-full bg-[#1e3a5f] text-white flex items-center justify-center text-3xl font-bold mb-8 ring-[10px] ring-merek-bg shadow-md hover:scale-110 transition-transform duration-300 cursor-default">
                                1
                            </div>
                            <h3 class="text-2xl font-bold text-merek-biru mb-3">Registrasi</h3>
                            <p class="text-gray-500 text-base max-w-xs leading-relaxed">Isi formulir pendaftaran digital di counter Bank Mini.</p>
                        </div>

                        <!-- Langkah 2 -->
                        <div class="flex flex-col items-center">
                            <div class="w-20 h-20 rounded-full bg-[#1A5B53] text-white flex items-center justify-center text-3xl font-bold mb-8 ring-[10px] ring-merek-bg shadow-md hover:scale-110 transition-transform duration-300 cursor-default">
                                2
                            </div>
                            <h3 class="text-2xl font-bold text-merek-biru mb-3">Verifikasi</h3>
                            <p class="text-gray-500 text-base max-w-xs leading-relaxed">Tunjukkan Kartu Identitas kepada petugas untuk validasi data.</p>
                        </div>

                        <!-- Langkah 3 -->
                        <div class="flex flex-col items-center">
                            <div class="w-20 h-20 rounded-full bg-[#34B38A] text-white flex items-center justify-center text-3xl font-bold mb-8 ring-[10px] ring-merek-bg shadow-md hover:scale-110 transition-transform duration-300 cursor-default">
                                3
                            </div>
                            <h3 class="text-2xl font-bold text-merek-biru mb-3">Terima Buku</h3>
                            <p class="text-gray-500 text-base max-w-xs leading-relaxed">Dapatkan buku tabungan dan mulailah menabung.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Bagian Alur Transaksi -->
        <section class="py-24 bg-merek-bg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mb-16 text-center md:text-left">
                    <h2 class="text-3xl font-bold text-merek-biru mb-4">Alur Transaksi Bank Mini</h2>
                    <p class="text-gray-600 max-w-2xl">Langkah-langkah proses transaksi di Bank Mini yang disusun secara jelas dan mudah dipahami.</p>
                </div>

                <div class="grid lg:grid-cols-2 gap-8 items-stretch">
                    <!-- Alur Nabung Card -->
                    <div class="bg-white rounded-[2rem] p-8 lg:p-12 shadow-xl hover:shadow-2xl transition-all duration-300 border border-gray-100">
                        <div class="flex items-center gap-4 mb-10">
                            <img src="{{ asset('img/landingpageicon/cash-stack 1 (1).png') }}" alt="Cash Icon" class="w-10 h-10 object-contain">
                            <h3 class="text-2xl font-bold text-[#1e3a5f]">Alur Nabung</h3>
                        </div>

                        <div class="relative space-y-12 ml-4">
                            <!-- Garis Vertikal -->
                            <div class="absolute top-5 left-5 w-[1.5px] h-[calc(100%-40px)] bg-gray-100 -translate-x-1/2 z-0"></div>

                            <!-- Langkah 1 -->
                            <div class="relative flex items-center gap-8 z-10">
                                <div class="w-10 h-10 rounded-full bg-[#1e3a5f] text-white flex items-center justify-center font-bold text-lg shadow-md shrink-0">1</div>
                                <p class="text-gray-600 font-medium text-lg leading-relaxed">Pilih menu setoran pada teller.</p>
                            </div>

                            <!-- Langkah 2 -->
                            <div class="relative flex items-center gap-8 z-10">
                                <div class="w-10 h-10 rounded-full bg-[#1A5B53] text-white flex items-center justify-center font-bold text-lg shadow-md shrink-0">2</div>
                                <p class="text-gray-600 font-medium text-lg leading-relaxed">Berikan uang tunai dan buku tabungan.</p>
                            </div>

                            <!-- Langkah 3 -->
                            <div class="relative flex items-center gap-8 z-10">
                                <div class="w-10 h-10 rounded-full bg-[#34B38A] text-white flex items-center justify-center font-bold text-lg shadow-md shrink-0">3</div>
                                <p class="text-gray-600 font-medium text-lg leading-relaxed">Dapatkan slip bukti setoran.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Alur Tarik Tunai Card -->
                    <div class="bg-gradient-merek rounded-[2rem] p-8 lg:p-12 shadow-xl hover:shadow-2xl transition-all duration-300 relative overflow-hidden group">
                        <!-- Dekorasi Halus -->
                        <div class="absolute bottom-0 right-0 -mr-16 -mb-16 w-48 h-48 bg-white/5 rounded-full blur-3xl group-hover:bg-white/10 transition-colors duration-500"></div>

                        <div class="relative z-10">
                            <div class="flex items-center gap-4 mb-10 text-white">
                                <img src="{{ asset('img/landingpageicon/cash-stack 1.png') }}" alt="Cash Icon" class="w-10 h-10 object-contain brightness-0 invert">
                                <h3 class="text-2xl font-bold">Alur Tarik Tunai</h3>
                            </div>

                            <div class="relative space-y-12 ml-4">
                                <!-- Garis Vertikal -->
                                <div class="absolute top-5 left-5 w-[1.5px] h-[calc(100%-40px)] bg-white/10 -translate-x-1/2 z-0"></div>

                                <!-- Langkah 1 -->
                                <div class="relative flex items-center gap-8 z-10">
                                    <div class="w-10 h-10 rounded-full bg-[#B87333] text-white flex items-center justify-center font-bold text-lg shadow-lg shrink-0 border border-white/10">1</div>
                                    <p class="text-gray-100 font-medium text-lg leading-relaxed">Beritahu nominal penarikan.</p>
                                </div>

                                <!-- Langkah 2 -->
                                <div class="relative flex items-center gap-8 z-10">
                                    <div class="w-10 h-10 rounded-full bg-[#D4A017] text-white flex items-center justify-center font-bold text-lg shadow-lg shrink-0 border border-white/10">2</div>
                                    <p class="text-gray-100 font-medium text-lg leading-relaxed">Tunjukkan buku tabungan.</p>
                                </div>

                                <!-- Langkah 3 -->
                                <div class="relative flex items-center gap-8 z-10">
                                    <div class="w-10 h-10 rounded-full bg-[#FFD700] text-[#1e3a5f] flex items-center justify-center font-bold text-lg shadow-lg shrink-0 border border-white/10">3</div>
                                    <p class="text-gray-100 font-medium text-lg leading-relaxed">Terima uang tunai dan slip penarikan.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Bagian Formulir Transfer -->
    <section id="form-transfer" class="py-20 bg-gradient-merek relative scroll-mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-12 gap-8 items-stretch">
                <!-- Info Kiri: Alur Card -->
                <div class="lg:col-span-4">
                    <div class="bg-[#162D4A] rounded-[2rem] p-10 h-full shadow-xl relative overflow-hidden group">
                        <!-- Dekorasi -->
                        <div class="absolute top-0 left-0 -ml-12 -mt-12 w-32 h-32 bg-white/5 rounded-full blur-3xl"></div>

                        <div class="relative z-10">
                            <div class="flex items-center gap-4 m\b-10 text-white">
                                <img src="{{ asset('img/landingpageicon/cash-stack 1.png') }}" alt="Transfer Icon" class="w-10 h-10 object-contain brightness-0 invert">
                                <h3 class="text-2xl font-bold">Alur Transfer</h3>
                            </div>

                            <div class="space-y-4">
                                <div class="bg-white/10 rounded-xl p-4 text-sm text-gray-200">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                </div>
                                <div class="bg-white/10 rounded-xl p-4 text-sm text-gray-200">
                                    Sed do eiusmod tempor incididunt ut labore et dolore magna.
                                </div>
                                <div class="bg-white/10 rounded-xl p-4 text-sm text-gray-200">
                                    Ut enim ad minim veniam, quis nostrud exercitation ullamco.
                                </div>
                                <div class="bg-white/10 rounded-xl p-4 text-sm text-gray-200">
                                    Duis aute irure dolor in reprehenderit in voluptate velit.
                                </div>
                                <div class="bg-white/10 rounded-xl p-4 text-sm text-gray-200">
                                    Excepteur sint occaecat cupidatat non proident, sunt in culpa.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Formulir Kanan -->
                <div class="lg:col-span-8 bg-white rounded-[2rem] p-8 sm:p-12 shadow-xl border border-gray-100">
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-50 border-l-4 border-[#1A8F6A] text-[#1A8F6A] rounded-r-lg flex items-center gap-3">
                            <img src="{{ asset('img/landingpageicon/check2-circle 1.png') }}" alt="Check Icon" class="w-5 h-5 object-contain">
                            <p class="text-sm font-medium">{{ session('success') }}</p>
                        </div>
                    @endif

                    <form action="#" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Kolom: Nama Pengirim -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Pengirim</label>
                                <input type="text" name="nama_pengirim" value="{{ old('nama_pengirim') }}"
                                    class="w-full px-4 py-3 bg-white border rounded-lg focus:ring-2 focus:ring-merek-biru focus:border-transparent outline-none transition {{ $errors->has('nama_pengirim') ? 'border-red-500' : 'border-gray-200' }}"
                                    placeholder="Masukkan nama lengkap">
                                @error('nama_pengirim') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Kolom: Nomor Telepon -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                                <input type="tel" name="nomor_telepon" value="{{ old('nomor_telepon') }}"
                                    class="w-full px-4 py-3 bg-white border rounded-lg focus:ring-2 focus:ring-merek-biru focus:border-transparent outline-none transition {{ $errors->has('nomor_telepon') ? 'border-red-500' : 'border-gray-200' }}"
                                    placeholder="Contoh: 08123456789">
                                @error('nomor_telepon') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Kolom: Nama Penerima -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Penerima</label>
                                <input type="text" name="nama_penerima" value="{{ old('nama_penerima') }}"
                                    class="w-full px-4 py-3 bg-white border rounded-lg focus:ring-2 focus:ring-merek-biru focus:border-transparent outline-none transition {{ $errors->has('nama_penerima') ? 'border-red-500' : 'border-gray-200' }}"
                                    placeholder="Nama lengkap penerima">
                                @error('nama_penerima') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Kolom: Tanggal Transfer -->
                            <div class="relative">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Transfer</label>
                                <input type="date" name="tanggal_transfer" value="{{ old('tanggal_transfer') }}"
                                    class="w-full px-4 py-3 bg-white border rounded-lg focus:ring-2 focus:ring-merek-biru focus:border-transparent outline-none transition text-gray-500 appearance-none {{ $errors->has('tanggal_transfer') ? 'border-red-500' : 'border-gray-200' }}">
                                <i class="ph ph-caret-down absolute right-4 top-10 text-gray-400 pointer-events-none"></i>
                                @error('tanggal_transfer') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Kolom: Nomor Rekening Penerima -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Rekening Penerima</label>
                                <input type="text" name="nomor_rekening_penerima" value="{{ old('nomor_rekening_penerima') }}"
                                    class="w-full px-4 py-3 bg-white border rounded-lg focus:ring-2 focus:ring-merek-biru focus:border-transparent outline-none transition {{ $errors->has('nomor_rekening_penerima') ? 'border-red-500' : 'border-gray-200' }}"
                                    placeholder="Masukkan nomor rekening">
                                @error('nomor_rekening_penerima') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Kolom: Catatan (Optional) spans 2 rows -->
                            <div class="sm:row-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                                <textarea name="catatan" rows="5" class="w-full px-4 py-3 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-merek-biru focus:border-transparent outline-none transition resize-none" placeholder="Tambahkan pesan jika perlu">{{ old('catatan') }}</textarea>
                            </div>

                            <!-- Kolom: Jumlah Transfer -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Transfer</label>
                                <input type="number" name="jumlah_transfer" value="{{ old('jumlah_transfer') }}"
                                    class="w-full px-4 py-3 bg-white border rounded-lg focus:ring-2 focus:ring-merek-biru focus:border-transparent outline-none transition {{ $errors->has('jumlah_transfer') ? 'border-red-500' : 'border-gray-200' }}"
                                    placeholder="0">
                                @error('jumlah_transfer') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Kolom: Upload Bukti -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Unggah Bukti Transfer</label>
                            <div onclick="document.getElementById('file-upload').click()"
                                class="mt-1 min-h-[160px] relative flex justify-center items-center px-6 pt-5 pb-6 border-2 border-dashed rounded-lg bg-white hover:bg-gray-50 transition cursor-pointer group overflow-hidden {{ $errors->has('bukti_transfer') ? 'border-red-300' : 'border-gray-300' }}">
                                <!-- Konten Default (Ikon & Teks) -->
                                <div id="upload-placeholder" class="space-y-2 text-center transition-all duration-300">
                                    <img src="{{ asset('img/landingpageicon/cloud-arrow-up 1.png') }}" alt="Upload Icon" class="w-12 h-12 mx-auto object-contain">
                                    <div class="flex text-sm text-gray-600 justify-center">
                                        <span class="font-medium text-merek-biru">Klik untuk unggah bukti</span>
                                    </div>
                                    <p class="text-xs text-gray-400">JPG atau PNG hingga 5MB</p>
                                </div>

                                <!-- Konten Pratinjau (Tersembunyi Awalnya) -->
                                <div id="preview-container" class="hidden absolute inset-0 w-full h-full bg-white z-10 items-center justify-center p-2">
                                    <img id="image-preview" src="#" alt="Pratinjau" class="max-h-full max-w-full object-contain rounded-md shadow-sm">
                                    <div class="absolute inset-0 bg-merek-biru/10 opacity-0 hover:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-[2px]">
                                        <div class="bg-merek-biru text-white text-xs font-bold px-4 py-2 rounded-full shadow-lg transform translate-y-4 group-hover:translate-y-0 transition-transform">
                                            Ganti Gambar
                                        </div>
                                    </div>
                                </div>

                                <input id="file-upload" name="bukti_transfer" type="file" class="sr-only" accept="image/*" onchange="previewImage(this)">
                            </div>
                            @error('bukti_transfer') <p class="text-xs text-red-500 mt-2">{{ $message }}</p> @enderror
                        </div>

                        <!-- Tombol Kirim -->
                        <div>
                            <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent rounded-xl shadow-md text-lg font-bold text-white bg-[#1A8F6A] hover:bg-opacity-95 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-merek-hijau transition transform active:scale-[0.98]">
                                Kirim
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Bagian Bawah (Footer) -->
    <footer class="bg-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-[#f3f6f9] rounded-[2.5rem] p-10 md:p-14 shadow-sm border border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 items-start">

                    <!-- Kolom Info -->
                    <div class="lg:col-span-4">
                        <div class="flex items-center gap-3 mb-8">
                            <img src="{{ asset('img/landingpageicon/Bank Icon.png') }}" alt="Bank Icon" class="w-8 h-8 object-contain">
                            <span class="font-bold text-2xl text-[#1e3a5f]">Bank Mini SMKN 1 Kawali</span>
                        </div>
                        <h5 class="font-bold text-[#1e3a5f] mb-4 text-lg">Alamat</h5>
                        <p class="text-gray-500 text-base leading-relaxed max-w-xs">
                            SMKN 1 Kawali<br>
                            Jalan. Talagasari, No. 35, Kawalimukti, Kawali Ciamis 46253
                        </p>
                    </div>

                    <!-- Media Sosial -->
                    <div class="lg:col-span-3">
                        <h5 class="font-bold text-[#1e3a5f] mb-4 text-lg">Media Digital</h5>
                        <ul class="space-y-3">
                            <li class="text-gray-500 text-base">
                                <span class="font-medium">Instagram :</span> <a href="https://instagram.com/smkn1kawali" target="_blank" class="hover:text-[#1e3a5f] transition hover:underline">@smkn1kawali</a>
                            </li>
                            <li class="text-gray-500 text-base">
                                <span class="font-medium">Tiktok :</span> <a href="https://tiktok.com/@smkn1kawali" target="_blank" class="hover:text-[#1e3a5f] transition hover:underline">@smkn1kawali</a>
                            </li>
                            <li class="text-gray-500 text-base">
                                <span class="font-medium">Youtube :</span> <a href="https://youtube.com/@SMKN1KawaliOfficial" target="_blank" class="hover:text-[#1e3a5f] transition hover:underline">@SMKN1KawaliOfficial</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Kontak -->
                    <div class="lg:col-span-3">
                        <h5 class="font-bold text-[#1e3a5f] mb-4 text-lg">Kontak Kami</h5>
                        <ul class="space-y-3">
                            <li class="text-gray-500 text-base">
                                <span class="font-medium">Email :</span> <a href="mailto:sekolah@gmail.com" class="hover:text-[#1e3a5f] transition">sekolah@gmail.com</a>
                            </li>
                            <li class="text-gray-500 text-base">
                                <span class="font-medium">Telepon :</span> <a href="tel:089001009098" class="hover:text-[#1e3a5f] transition">(089) 001-009-098</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Logo Sekolah -->
                    <div class="lg:col-span-2 flex justify-center lg:justify-end">
                        <div class="w-32 h-32 md:w-40 md:h-40">
                            <img src="{{ asset('img/logosmk.png') }}" alt="Logo SMKN 1 Kawali" class="w-full h-full object-contain">
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </footer>

    <!-- Script untuk animasi navbar dan interaktivitas menu -->
    <script>
        // Fungsi pratinjau gambar bukti transfer
        function previewImage(input) {
            const placeholder = document.getElementById('upload-placeholder');
            const container = document.getElementById('preview-container');
            const preview = document.getElementById('image-preview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    placeholder.classList.add('hidden');
                    container.classList.remove('hidden');
                    container.classList.add('flex');
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        // Logika untuk menampilkan/menyembunyikan menu mobile
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            const icon = document.getElementById('menu-icon');

            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                menu.classList.add('animate-fade-in-down');
                icon.classList.remove('ph-list');
                icon.classList.add('ph-x');
            } else {
                menu.classList.add('hidden');
                menu.classList.remove('animate-fade-in-down');
                icon.classList.remove('ph-x');
                icon.classList.add('ph-list');
            }
        }

        // Logika Animasi Scroll Navbar & Penyorotan Status Menu Aktif
        document.addEventListener('DOMContentLoaded', () => {
            const navbar = document.getElementById('navbar');
            const sections = document.querySelectorAll('header, section, div[id="alur-layanan"]');
            const desktopLinks = document.querySelectorAll('.desktop-nav-link');
            const mobileLinks = document.querySelectorAll('.mobile-nav-link');

            window.addEventListener('scroll', () => {
                // 1. Efek bayangan pada Navbar saat menggulir
                if (window.scrollY > 20) {
                    navbar.classList.add('shadow-md', 'bg-opacity-95', 'backdrop-blur-sm');
                    navbar.classList.remove('border-gray-100');
                } else {
                    navbar.classList.remove('shadow-md', 'bg-opacity-95', 'backdrop-blur-sm');
                    navbar.classList.add('border-gray-100');
                }

                // 2. Deteksi bagian halaman yang aktif untuk menyoroti menu terkait
                let current = 'beranda';
                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    const sectionId = section.getAttribute('id');

                    // Hanya perbarui 'current' jika bagian ini memiliki ID yang valid
                    if (window.scrollY >= sectionTop - 250 && sectionId) {
                        current = sectionId;
                    }
                });

                // 3. Perbarui tampilan tautan di menu Desktop
                desktopLinks.forEach(link => {
                    // Reset semua tautan ke status tidak aktif
                    link.classList.remove('text-gray-900', 'border-merek-kuning', 'font-semibold');
                    link.classList.add('text-gray-500', 'border-transparent', 'font-medium');

                    // Jika href link cocok dengan ID section saat ini, berikan status aktif
                    if (link.getAttribute('href') === `#${current}`) {
                        link.classList.remove('text-gray-500', 'border-transparent', 'font-medium');
                        link.classList.add('text-gray-900', 'border-merek-kuning', 'font-semibold');
                    }
                });

                // 4. Perbarui tampilan tautan di menu Mobile
                mobileLinks.forEach(link => {
                    // Reset status
                    link.classList.remove('text-merek-kuning', 'bg-gray-50');
                    link.classList.add('text-gray-600');

                    // Beri status aktif
                    if (link.getAttribute('href') === `#${current}`) {
                        link.classList.remove('text-gray-600');
                        link.classList.add('text-merek-kuning', 'bg-gray-50');
                    }
                });
            });
        });
    </script>
</body>
</html>
