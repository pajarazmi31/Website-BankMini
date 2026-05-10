<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supervisor - Data Petugas</title>
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

        /* Animasi transisi antar view */
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
            <button class="lg:hidden absolute top-4 right-4 text-gray-400 hover:text-brand-textDark" onclick="toggleSidebar()">
                <i class="ph ph-x text-2xl"></i>
            </button>
            
            <!-- Logo Section -->
            <div class="flex items-center gap-3 px-6 mb-10">
                <div class="text-brand-blue">
                    <img src="{{ asset('img/icon/navbar/bank 3.svg') }}" alt="Bank Logo" class="w-8 h-8 object-contain">
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
                
                <!-- Inactive Item: Dashboard -->
                <a href="{{ route('supervisor.dashboard') }}" class="flex items-center gap-3 px-6 py-3 text-[#a3a3a3] font-medium hover:bg-gray-50 transition-colors group">
                    <i class="ph ph-gauge text-[22px] group-hover:text-gray-600 transition-colors"></i>
                    <span class="text-[14px] group-hover:text-gray-600 transition-colors">Dashboard</span>
                </a>

                <!-- ================= START DROPDOWN MENU ================= -->
                <!-- Active Item Container: Kelola Data -->
                <div class="flex flex-col w-full">
                    
                    <!-- Main Toggle Button -->
                    <button onclick="toggleSubmenu('kelolaDataSubmenu', 'kelolaDataArrow')" class="relative flex items-center justify-between px-6 py-3 text-brand-textDark font-bold bg-gray-50/50 w-full hover:bg-gray-100 transition-colors">
                        <!-- Active Indicator Line -->
                        <div class="absolute left-0 top-1/2 -translate-y-1/2 w-[4px] h-8 bg-brand-blue rounded-r-md"></div>
                        
                        <div class="flex items-center gap-3">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-brand-blue">
                                <line x1="3" y1="12" x2="21" y2="12"></line>
                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                <line x1="3" y1="18" x2="21" y2="18"></line>
                            </svg>
                            <span class="text-[14px]">Kelola Data</span>
                        </div>
                        <!-- Arrow Icon (Berputar ke bawah) -->
                        <i id="kelolaDataArrow" class="ph-bold ph-caret-right text-[14px] text-gray-800 transition-transform duration-300 rotate-90"></i>
                    </button>

                    <!-- Submenu Items Container (Terbuka secara default) -->
                    <div id="kelolaDataSubmenu" class="grid transition-all duration-300 submenu-open">
                        <div class="overflow-hidden flex flex-col">
                            <!-- Inactive Submenu: Data Petugas -->
                            <a href="{{ route('supervisor.datapetugas') }}" class="pl-[52px] pr-6 py-2.5 text-gray-800 font-bold text-[13.5px] hover:bg-gray-50 transition-colors">
                                Data Petugas
                            </a>
                            <!-- Active Submenu: Data Nasabah -->
                            <a href="{{ route('supervisor.datanasabah') }}" class="pl-[52px] pr-6 py-2.5 text-[#a3a3a3] font-medium text-[13.5px] hover:text-gray-800 hover:bg-gray-50 transition-colors">
                                Data Nasabah
                            </a>
                            <div class="h-2"></div>
                        </div>
                    </div>
                </div>
                <!-- ================= END DROPDOWN MENU ================= -->

                <!-- Inactive Item: Verifikasi -->
                <a href="{{ route('supervisor.verifikasi.registrasi') }}" class="flex items-center gap-3 px-6 py-3 text-[#a3a3a3] font-medium hover:bg-gray-50 transition-colors group">
                    <i class="ph ph-folder text-[22px] group-hover:text-gray-600 transition-colors"></i>
                    <span class="text-[14px] group-hover:text-gray-600 transition-colors">Verifikasi</span>
                </a>

                <!-- Logout -->
                <div class="px-6 mt-4">
                    <a href="#" class="flex items-center gap-3 py-2 text-red-600 font-medium hover:text-red-700 transition-colors">
                        <i class="ph ph-sign-out text-[22px]"></i>
                        <span class="text-[14px]">Keluar</span>
                    </a>
                </div>
            </nav>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col h-screen overflow-y-auto w-full custom-scrollbar">
        <!-- MOBILE TOP BAR (Standardized) -->
        <div class="lg:hidden flex items-center justify-between px-6 py-4 bg-white border-b border-gray-100 sticky top-0 z-30">
            <div class="flex items-center gap-2 text-brand-blue">
                <img src="{{ asset('img/icon/navbar/bank 3.svg') }}" alt="Bank Logo" class="w-7 h-7 object-contain">
                <span class="font-bold text-sm tracking-tight text-gray-900">BANK MINI</span>
            </div>
            <button class="p-2 bg-gray-50 rounded-lg text-brand-blue" onclick="toggleSidebar()">
                <i class="ph ph-list text-2xl"></i>
            </button>
        </div>

        <div class="max-w-[1050px] mx-auto w-full flex flex-col h-full mt-2 pb-10 px-6 lg:px-8">
            
            <!-- Global Header Section -->
            <header class="flex flex-col lg:flex-row justify-between items-start lg:items-center pt-6 mb-6 lg:mb-10 gap-4 lg:gap-0">
                <div>
                    <h2 class="text-[26px] font-bold text-gray-800 mb-0.5">Selamat Datang, Supervisor!</h2>
                    <p class="text-gray-500 text-[14px]">Lorem Ipsum is simply dummy text of the printing.</p>
                </div>
                
                <div class="flex flex-col lg:flex-row items-start lg:items-center gap-4 lg:gap-8 w-full lg:w-auto">
                    <!-- Search Bar -->
                    <div id="searchBarContainer" class="relative w-full lg:w-auto">
                        <i class="ph ph-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-lg"></i>
                        <input type="text" placeholder="Search" class="pl-10 pr-4 py-2 border border-gray-200 rounded-full text-[13px] w-full lg:w-[260px] focus:outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue text-gray-700 placeholder-gray-400 bg-white shadow-sm lg:shadow-none">
                    </div>

                    <!-- Profile -->
                    <div class="hidden lg:flex items-center gap-3 w-full lg:w-auto justify-end">
                        <i class="ph-fill ph-user-circle text-[38px] text-brand-blue"></i>
                        <div class="text-left">
                            <p class="font-bold text-[14px] text-gray-800 leading-tight">Supervisor</p>
                            <p class="text-[12px] text-gray-400 mt-0.5">supervisor@gmail.com</p>
                        </div>
                    </div>
                </div>
            </header>


            <!-- ================= VIEW 1: TABEL DATA PETUGAS ================= -->
            <div id="viewTabelData" class="fade-in flex flex-1 flex-col justify-start">

                <!-- Table Header -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4 px-1">
                    <h3 class="text-[20px] md:text-[22px] font-bold text-gray-800">Data Petugas</h3>
                    <button onclick="switchView('tambah')" class="bg-brand-blue text-white px-6 py-3 md:py-2.5 rounded-[10px] text-[13px] font-bold flex items-center justify-center gap-2 hover:opacity-90 transition-all shadow-md w-full sm:w-auto">
                        <i class="ph ph-plus text-base"></i> Tambah Data
                    </button>
                </div>

                <!-- Table Card -->
                <div class="bg-white rounded-[20px] shadow-card p-6 w-full flex flex-col">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse whitespace-nowrap">
                            <thead>
                                <tr>
                                    <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] w-16 border-b border-gray-100 pl-4">No</th>
                                    <th class="py-4 px-4 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">Nama Petugas</th>
                                    <th class="py-4 px-4 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">Password</th>
                                    <th class="py-4 px-4 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100 hidden md:table-cell">Email</th>
                                    <th class="py-4 px-4 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">Role</th>
                                    <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] text-center w-36 border-b border-gray-100">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-[14px] text-gray-800 font-medium">
                                @php
                                    $petugasList = [
                                        ['no' => 1, 'nama' => 'Pajar Azmi Anugraha', 'email' => 'user@gmail.com', 'role' => 'Teller'],
                                        ['no' => 2, 'nama' => 'Salsabila Rosi Cahyani', 'email' => 'user@gmail.com', 'role' => 'Costumer Service'],
                                        ['no' => 3, 'nama' => 'Anisa Siti Nur Fajriyanti', 'email' => 'user@gmail.com', 'role' => 'Teller'],
                                        ['no' => 4, 'nama' => 'Yanto Supriyanto', 'email' => 'user@gmail.com', 'role' => 'Costumer Service'],
                                        ['no' => 5, 'nama' => 'Ali Mahendra', 'email' => 'user@gmail.com', 'role' => 'Teller'],
                                    ];
                                @endphp
                                @foreach($petugasList as $p)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="py-4 px-2 border-b border-gray-50 text-gray-600 pl-4">{{ $p['no'] }}.</td>
                                    <td class="py-4 px-4 border-b border-gray-50 text-gray-700 font-medium">{{ $p['nama'] }}</td>
                                    <td class="py-4 px-4 border-b border-gray-50 text-gray-600 font-medium tracking-widest">*****</td>
                                    <td class="py-4 px-4 border-b border-gray-50 hidden md:table-cell text-gray-700 font-medium">{{ $p['email'] }}</td>
                                    <td class="py-4 px-4 border-b border-gray-50 text-gray-700 font-medium">{{ $p['role'] }}</td>
                                    <td class="py-4 px-2 border-b border-gray-50">
                                        <div class="flex items-center justify-center gap-3">
                                            <button onclick="viewDetail('{{ $p['nama'] }}', '{{ $p['email'] }}', '{{ $p['role'] }}')" class="w-[28px] h-[28px] rounded-full bg-[#f1f5f9] text-[#1c3a5a] flex items-center justify-center hover:bg-gray-200 transition-colors" title="Lihat Detail"><i class="ph-fill ph-eye text-[15px]"></i></button>
                                            <button onclick="viewEdit('{{ $p['nama'] }}', '{{ $p['email'] }}', '{{ $p['role'] }}')" class="w-[28px] h-[28px] rounded-full bg-[#dcfce7] text-[#16a34a] flex items-center justify-center hover:bg-green-200 transition-colors" title="Edit Data"><i class="ph-fill ph-pencil-simple text-[15px]"></i></button>
                                            <button class="w-[28px] h-[28px] rounded-full bg-[#fee2e2] text-[#ef4444] flex items-center justify-center hover:bg-red-200 transition-colors" title="Hapus Data"><i class="ph-fill ph-trash text-[15px]"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="flex items-center justify-end gap-2 mt-5 pt-2">
                        <button class="w-[28px] h-[28px] rounded bg-brand-blue text-white flex items-center justify-center text-[12px] hover:bg-[#152a42] transition-colors shadow-sm">
                            <i class="ph-bold ph-caret-left"></i>
                        </button>
                        <span class="w-[28px] h-[28px] flex items-center justify-center text-[13px] font-bold text-[#1c3a5a]">1</span>
                        <button class="w-[28px] h-[28px] rounded bg-brand-blue text-white flex items-center justify-center text-[13px] font-bold hover:bg-[#152a42] transition-colors shadow-sm">2</button>
                        <button class="w-[28px] h-[28px] rounded bg-brand-blue text-white flex items-center justify-center text-[13px] font-bold hover:bg-[#152a42] transition-colors shadow-sm">3</button>
                        <button class="w-[28px] h-[28px] rounded bg-brand-blue text-white flex items-center justify-center text-[13px] font-bold hover:bg-[#152a42] transition-colors shadow-sm">4</button>
                        <span class="w-[20px] flex items-center justify-center text-[13px] font-bold text-gray-500 tracking-widest">...</span>
                        <button class="w-[28px] h-[28px] rounded bg-brand-blue text-white flex items-center justify-center text-[13px] font-bold hover:bg-[#152a42] transition-colors shadow-sm">40</button>
                        <button class="w-[28px] h-[28px] rounded bg-brand-blue text-white flex items-center justify-center text-[12px] hover:bg-[#152a42] transition-colors shadow-sm">
                            <i class="ph-bold ph-caret-right"></i>
                        </button>
                    </div>
                </div>
            </div>


            <!-- ================= CRUD VIEWS (Separated Files) ================= -->
            @include('supervisor.crud_datapetugas.tambah')
            @include('supervisor.crud_datapetugas.edit')
            @include('supervisor.crud_datapetugas.detail')

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

        // Fungsi Toggle Dropdown Menu
        function toggleSubmenu(submenuId, arrowId) {
            const submenu = document.getElementById(submenuId);
            const arrow = document.getElementById(arrowId);
            
            if (submenu.classList.contains('submenu-open')) {
                // Tutup
                submenu.classList.remove('submenu-open');
                submenu.classList.add('submenu-closed');
                arrow.style.transform = 'rotate(0deg)';
            } else {
                // Buka
                submenu.classList.remove('submenu-closed');
                submenu.classList.add('submenu-open');
                arrow.style.transform = 'rotate(90deg)';
            }
        }

        // Lihat Detail
        function viewDetail(nama, email, role) {
            document.getElementById('detail_nama').value = nama;
            document.getElementById('detail_email').value = email;
            document.getElementById('detail_role_text').value = role;
            
            switchView('detail');
        }

        // Edit Data
        function viewEdit(nama, email, role) {
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_email').value = email;
            
            let roleSelect = document.getElementById('edit_role');
            for(let i=0; i<roleSelect.options.length; i++) {
                if(roleSelect.options[i].text.toLowerCase() === role.toLowerCase()) {
                    roleSelect.selectedIndex = i;
                    break;
                }
            }
            switchView('edit');
        }

        // Pindah antar Tabel Data dan Form Input
        function switchView(viewName) {
            const views = {
                'tabel': document.getElementById('viewTabelData'),
                'tambah': document.getElementById('viewTambahData'),
                'edit': document.getElementById('viewEditData'),
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