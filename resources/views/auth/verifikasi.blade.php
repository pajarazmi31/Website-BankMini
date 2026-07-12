<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Login</title>

    <!-- Import Google Fonts (Poppins) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-[#FDFDFD] min-h-screen flex items-center justify-center"
    style="font-family: 'Poppins', sans-serif;">

    <div class="text-center">

        <!-- Icon -->
        <div class="mb-6">
            <div class="w-24 h-24 mx-auto rounded-full bg-white shadow-[0px_0px_30px_0px_rgb(0_0_0_/_10%)] flex items-center justify-center">
                <i class="bi bi-hourglass-split text-[#C98A00] text-[28px]"></i>
            </div>
        </div>

        <!-- Judul -->
        <h1 class="text-[26px] font-semibold text-black">
            Menunggu Persetujuan Supervisor
        </h1>

        <!-- Deskripsi -->
        <p class="mt-4 text-[14px] text-gray-400">
            Permintaan login Anda telah dikirim dan sedang menunggu persetujuan supervisor.
        </p>

        <!-- Tombol -->
        <div class="mt-8">
            <a href="{{ route('login') }}"
                class="inline-flex items-center justify-center
                       w-[165px] h-[36px]
                       border border-gray-500
                       rounded-[10px]
                       bg-white
                       text-gray-600
                       font-medium
                       text-[14px]
                       hover:bg-gray-50
                       transition">
                Kembali
            </a>
        </div>

    </div>
    <script>
        const verifikasiId = "{{ session('verifikasi_login_id') }}";

        setInterval(() => {

            fetch(`/cek-verifikasi-login/${verifikasiId}`)
                .then(response => response.json())
                .then(data => {

                    if (data.status === 'approved') {

                        if (data.role === 'teller') {
                            window.location.href = "{{ route('teller.dashboard') }}";
                        }

                        if (data.role === 'customerservice') {
                            window.location.href = "{{ route('cs.dashboard') }}";
                        }
                    }

                    if (data.status === 'ditolak') {
                        alert('Permintaan login ditolak supervisor');
                        window.location.href = "{{ route('login') }}";
                    }

                });

        }, 3000);
    </script>
</body>

</html>