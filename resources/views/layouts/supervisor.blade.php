<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Supervisor - Bank Mini')</title>
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
                    },
                    backgroundImage: {
                        'primary-gradient': 'linear-gradient(to right, #143657, #1E5081, #143657)',
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #f8f9fb; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        .submenu-open { grid-template-rows: 1fr; }
        .submenu-closed { grid-template-rows: 0fr; }
        @yield('styles')
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
            
            <div class="flex items-center gap-3 px-6 mb-10">
                <div class="text-brand-blue">
                    <img src="{{ asset('img/icon/navbar/bank 3.svg') }}" alt="Bank Logo" class="w-8 h-8 object-contain">
                </div>
                <div>
                    <h1 class="font-extrabold text-[16px] leading-tight tracking-tight text-gray-900">BANK MINI</h1>
                    <p class="text-[10px] text-gray-500 font-medium mt-0.5">SMKN 1 Kawali</p>
                </div>
            </div>

            <div class="px-6 mb-3">
                <p class="text-[11px] font-semibold text-brand-sidebarIcon tracking-wider">MENU</p>
            </div>

            <nav class="flex-1 flex flex-col gap-1 w-full overflow-y-auto custom-scrollbar">
                @php 
                    $route = Route::currentRouteName();
                    $isKelolaData = str_contains($route, 'supervisor.datapetugas') || str_contains($route, 'supervisor.datanasabah');
                @endphp
                
                <!-- Dashboard -->
                <div class="relative">
                    @if($route == 'supervisor.dashboard')
                        <div class="absolute left-0 top-1/2 -translate-y-1/2 w-[4px] h-8 bg-brand-blue rounded-r-md"></div>
                    @endif
                    <a href="{{ route('supervisor.dashboard') }}" class="flex items-center gap-3 px-6 py-3 {{ $route == 'supervisor.dashboard' ? 'text-brand-textDark font-bold bg-gray-50/50' : 'text-[#a3a3a3] font-medium hover:bg-gray-50' }} transition-colors group">
                        <i class="ph{{ $route == 'supervisor.dashboard' ? '-fill' : '' }} ph-gauge text-[22px] {{ $route == 'supervisor.dashboard' ? 'text-brand-blue' : 'group-hover:text-gray-600' }}"></i>
                        <span class="text-[14px]">Dashboard</span>
                    </a>
                </div>

                <!-- Kelola Data Dropdown -->
                <div class="flex flex-col w-full">
                    <button onclick="toggleSubmenu('kelolaDataSubmenu', 'kelolaDataArrow')" class="relative flex items-center justify-between px-6 py-3 {{ $isKelolaData ? 'text-brand-textDark font-bold' : 'text-[#a3a3a3] font-medium' }} hover:bg-gray-50 transition-colors group w-full">
                        <div class="flex items-center gap-3">
                            <i class="ph ph-list text-[22px] {{ $isKelolaData ? 'text-brand-blue' : 'group-hover:text-gray-600' }}"></i>
                            <span class="text-[14px]">Kelola Data</span>
                        </div>
                        <i id="kelolaDataArrow" class="ph-bold ph-caret-right text-[14px] transition-transform duration-300 {{ $isKelolaData ? 'rotate-90' : '' }}"></i>
                    </button>
                    <div id="kelolaDataSubmenu" class="grid transition-all duration-300 {{ $isKelolaData ? 'submenu-open' : 'submenu-closed' }}">
                        <div class="overflow-hidden flex flex-col">
                            <a href="{{ route('supervisor.datapetugas') }}" class="pl-[52px] pr-6 py-2.5 {{ $route == 'supervisor.datapetugas' ? 'text-brand-blue font-bold' : 'text-[#a3a3a3] font-medium' }} text-[13.5px] hover:text-gray-800 hover:bg-gray-50 transition-colors">Data Petugas</a>
                            <a href="{{ route('supervisor.datanasabah') }}" class="pl-[52px] pr-6 py-2.5 {{ $route == 'supervisor.datanasabah' ? 'text-brand-blue font-bold' : 'text-[#a3a3a3] font-medium' }} text-[13.5px] hover:text-gray-800 hover:bg-gray-50 transition-colors">Data Nasabah</a>
                            <div class="h-2"></div>
                        </div>
                    </div>
                </div>

                <!-- Verifikasi -->
                <div class="relative">
                    @if($route == 'supervisor.verifikasi' || $route == 'supervisor.verifikasi.registrasi')
                        <div class="absolute left-0 top-1/2 -translate-y-1/2 w-[4px] h-8 bg-brand-blue rounded-r-md"></div>
                    @endif
                    <a href="{{ route('supervisor.verifikasi.registrasi') }}" class="flex items-center gap-3 px-6 py-3 {{ ($route == 'supervisor.verifikasi' || $route == 'supervisor.verifikasi.registrasi') ? 'text-brand-textDark font-bold bg-gray-50/50' : 'text-[#a3a3a3] font-medium hover:bg-gray-50' }} transition-colors group">
                        <i class="ph{{ ($route == 'supervisor.verifikasi' || $route == 'supervisor.verifikasi.registrasi') ? '-fill' : '' }} ph-folder text-[22px] {{ ($route == 'supervisor.verifikasi' || $route == 'supervisor.verifikasi.registrasi') ? 'text-brand-blue' : 'group-hover:text-gray-600' }}"></i>
                        <span class="text-[14px]">Verifikasi</span>
                    </a>
                </div>

                <!-- Keluar -->
                <div class="px-6 mt-4">
                    <a href="{{ route('login') }}" class="flex items-center gap-3 py-2 text-red-600 font-medium hover:text-red-700 transition-colors">
                        <i class="ph ph-sign-out text-[22px]"></i>
                        <span class="text-[14px]">Keluar</span>
                    </a>
                </div>
            </nav>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col h-screen overflow-y-auto w-full">
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

        <div class="max-w-[1050px] mx-auto w-full flex flex-col h-full mt-2 pb-10 px-6 lg:px-10">
            <!-- Header Section -->
            <header class="flex flex-col md:flex-row justify-between items-start md:items-center py-6 lg:py-8 mb-4 gap-4 md:gap-0">
                <div>
                    <h2 class="text-[22px] md:text-[26px] font-bold text-gray-800 mb-0.5">@yield('header_title', 'Selamat Datang!')</h2>
                    <p class="text-gray-500 text-[12px] md:text-[14px]">@yield('header_subtitle', 'Kelola pengawasan Bank Mini.')</p>
                </div>
                <div class="flex items-center gap-3">
                    <i class="ph-fill ph-user-circle text-[38px] text-brand-blue"></i>
                    <div class="text-left">
                        <p class="font-bold text-[14px] text-gray-800 leading-tight">Supervisor</p>
                        <p class="text-[12px] text-gray-400 mt-0.5">supervisor@gmail.com</p>
                    </div>
                </div>
            </header>

            @yield('content')
        </div>
    </main>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        function toggleSubmenu(submenuId, arrowId) {
            const submenu = document.getElementById(submenuId);
            const arrow = document.getElementById(arrowId);
            if (submenu.classList.contains('submenu-open')) {
                submenu.classList.replace('submenu-open', 'submenu-closed');
                arrow.style.transform = 'rotate(0deg)';
            } else {
                submenu.classList.replace('submenu-closed', 'submenu-open');
                arrow.style.transform = 'rotate(90deg)';
            }
        }
    </script>
    @yield('scripts')
</body>
</html>
