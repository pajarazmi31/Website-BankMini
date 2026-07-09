<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Teller - Bank Mini')</title>
    <link rel="icon" href="{{ asset('img/Logo Bank Mini K-one.jpeg') }}" type="image/jpeg">
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
                        'primary-gradient': 'linear-gradient(to bottom, #143657, #1E5081, #143657)',
                        'success-gradient': 'linear-gradient(to bottom, #008959, #1FB581, #008959)',
                        'warning-gradient': 'linear-gradient(to bottom, #AC7500, #dd9700, #AC7500)',
                        'button-gradient': 'linear-gradient(to right, #008959, #1E9F71, #008959)',
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #f8f9fb;
        }

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
                <img src="{{ asset('img/bankmini2.png') }}" alt="Bank Logo" class="w-12 h-12 object-contain">
                <div>
                    <h1 class="font-extrabold text-[16px] leading-tight tracking-tight text-gray-900">Bank Mini</h1>
                    <p class="text-[10px] text-gray-500 font-semibold mt-0.5">K-One</p>
                </div>
            </div>

            <div class="px-6 mb-3">
                <p class="text-[11px] font-semibold text-brand-sidebarIcon tracking-wider">MENU</p>
            </div>

            <nav class="flex-1 flex flex-col gap-1 overflow-y-auto custom-scrollbar">
                @php $route = Route::currentRouteName(); @endphp

                <!-- Dashboard -->
                <div class="relative">
                    @if($route == 'teller.dashboard')
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-[4px] h-8 bg-brand-blue rounded-r-md"></div>
                    @endif
                    <a href="{{ route('teller.dashboard') }}" class="flex items-center gap-3 px-6 py-3 {{ $route == 'teller.dashboard' ? 'text-brand-textDark font-bold bg-gray-50/50' : 'text-[#a3a3a3] font-medium hover:bg-gray-50' }} transition-colors group">
                        <i class="ph{{ $route == 'teller.dashboard' ? '-fill' : '' }} ph-gauge text-[22px] {{ $route == 'teller.dashboard' ? 'text-brand-blue' : 'group-hover:text-gray-600' }}"></i>
                        <span class="text-[14px]">Dashboard</span>
                    </a>
                </div>

                <!-- Setoran -->
                <div class="relative">
                    @if($route == 'teller.setoran')
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-[4px] h-8 bg-brand-blue rounded-r-md"></div>
                    @endif
                    <a href="{{ route('teller.setoran') }}" class="flex items-center gap-3 px-6 py-3 {{ $route == 'teller.setoran' ? 'text-brand-textDark font-bold bg-gray-50/50' : 'text-[#a3a3a3] font-medium hover:bg-gray-50' }} transition-colors group">
                        <i class="ph{{ $route == 'teller.setoran' ? '-fill' : '' }} ph-money text-[22px] {{ $route == 'teller.setoran' ? 'text-brand-blue' : 'group-hover:text-gray-600' }}"></i>
                        <span class="text-[14px]">Setoran</span>
                    </a>
                </div>

                <!-- Penarikan -->
                <div class="relative">
                    @if($route == 'teller.penarikan')
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-[4px] h-8 bg-brand-blue rounded-r-md"></div>
                    @endif
                    <a href="{{ route('teller.penarikan') }}" class="flex items-center gap-3 px-6 py-3 {{ $route == 'teller.penarikan' ? 'text-brand-textDark font-bold bg-gray-50/50' : 'text-[#a3a3a3] font-medium hover:bg-gray-50' }} transition-colors group">
                        <i class="ph{{ $route == 'teller.penarikan' ? '-fill' : '' }} ph-wallet text-[22px] {{ $route == 'teller.penarikan' ? 'text-brand-blue' : 'group-hover:text-gray-600' }}"></i>
                        <span class="text-[14px]">Penarikan</span>
                    </a>
                </div>

                <!-- Transfer -->
                <div class="relative">
                    @if($route == 'teller.transfer')
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-[4px] h-8 bg-brand-blue rounded-r-md"></div>
                    @endif
                    <a href="{{ route('teller.transfer') }}" class="flex items-center gap-3 px-6 py-3 {{ $route == 'teller.transfer' ? 'text-brand-textDark font-bold bg-gray-50/50' : 'text-[#a3a3a3] font-medium hover:bg-gray-50' }} transition-colors group">
                        <i class="ph{{ $route == 'teller.transfer' ? '-fill' : '' }} ph-arrows-left-right text-[22px] {{ $route == 'teller.transfer' ? 'text-brand-blue' : 'group-hover:text-gray-600' }}"></i>
                        <span class="text-[14px]">Transfer</span>
                    </a>
                </div>
                <!-- Logout -->
                <div class="px-6 mt-4">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <button
                            type="submit"
                            class="flex items-center gap-3 py-2 text-red-600 font-medium hover:text-red-700 transition-colors">
                            <i class="ph ph-sign-out text-[22px]"></i>
                            <span class="text-[14px]">Keluar</span>
                        </button>
                    </form>
                </div>
            </nav>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col h-screen overflow-y-auto w-full">
        <!-- MOBILE TOP BAR (Standardized) -->
        <div class="lg:hidden flex items-center justify-between px-6 py-4 bg-white border-b border-gray-100 sticky top-0 z-30">
            <div class="flex items-center gap-2 text-brand-blue">
                <img src="{{ asset('img/bankmini2.png') }}" alt="Bank Logo" class="w-9 h-9 object-contain">
                <div class="flex flex-col">
                    <span class="font-bold text-sm tracking-tight text-gray-900 leading-none">Bank Mini</span>
                    <span class="text-[10px] text-gray-500 font-semibold leading-none mt-0.5">K-One</span>
                </div>
            </div>
            <button class="p-2 bg-gray-50 rounded-lg text-brand-blue" onclick="toggleSidebar()">
                <i class="ph ph-list text-2xl"></i>
            </button>
        </div>

        <div class="max-w-[1050px] mx-auto w-full flex flex-col h-full mt-2 pb-10 px-6 lg:px-10">
            <!-- Header Section -->
            <header class="flex flex-col md:flex-row justify-between items-start md:items-center py-4 lg:py-8 mb-4 gap-4  hidden lg:flex">
                <div class="flex-1">
                    <h2 class="text-[22px] md:text-[26px] font-bold text-gray-800 mb-0.5">@yield('header_title', 'Selamat Datang!')</h2>
                    <p class="text-gray-500 text-[12px] md:text-[14px]">@yield('header_subtitle', 'Kelola transaksi nasabah.')</p>
                </div>

                <div class="flex items-center gap-6">
                    <!-- Search Bar -->
                    @if(Route::currentRouteName() != 'teller.dashboard')
                    <form action="" method="GET" id="searchBarContainer" class="relative hidden md:block m-0 p-0">
                        <i class="ph ph-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-lg"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau rekening..." class="pl-10 pr-4 py-2 border border-gray-200 rounded-lg text-[13px] w-[260px] focus:outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue text-gray-700 placeholder-gray-400 transition-all">
                    </form>
                    @endif

                    <!-- Profile -->
                    <div class="flex items-center gap-3">
                        <i class="ph-fill ph-user-circle text-[42px] text-brand-blue"></i>
                        <div class="flex flex-col">
                            <p class="font-bold text-[15px] text-gray-800 leading-none mb-1">{{ $user->name }}</p>
                            <p class="text-[13px] text-gray-400 font-medium">{{ $user->email }}</p>
                        </div>
                    </div>
                </div>
            </header>

            @yield('content')
        </div>
    </main>

    <!-- Global Toast Notification -->
    <div id="toastAlert" class="fixed top-8 left-1/2 -translate-x-1/2 z-[110] hidden opacity-0 transform -translate-y-4 transition-all duration-300">
        <div class="bg-brand-blue text-white px-6 py-3.5 rounded-[18px] shadow-2xl flex items-center gap-3 border border-white/10 backdrop-blur-md">
            <div id="toastIcon" class="flex items-center justify-center w-6 h-6 rounded-full bg-green-500/20">
                <i class="ph-fill ph-check-circle text-green-400 text-xl"></i>
            </div>
            <span id="toastMessage" class="font-bold text-[14px] pr-2">Pesan berhasil disimpan!</span>
        </div>
    </div>

    <!-- Global Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/40 backdrop-blur-sm" onclick="closeDeleteModal()"></div>
        <div class="bg-white rounded-[28px] w-full max-w-[400px] p-8 shadow-2xl relative z-10 transform transition-all scale-95 opacity-0 duration-300" id="deleteModalContent">
            <div class="flex flex-col items-center text-center">
                <div class="w-20 h-20 rounded-full bg-red-50 flex items-center justify-center mb-6">
                    <i class="ph-fill ph-warning-circle text-[48px] text-red-500"></i>
                </div>
                <h3 class="text-[22px] font-bold text-gray-900 mb-2">Hapus Data?</h3>
                <p class="text-gray-500 text-[14px] leading-relaxed mb-8">
                    Apakah Anda yakin ingin menghapus data ini? Tindakan ini <span class="font-bold text-red-500">tidak dapat dibatalkan</span> dan data akan hilang permanen.
                </p>
                <div class="flex flex-col sm:flex-row gap-3 w-full">
                    <button onclick="closeDeleteModal()" class="flex-1 px-6 py-3.5 rounded-xl bg-gray-100 text-gray-700 font-bold text-[14px] hover:bg-gray-200 transition-colors">
                        Batal
                    </button>
                    <button id="btnConfirmDelete" class="flex-1 px-6 py-3.5 rounded-xl bg-red-500 text-white font-bold text-[14px] hover:bg-red-600 transition-colors shadow-lg shadow-red-500/30">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        // TOAST SYSTEM
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toastAlert');
            const toastMsg = document.getElementById('toastMessage');
            const toastIcon = document.getElementById('toastIcon');

            toastMsg.textContent = message;

            if (type === 'error') {
                toastIcon.innerHTML = '<i class="ph-fill ph-x-circle text-red-400 text-xl"></i>';
                toastIcon.classList.replace('bg-green-500/20', 'bg-red-500/20');
            } else {
                toastIcon.innerHTML = '<i class="ph-fill ph-check-circle text-green-400 text-xl"></i>';
                toastIcon.classList.replace('bg-red-500/20', 'bg-green-500/20');
            }

            toast.classList.remove('hidden');
            setTimeout(() => {
                toast.classList.replace('opacity-0', 'opacity-100');
                toast.classList.replace('-translate-y-4', 'translate-y-0');
            }, 10);

            setTimeout(() => {
                toast.classList.replace('opacity-100', 'opacity-0');
                toast.classList.replace('translate-y-0', '-translate-y-4');
                setTimeout(() => toast.classList.add('hidden'), 300);
            }, 3000);
        }

        // DELETE MODAL LOGIC
        function openDeleteModal(onConfirm, customMessage = null) {
            const modal = document.getElementById('deleteModal');
            const content = document.getElementById('deleteModalContent');
            const confirmBtn = document.getElementById('btnConfirmDelete');
            const desc = content.querySelector('p');

            if (desc) {
                if (customMessage) {
                    desc.innerHTML = customMessage;
                } else {
                    desc.innerHTML = 'Apakah Anda yakin ingin menghapus data ini? Tindakan ini <span class="font-bold text-red-500">tidak dapat dibatalkan</span> dan data akan hilang permanen.';
                }
            }

            modal.classList.replace('hidden', 'flex');

            // Trigger animation
            setTimeout(() => {
                content.classList.replace('scale-95', 'scale-100');
                content.classList.replace('opacity-0', 'opacity-100');
            }, 10);

            // Set action
            confirmBtn.onclick = () => {
                onConfirm();
                closeDeleteModal();
            };
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            const content = document.getElementById('deleteModalContent');

            content.classList.replace('scale-100', 'scale-95');
            content.classList.replace('opacity-100', 'opacity-0');

            setTimeout(() => {
                modal.classList.replace('flex', 'hidden');
            }, 300);
        }
    </script>
    @yield('scripts')
</body>

</html>
