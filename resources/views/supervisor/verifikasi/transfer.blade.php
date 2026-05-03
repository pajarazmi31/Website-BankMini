<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supervisor - Verifikasi Transfer</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            blue: '#1c3a5a',
                            green: '#10a163',
                            gold: '#bd8607',
                            bg: '#f8f9fb',
                            textDark: '#1e293b',
                            textMuted: '#94a3b8',
                            sidebarIcon: '#a1a1aa'
                        }
                    },
                    boxShadow: {
                        'card': '0 4px 20px -2px rgba(0, 0, 0, 0.03)',
                        'sidebar': '4px 0 24px -4px rgba(0,0,0,0.02)'
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #f8f9fb;
        }
        
        /* Custom scrollbar untuk area utama */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Utility class untuk animasi dropdown yang mulus */
        .submenu-open {
            grid-template-rows: 1fr;
        }
        .submenu-closed {
            grid-template-rows: 0fr;
        }

        /* Fade animation */
        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="flex h-screen w-full overflow-hidden text-brand-textDark selection:bg-brand-blue selection:text-white relative">

    <!-- OVERLAY (Mobile) -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed lg:relative inset-y-0 left-0 w-[250px] h-full py-0 lg:py-5 pl-0 lg:pl-5 pr-0 flex-shrink-0 z-50 lg:z-20 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
        <div class="bg-white h-full lg:rounded-[24px] shadow-sidebar flex flex-col pt-8 pb-8 overflow-hidden relative">
            
            <!-- Close Button (Mobile) -->
            <button class="lg:hidden absolute top-4 right-4 text-gray-400 hover:text-brand-textDark" onclick="toggleSidebar()">
                <i class="ph ph-x text-2xl"></i>
            </button>
            
            <!-- Logo Section -->
            <div class="flex items-center gap-3 px-6 mb-10">
                <div class="text-brand-blue">
                    <!-- Custom Bank Icon SVG -->
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 21h18"/>
                        <path d="M3 10h18"/>
                        <path d="M5 6l7-3 7 3"/>
                        <path d="M4 10v11"/>
                        <path d="M20 10v11"/>
                        <path d="M8 14v3"/>
                        <path d="M12 14v3"/>
                        <path d="M16 14v3"/>
                    </svg>
                </div>
                <div>
                    <h1 class="font-extrabold text-[16px] leading-tight tracking-tight text-gray-900">BANK MINI</h1>
                    <p class="text-[10px] text-gray-500 font-medium mt-0.5">SMKN 1 Kawali</p>
                </div>
            </div>

            <!-- Menu Label -->
            <div class="px-6 mb-3">
                <p class="text-[11px] font-semibold text-brand-sidebarIcon tracking-wider">MENU</p>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 flex flex-col gap-1 w-full">
                
                <!-- Dashboard -->
                <a href="{{ route('supervisor.dashboard') }}" class="flex items-center gap-3 px-6 py-3 text-[#a3a3a3] font-medium hover:bg-gray-50 transition-colors group">
                    <i class="ph ph-gauge text-[22px] group-hover:text-gray-600 transition-colors"></i>
                    <span class="text-[14px] group-hover:text-gray-600 transition-colors">Dashboard</span>
                </a>

                <!-- Kelola Data (Dropdown Tertutup) -->
                <div class="flex flex-col w-full">
                    <button onclick="toggleSubmenu('kelolaDataSubmenu', 'kelolaDataArrow')" class="relative flex items-center justify-between px-6 py-3 text-[#a3a3a3] font-medium bg-transparent w-full hover:bg-gray-50 transition-colors group">
                        <div class="flex items-center gap-3">
                            <i class="ph ph-list text-[22px] group-hover:text-gray-600 transition-colors"></i>
                            <span class="text-[14px] group-hover:text-gray-600 transition-colors">Kelola Data</span>
                        </div>
                        <i id="kelolaDataArrow" class="ph-bold ph-caret-right text-[14px] group-hover:text-gray-600 transition-transform duration-300"></i>
                    </button>
                    <div id="kelolaDataSubmenu" class="grid transition-all duration-300 submenu-closed">
                        <div class="overflow-hidden flex flex-col">
                            <a href="{{ route('supervisor.datapetugas') }}" class="pl-[52px] pr-6 py-2.5 text-[#a3a3a3] font-medium text-[13.5px] hover:text-gray-800 hover:bg-gray-50 transition-colors">Data Petugas</a>
                            <a href="{{ route('supervisor.datanasabah') }}" class="pl-[52px] pr-6 py-2.5 text-[#a3a3a3] font-medium text-[13.5px] hover:text-gray-800 hover:bg-gray-50 transition-colors">Data Nasabah</a>
                            <div class="h-2"></div>
                        </div>
                    </div>
                </div>

                <!-- Active Item: Verifikasi -->
                <a href="{{ route('supervisor.verifikasi.registrasi') }}" class="relative flex items-center gap-3 px-6 py-3 text-brand-textDark font-bold bg-gray-50/50 group transition-colors">
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-[4px] h-8 bg-brand-blue rounded-r-md"></div>
                    <i class="ph ph-folder-open text-[22px] text-brand-blue"></i>
                    <span class="text-[14px]">Verifikasi</span>
                </a>

                <!-- Logout -->
                <div class="px-6 mt-4">
                    <!-- 
                        BAGIAN BACKEND: LOGOUT
                        - Saat ini berupa link #.
                        - Idealnya menggunakan method POST ke route logout untuk menghapus session auth secara aman.
                    -->
                    <a href="#" class="flex items-center gap-3 py-2 text-red-600 font-medium hover:text-red-700 transition-colors">
                        <i class="ph ph-sign-out text-[22px]"></i>
                        <span class="text-[14px]">Keluar</span>
                    </a>
                </div>
            </nav>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 h-full px-4 lg:px-8 py-4 lg:py-6 flex flex-col justify-start overflow-y-auto custom-scrollbar w-full">
        
        <!-- MOBILE TOP BAR -->
        <div class="lg:hidden flex items-center justify-between mb-6 bg-white p-4 rounded-2xl shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-gray-50 sticky top-0 z-30">
            <div class="flex items-center gap-2 text-brand-blue">
                <img src="{{ asset('img/icon/navbar/bank 3.svg') }}" alt="Bank Logo" class="w-8 h-8 object-contain">
                <span class="font-bold text-sm tracking-tight text-gray-900">BANK MINI</span>
            </div>
            <button class="p-2 bg-brand-bg rounded-lg text-brand-blue" onclick="toggleSidebar()">
                <i class="ph ph-list text-2xl"></i>
            </button>
        </div>

        <div class="max-w-[1050px] mx-auto w-full flex flex-col h-full mt-2 pb-10">
            
            <!-- Global Header Section -->
            <header class="flex flex-col md:flex-row justify-between items-start mb-8 gap-4 md:gap-0">
                <div>
                    <h2 class="text-[22px] md:text-[26px] font-bold text-gray-800 mb-0.5">Selamat Datang, Supervisor!</h2>
                    <p class="text-gray-500 text-[12px] md:text-[14px]">Lorem Ipsum is simply dummy text of the printing.</p>
                </div>
                
                <div class="flex flex-col md:flex-row items-center gap-4 md:gap-8 w-full md:w-auto">
                    <!-- Search Bar -->
                    <div id="searchBarContainer" class="relative w-full md:w-auto hidden md:block">
                        <i class="ph ph-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-lg"></i>
                        <input type="text" placeholder="Search" class="pl-10 pr-4 py-2 border border-gray-200 rounded-lg text-[13px] w-[260px] focus:outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue text-gray-700 placeholder-gray-400">
                    </div>

                    <!-- Profile -->
                    <div class="hidden md:flex items-center gap-3">
                        <i class="ph-fill ph-user-circle text-[38px] text-brand-blue"></i>
                        <div class="text-left">
                            <p class="font-bold text-[14px] text-gray-800 leading-tight">Supervisor</p>
                            <p class="text-[12px] text-gray-400 mt-0.5">supervisor@gmail.com</p>
                        </div>
                    </div>
                </div>
            </header>


            <!-- ================= VIEW 1: TABEL PENDING VERIFIKASI (TRANSFER) ================= -->
            <div id="viewTabelData" class="fade-in flex flex-1 flex-col justify-start">
                
                <!-- Section Title & Tabs -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-5 px-1 gap-4">
                    <h3 class="text-[24px] font-bold text-gray-800">Pending Verifikasi</h3>
                    
                    <div class="flex bg-gray-100 p-1 rounded-xl w-full sm:w-[300px]">
                        <a href="{{ route('supervisor.verifikasi.registrasi') }}" class="flex-1 px-4 py-2 text-gray-500 font-medium text-[13px] hover:text-brand-blue transition-colors text-center">Registrasi</a>
                        <a href="{{ route('supervisor.verifikasi') }}" class="flex-1 px-4 py-2 bg-white rounded-lg shadow-sm text-brand-blue font-bold text-[13px] text-center transition-all">Transfer</a>
                    </div>
                </div>

                <!-- Table Card -->
                <div class="bg-white rounded-[20px] shadow-card p-6 w-full flex flex-col">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr>
                                    <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] w-12 border-b border-gray-100">No</th>
                                    <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">Nama Pengirim</th>
                                    <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">Nama Penerima</th>
                                    <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">Nominal Transfer</th>
                                    <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">Nomor Telepon</th>
                                    <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] text-center w-[140px] border-b border-gray-100">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-[14px] text-gray-800 font-medium">
                                <!-- 
                                    BAGIAN BACKEND: DATA TABEL VERIFIKASI TRANSFER
                                    - Data baris statis di bawah perlu diganti dengan data dari database.
                                    - Lakukan looping foreach untuk menampilkan data transaksi transfer tamu yang berstatus pending.
                                -->
                                <!-- Row 1 -->
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="py-4 px-2 border-b border-gray-50">1.</td>
                                    <td class="py-4 px-2 border-b border-gray-50">Pajar Azmi Anugraha</td>
                                    <td class="py-4 px-2 border-b border-gray-50">Salsabila Rosi Cahyani</td>
                                    <td class="py-4 px-2 border-b border-gray-50">Rp. 200.000</td>
                                    <td class="py-4 px-2 border-b border-gray-50">081234567890</td>
                                    <td class="py-4 px-2 border-b border-gray-50">
                                        <div class="flex items-center justify-center gap-2">
                                            <!-- Tombol Lihat (Mata) memanggil view Form -->
                                            <button onclick="viewDetail('Pajar Azmi Anugraha', 'Salsabila Rosi Cahyani', 'Rp. 200.000', '03-03-232410243', '081234567890')" class="w-[30px] h-[30px] rounded-full bg-[#e2e8f0] text-brand-blue flex items-center justify-center hover:bg-gray-300 transition-colors" title="Lihat Detail"><i class="ph-fill ph-eye text-[16px]"></i></button>
                                            
                                            <!-- 
                                                BAGIAN BACKEND: AKSI VERIFIKASI (SETUJUI / TOLAK)
                                                - Tombol Setujui dan Tolak di bawah idealnya diubah menjadi <form> dengan method POST/PUT 
                                                  yang mengirim status verifikasi ke controller, atau menggunakan request AJAX.
                                            -->
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
                    <div class="flex items-center justify-end gap-1.5 mt-5 pt-2">
                        <button class="w-[26px] h-[26px] rounded bg-brand-blue text-white flex items-center justify-center text-[12px] hover:bg-[#152a42] transition-colors">
                            <i class="ph-bold ph-caret-left"></i>
                        </button>
                        <span class="w-[26px] h-[26px] flex items-center justify-center text-[13px] font-bold text-brand-blue">1</span>
                        <button class="w-[26px] h-[26px] rounded bg-brand-blue text-white flex items-center justify-center text-[13px] font-medium hover:bg-[#152a42] transition-colors">2</button>
                        <button class="w-[26px] h-[26px] rounded bg-brand-blue text-white flex items-center justify-center text-[13px] font-medium hover:bg-[#152a42] transition-colors">3</button>
                        <button class="w-[26px] h-[26px] rounded bg-brand-blue text-white flex items-center justify-center text-[13px] font-medium hover:bg-[#152a42] transition-colors">4</button>
                        <span class="w-[20px] flex items-center justify-center text-[13px] font-bold text-gray-500 tracking-widest">...</span>
                        <button class="w-[26px] h-[26px] rounded bg-brand-blue text-white flex items-center justify-center text-[13px] font-medium hover:bg-[#152a42] transition-colors">40</button>
                        <button class="w-[26px] h-[26px] rounded bg-brand-blue text-white flex items-center justify-center text-[12px] hover:bg-[#152a42] transition-colors">
                            <i class="ph-bold ph-caret-right"></i>
                        </button>
                    </div>
                </div>
            </div>


            <!-- ================= CRUD VIEWS (Separated Files) ================= -->
            @include('supervisor.verifikasi.transfer.detail')

        </div>
    </main>

    <!-- JavaScript Interaction -->
    <script>
        // Fungsi Toggle Sidebar Mobile
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        // Toggle Submenu Sidebar
        function toggleSubmenu(submenuId, arrowId) {
            const submenu = document.getElementById(submenuId);
            const arrow = document.getElementById(arrowId);
            
            if (submenu.classList.contains('submenu-open')) {
                submenu.classList.remove('submenu-open');
                submenu.classList.add('submenu-closed');
                arrow.style.transform = 'rotate(0deg)';
            } else {
                submenu.classList.remove('submenu-closed');
                submenu.classList.add('submenu-open');
                arrow.style.transform = 'rotate(90deg)';
            }
        }

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

            const searchBar = document.getElementById('searchBarContainer');

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
                    if(searchBar) searchBar.classList.remove('invisible');
                } else {
                    activeView.classList.add('block');
                    if(searchBar) searchBar.classList.add('invisible');
                }
            }
            
            document.querySelector('main').scrollTo({ top: 0, behavior: 'smooth' });
        }
    </script>
</body>
</html>