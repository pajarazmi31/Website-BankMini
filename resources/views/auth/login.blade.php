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

</head>
<body class="font-sans antialiased text-gray-800 bg-white min-h-screen flex flex-col lg:flex-row overflow-x-hidden">

    <!-- Custom Message Box (Pengganti alert) -->
    <div id="messageBox" class="fixed top-5 left-1/2 transform -translate-x-1/2 z-50 hidden opacity-0 transition-opacity">
        <div class="bg-primary-blue text-white px-6 py-3 rounded-xl shadow-xl flex items-center gap-3">
            <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span id="messageText" class="font-medium">Pesan di sini</span>
        </div>
    </div>

    <!-- Sisi Kiri (Form Login) -->
    <div class="w-full lg:w-1/2 min-h-screen lg:min-h-0 flex items-center justify-center p-8 sm:p-12 lg:p-16 bg-white relative">
        <div class="w-full max-w-[360px]">
            
            <div class="flex justify-center mb-8">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('img/logosmk.png') }}" alt="Logo SMKN 1 Kawali" class="w-24 h-24 object-contain hover:scale-105 transition-transform">
                </a>
            </div>

            <h1 class="text-3xl lg:text-[32px] font-bold text-primary-blue mb-3 text-center tracking-tight">
                Masuk
            </h1>
            <p class="text-gray-500 text-center mb-8 text-sm">
                Untuk masuk ke akun anda, lengkapi form di bawah ini.
            </p>

            {{-- 
                CATATAN BACKEND: 
                - Form menggunakan method POST ke route('login').
                - Parameter input: 'email' dan 'password'.
            --}}
            <form id="loginForm" method="POST" action="{{ route('login') }}" class="space-y-6">
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
                    <input 
                        type="password" 
                        id="password" 
                        name="password"
                        required 
                        class="w-full px-4 py-2.5 border @error('password') border-red-500 @else border-gray-300 @enderror rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-blue focus:border-transparent transition-all duration-200 text-sm"
                    >
                    @error('password')
                        <p class="text-red-500 text-[10px] mt-1 ml-1 uppercase font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol Masuk -->
                <div class="pt-2">
                    <button 
                        type="submit" 
                        class="btn-primary w-full bg-primary-blue hover:bg-[#143252] text-white font-semibold py-3.5 rounded-xl transition-all duration-200 shadow-md hover:shadow-lg active:scale-95"
                    >
                        Masuk
                    </button>
                </div>
            </form>

        </div>
    </div>

    <!-- Sisi Kanan (Banner Halo) -->
    <div class="w-full lg:w-1/2 bg-gradient-merek lg:rounded-l-[4.5rem] flex items-center justify-center p-10 py-20 lg:p-16 relative overflow-hidden">


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

        // Fungsi untuk menampilkan pesan (menggantikan fungsi alert default browser)
        function showMessage(text) {
            clearTimeout(messageTimeout);
            
            messageText.textContent = text;
            messageBox.classList.remove('hidden', 'toast-leave');
            messageBox.classList.add('toast-enter');
            
            // Sembunyikan setelah 3 detik
            messageTimeout = setTimeout(() => {
                messageBox.classList.remove('toast-enter');
                messageBox.classList.add('toast-leave');
                
                // Hapus class hidden setelah animasi selesai
                setTimeout(() => {
                    messageBox.classList.add('hidden');
                }, 400); 
            }, 3000);
        }

        // ==========================================
        // SISTEM NOTIFIKASI BACKEND
        // ==========================================
        // Script ini otomatis menangkap pesan 'success' atau 'error' dari session.
        // Dapat dipicu via controller: return redirect()->back()->with('success', 'Isi Pesan');
        
        @if(session('success'))
            showMessage("{{ session('success') }}");
        @endif

        @if(session('error'))
            showMessage("{{ session('error') }}");
        @endif

        // Note: 
        // Event listener 'submit' dinonaktifkan agar form dapat diproses langsung oleh server.
        // Silakan sesuaikan jika ingin menggunakan AJAX.
        
        /*
        loginForm.addEventListener('submit', function(e) {
            // e.preventDefault(); 
        });
        */
    </script>
</body>
</html>