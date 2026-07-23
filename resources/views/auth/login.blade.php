<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Bank Mini</title>

    <!-- Import Google Fonts (Poppins) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Tailwind Config for Custom Colors & Fonts -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    backgroundImage: {
                        'gradient-merek': 'linear-gradient(to right, #143657, #1E5081, #143657)',
                    },
                    colors: {
                        'primary-blue': '#1c4e80',
                        'accent-yellow': '#eab308', /* Warna kuning untuk teks 'menggunakan' */
                    }
                }
            }
        }
    </script>

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="icon" href="{{ asset('img/Logo Bank Mini K-one.jpeg') }}" type="image/jpeg">
</head>
<body class="font-sans antialiased text-gray-800 bg-white min-h-screen flex flex-col lg:flex-row overflow-x-hidden">

    <!-- Custom Message Box (Pengganti alert) -->
    <div id="messageBox" class="fixed top-6 left-1/2 transform -translate-x-1/2 z-50 hidden opacity-0 transition-all duration-300 translate-y-2">
        <div id="messageBg" class="bg-white text-gray-800 px-5 py-4 rounded-2xl shadow-[0_10px_30px_rgba(0,0,0,0.08)] flex items-center gap-3.5 border border-gray-100/80 min-w-[320px] max-w-[420px]">
            <div id="messageIcon" class="flex items-center justify-center w-10 h-10 rounded-xl">
                <!-- Icon dynamically set -->
            </div>
            <div class="flex-1 flex flex-col text-left">
                <span id="messageTitle" class="font-semibold text-sm text-gray-900 leading-tight">Berhasil</span>
                <span id="messageText" class="text-xs text-gray-500 font-medium mt-0.5">Pesan di sini</span>
            </div>
            <button type="button" onclick="closeMessage()" class="text-gray-400 hover:text-gray-600 transition-colors ml-2 focus:outline-none">
                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    </div>

    <!-- Sisi Kiri (Form Login) -->
    <div class="w-full lg:w-1/2 min-h-screen flex items-center justify-center p-6 sm:p-12 lg:p-16 bg-white relative">
        <div class="w-full max-w-[360px] py-6">
            <!-- Logo Section for Mobile/Desktop Branding -->
            <div class="flex flex-col items-center mb-6 lg:mb-8">
                <img src="{{ asset('img/bankmini2.png') }}" alt="Logo Bank Mini" class="w-16 h-16 lg:w-20 lg:h-20 object-contain mb-3 drop-shadow-sm">
                <span class="text-[10px] lg:text-xs font-bold text-gray-400 tracking-widest uppercase">Bank Mini K-One</span>
            </div>

            <h1 class="text-2xl lg:text-[28px] font-bold text-primary-blue mb-2 text-center tracking-tight">
                Masuk ke Akun
            </h1>
            <p class="text-gray-400 text-center mb-8 text-xs lg:text-sm">
                Silakan isi formulir di bawah ini untuk masuk.
            </p>

            {{--
                CATATAN BACKEND:
                - Form menggunakan method POST ke route('login').
                - Parameter input: 'email' dan 'password'.
            --}}
            <form id="loginForm" method="post" action="{{ route('login') }}" class="space-y-6">
                @csrf
                <!-- Input Email -->
                <div>
                    <label for="email" class="block text-gray-500 font-medium mb-1.5 text-xs uppercase tracking-wider">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        class="w-full px-4 py-2.5 border @error('email') border-red-500 @else border-gray-300 @enderror rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-blue focus:border-transparent transition-all duration-200 text-sm"
                    >
                    @error('email')
                        <p class="text-red-500 text-[10px] mt-1 ml-1 uppercase font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input Password -->
                <div>
                    <label for="password" class="block text-gray-500 font-medium mb-1.5 text-xs uppercase tracking-wider">Password</label>
                    <div class="relative">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                            class="w-full pl-4 pr-10 py-2.5 border @error('password') border-red-500 @else border-gray-300 @enderror rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-blue focus:border-transparent transition-all duration-200 text-sm"
                        >
                        <button
                            type="button"
                            id="togglePassword"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-primary-blue transition-colors focus:outline-none"
                        >
                            <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-[10px] mt-1 ml-1 uppercase font-semibold">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex items-center justify-end">
                    <a href="{{ route('password.request') }}" class="text-xs font-semibold text-primary-blue hover:text-[#143252] transition-colors">
                        Lupa Password?
                    </a>
                </div>

                <!-- Tombol Masuk -->
                <div class="pt-2">
                    <button
                        type="submit"
                        class="btn-primary w-full bg-primary-blue hover:bg-[#143252] text-white font-semibold py-3.5 rounded-xl transition-all duration-200 shadow-md hover:shadow-lg active:scale-95">
                        Masuk
                    </button>
                </div>
            </form>

        </div>
    </div>

    <!-- Sisi Kanan (Banner Halo) - Tersembunyi di Mobile -->
    <div class="hidden lg:flex w-full lg:w-1/2 bg-gradient-merek lg:rounded-l-[4.5rem] items-center justify-center p-10 py-10 lg:p-16 relative overflow-hidden">


        <div class="text-center text-white max-w-[460px] z-10">

            <h2 class="text-4xl lg:text-5xl font-bold mb-4 tracking-wide">
                Halo!
            </h2>

            <p class="text-base lg:text-lg leading-relaxed mb-8 text-gray-100">
                Selamat datang kembali di <span class="text-accent-yellow font-semibold">Bank Mini</span> SMKN 1 Kawali. Silakan masuk untuk mengakses layanan perbankan sekolah Anda.
            </p>

        </div>
    </div>

    <!-- JavaScript Logic -->
    <script>
        // Mengambil elemen-elemen DOM
        const loginForm = document.getElementById('loginForm');
        const messageBox = document.getElementById('messageBox');
        const messageText = document.getElementById('messageText');
        let messageTimeout;

        // Toggle Password Visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            if (type === 'password') {
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                `;
            } else {
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                `;
            }
        });

        // Fungsi untuk menampilkan pesan (menggantikan fungsi alert default browser)
        function showMessage(text, type = 'success') {
            clearTimeout(messageTimeout);

            const messageBox = document.getElementById('messageBox');
            const messageBg = document.getElementById('messageBg');
            const messageTitle = document.getElementById('messageTitle');
            const messageIcon = document.getElementById('messageIcon');
            const messageText = document.getElementById('messageText');

            messageText.textContent = text;

            if (type === 'error' || type === 'failed') {
                messageTitle.textContent = 'Gagal';
                messageTitle.className = 'font-semibold text-sm text-red-600 leading-tight';
                messageIcon.className = 'flex items-center justify-center w-10 h-10 rounded-xl bg-red-50 text-red-500';
                messageIcon.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`;
                messageBg.className = 'bg-white text-gray-800 px-5 py-4 rounded-2xl shadow-[0_10px_30px_rgba(0,0,0,0.08)] flex items-center gap-3.5 border border-red-100/50 min-w-[320px] max-w-[420px]';
            } else {
                messageTitle.textContent = 'Berhasil';
                messageTitle.className = 'font-semibold text-sm text-emerald-600 leading-tight';
                messageIcon.className = 'flex items-center justify-center w-10 h-10 rounded-xl bg-emerald-50 text-emerald-500';
                messageIcon.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`;
                messageBg.className = 'bg-white text-gray-800 px-5 py-4 rounded-2xl shadow-[0_10px_30px_rgba(0,0,0,0.08)] flex items-center gap-3.5 border border-emerald-100/50 min-w-[320px] max-w-[420px]';
            }

            messageBox.classList.remove('hidden');
            setTimeout(() => {
                messageBox.classList.remove('opacity-0', 'translate-y-2');
                messageBox.classList.add('opacity-100', 'translate-y-0');
            }, 10);

            // Sembunyikan setelah 4 detik
            messageTimeout = setTimeout(closeMessage, 4000);
        }

        function closeMessage() {
            const messageBox = document.getElementById('messageBox');
            if (!messageBox) return;
            messageBox.classList.remove('opacity-100', 'translate-y-0');
            messageBox.classList.add('opacity-0', 'translate-y-2');
            setTimeout(() => {
                messageBox.classList.add('hidden');
            }, 300);
            if (messageTimeout) {
                clearTimeout(messageTimeout);
            }
        }

        // ==========================================
        // SISTEM NOTIFIKASI BACKEND
        // ==========================================
        // Script ini otomatis menangkap pesan 'success', 'failed', atau 'error' dari session.

        @if(session('success'))
            showMessage("{{ session('success') }}", 'success');
        @endif

        @if(session('failed'))
            showMessage("{{ session('failed') }}", 'error');
        @endif

        @if(session('error'))
            showMessage("{{ session('error') }}", 'error');
        @endif

        // Ambil query parameter error (misal dialihkan dari halaman verifikasi)
        const urlParams = new URLSearchParams(window.location.search);
        const errorParam = urlParams.get('error');
        if (errorParam) {
            showMessage(errorParam, 'error');
            // Bersihkan parameter query dari URL
            window.history.replaceState({}, document.title, window.location.pathname);
        }

    </script>
</body>
</html>
