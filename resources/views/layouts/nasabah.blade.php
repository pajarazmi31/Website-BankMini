<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bank Mini')</title>

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
                        background: '#f8f9fc',
                        primary: '#15395b',
                        primaryLight: '#436585',
                        cardLight: '#eef2f6',
                        warningBg: '#fcefc7',
                        textDark: '#1f2937',
                        textGray: '#8892a0',
                        formBorder: '#e5e7eb',
                        btnGreen: '#1aa061',
                        accentYellow: '#c88d22',
                    },
                    backgroundImage: {
                        'primary-gradient': 'linear-gradient(to right, #143657, #1E5081, #143657)',
                    }
                }
            }
        }
    </script>
    <style>
        /* Custom scrollbar */
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

        /* Remove number input arrows */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
    @yield('styles')
</head>

<body class="bg-background text-textDark flex h-screen overflow-hidden relative">

    <!-- OVERLAY (Mobile) -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden" onclick="toggleSidebar()"></div>

    <!-- SIDEBAR -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 w-64 bg-white border-r border-gray-100 flex flex-col z-50 shadow-[4px_0_24px_rgba(0,0,0,0.02)] transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out lg:relative lg:z-10">
        <button class="lg:hidden absolute top-4 right-4 text-gray-400 hover:text-textDark" onclick="toggleSidebar()">
            <i class="ph ph-x text-2xl"></i>
        </button>

        <div class="px-8 pt-8 pb-10 flex items-center gap-3">
            <img src="{{ asset('img/icon/navbar/bank 3.svg') }}" alt="Bank Logo" class="w-10 h-10 object-contain">
            <div>
                <h1 class="font-bold text-lg leading-tight tracking-tight text-textDark">BANK MINI</h1>
                <p class="text-[10px] text-textGray">SMKN 1 Kawali</p>
            </div>
        </div>

        <div class="px-8 flex-1">
            <p class="text-xs font-semibold text-gray-400 mb-4 tracking-wider">MENU</p>
            <ul class="space-y-2 relative">
                @php $route = Route::currentRouteName(); @endphp

                <!-- Indikator Aktif -->
                <div class="absolute -left-8 w-2 h-10 bg-primary rounded-r-lg transition-all duration-300"
                    style="top: {{ $route == 'nasabah.dashboard' ? '4px' : '52px' }}"></div>

                <li>
                    <a href="{{ route('nasabah.dashboard') }}" class="flex items-center gap-3 py-3 transition-colors {{ $route == 'nasabah.dashboard' ? 'text-textDark font-semibold' : 'text-[#a0aab8] font-medium hover:text-primary' }}">
                        <img src="{{ asset('img/icon/sidebar/dashboard.png') }}" alt="Dashboard" class="w-5 h-5 {{ $route == 'nasabah.dashboard' ? '' : 'opacity-40' }}">
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('nasabah.transfer') }}" class="flex items-center gap-3 py-3 transition-colors {{ $route == 'nasabah.transfer' ? 'text-textDark font-semibold' : 'text-[#a0aab8] font-medium hover:text-primary' }}">
                        <img src="{{ asset('img/icon/sidebar/transfer.png') }}" alt="Transfer" class="w-5 h-5 {{ $route == 'nasabah.transfer' ? '' : 'opacity-40' }}">
                        Transfer
                    </a>
                </li>
                <li class="mt-4">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <button
                            type="submit"
                            class="flex items-center gap-3 py-2 text-red-600 font-medium hover:text-red-700 transition-colors">
                            <i class="ph ph-sign-out text-[22px]"></i>
                            <span class="text-[14px]">Keluar</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 flex flex-col h-screen overflow-y-auto w-full">
        <!-- MOBILE TOP BAR -->
        <div class="lg:hidden flex items-center justify-between px-6 py-4 bg-white border-b border-gray-100 sticky top-0 z-30">
            <div class="flex items-center gap-2">
                <img src="{{ asset('img/icon/navbar/bank 3.svg') }}" alt="Bank Logo" class="w-7 h-7 object-contain">
                <span class="font-bold text-sm tracking-tight text-textDark">BANK MINI</span>
            </div>
            <button class="p-2 bg-gray-50 rounded-lg text-primary" onclick="toggleSidebar()">
                <i class="ph ph-list text-2xl"></i>
            </button>
        </div>

        <!-- HEADER (Desktop) -->
        <header class="px-10 py-8 flex justify-between items-center bg-background/80 backdrop-blur-sm sticky top-0 z-20 hidden lg:flex">
            <div>
                <h2 class="text-2xl font-bold text-textDark">@yield('header_title')</h2>
                <p class="text-textGray text-sm mt-1">@yield('header_subtitle')</p>
            </div>

            <div class="flex items-center gap-6">
                <div class="flex items-center gap-2 bg-[#d1f4e0] text-[#0d7d42] px-4 py-2 rounded-full text-sm font-semibold">
                    <img src="{{ asset('img/icon/dashboard/check-status.png') }}" alt="Status" class="w-4 h-4">
                    Rekening Aktif
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 overflow-hidden border border-gray-100">
                        <img src="{{ asset('img/icon/navbar/user-avatar.png') }}" alt="User" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <p class="text-sm font-bold text-textDark leading-tight">{{ $nasabah->nama_nasabah }}</p>
                        <p class="text-xs text-[#a0aab8]">{{ $user->email }}</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- CONTENT AREA -->
        @yield('content')
    </main>

    @yield('modals')

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    </script>
    @yield('scripts')
</body>

</html>