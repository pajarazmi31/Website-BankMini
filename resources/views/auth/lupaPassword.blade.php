
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password | Bank Mini K-One</title>

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
                        'accent-yellow': '#eab308',
                    }
                }
            }
        }
    </script>

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="icon" href="{{ asset('img/bankmini2.png') }}" type="image/png">
</head>
<body class="font-sans antialiased text-gray-800 bg-gradient-merek min-h-screen flex items-center justify-center p-6 relative overflow-x-hidden">

    <!-- Glassmorphic Background Circles for aesthetic depth -->
    <div class="absolute w-[300px] h-[300px] rounded-full bg-blue-400 opacity-10 blur-3xl -top-10 -left-10 pointer-events-none"></div>
    <div class="absolute w-[400px] h-[400px] rounded-full bg-indigo-500 opacity-10 blur-3xl -bottom-20 -right-20 pointer-events-none"></div>

    <!-- Container Kartu -->
    <div class="w-full max-w-[420px] bg-white rounded-3xl shadow-2xl p-8 sm:p-10 relative z-10 transition-all duration-300 hover:shadow-blue-900/30">
        
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <div class="flex justify-center mb-4">
                <div class="w-16 h-16 rounded-2xl bg-slate-50 flex items-center justify-center p-2 shadow-sm border border-slate-100">
                    <img src="{{ asset('img/bankmini2.png') }}" alt="Logo Bank Mini K-One" class="w-full h-full object-contain">
                </div>
            </div>
            <h1 class="text-2xl font-bold text-primary-blue tracking-tight mb-2">Lupa Password?</h1>
            <p class="text-xs text-gray-400 leading-relaxed px-2">
                Jangan khawatir! Masukkan alamat email Anda di bawah ini dan kami akan mengirimkan tautan untuk mengatur ulang password Anda.
            </p>
        </div>

        <!-- Notification / Status Success -->
        @if(session('status'))
            <div class="mb-6 bg-emerald-50 border border-emerald-100 text-emerald-800 p-4 rounded-2xl text-xs flex gap-3 items-start">
                <svg class="w-5 h-5 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <span class="font-semibold block mb-0.5">Tautan Dikirim!</span>
                    {{ session('status') }}
                </div>
            </div>
        @endif

        <!-- Form Lupa Password -->
        <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Input Email -->
            <div>
                <label for="email" class="block text-gray-400 font-medium mb-2 text-[10px] uppercase tracking-wider">Alamat Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                    </span>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="contoh@domain.com"
                        required
                        class="w-full pl-11 pr-4 py-3 border @error('email') border-red-500 focus:ring-red-500 @else border-gray-200 focus:ring-primary-blue @enderror rounded-xl focus:outline-none focus:ring-2 focus:border-transparent transition-all duration-200 text-sm placeholder:text-gray-300"
                    >
                </div>
                @error('email')
                    <p class="text-red-500 text-[10px] mt-1.5 ml-1 uppercase font-semibold tracking-wide">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol Kirim -->
            <div class="pt-2">
                <button
                    type="submit"
                    class="btn-primary w-full bg-primary-blue hover:bg-[#143252] text-white font-semibold py-3.5 rounded-xl transition-all duration-200 shadow-md hover:shadow-lg active:scale-95 flex items-center justify-center gap-2 text-sm"
                >
                    <span>Kirim Tautan Reset</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </div>
        </form>

        <!-- Footer Back Link -->
        <div class="mt-8 text-center border-t border-gray-100 pt-6">
            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-primary-blue hover:text-[#143252] transition-colors group">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali ke Login</span>
            </a>
        </div>

    </div>

</body>
</html>

