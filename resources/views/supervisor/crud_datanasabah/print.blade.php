<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> </title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body {
                background: white;
                color: black;
                font-size: 11px;
            }
            @page {
                size: A4;
                margin: 0; /* Hides default browser header (title, date) and footer (URL, page numbers) */
            }
            .print-container {
                padding: 1.2cm 1.5cm;
            }
            /* Menghindari halaman terbelah */
            .page-break-avoid {
                page-break-inside: avoid;
            }
        }
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f3f4f6;
        }
    </style>
</head>
<body class="bg-gray-100 py-4 print:py-0 print:bg-white text-slate-800">

    <!-- Container Utama -->
    <div class="print-container max-w-[800px] mx-auto bg-white p-6 print:p-0 shadow-md print:shadow-none rounded-xl print:rounded-none">
        
        <!-- Kop Surat -->
        <div class="flex items-center justify-between pb-3 border-b-2 border-slate-800 mb-4">
            <div class="w-14 h-14 shrink-0 flex items-center justify-center">
                <img src="{{ asset('img/logosmk.png') }}" alt="Logo SMK" class="w-full h-full object-contain">
            </div>
            <div class="text-center flex-1 px-4">
                <h1 class="text-lg font-extrabold tracking-wide text-slate-900 leading-tight">BANK MINI K-ONE</h1>
                <h2 class="text-xs font-bold text-slate-800 leading-normal">SMK NEGERI 1 KAWALI</h2>
                <p class="text-[9px] text-slate-500 italic mt-0.5">Jalan Raya Kawali No. 65, Ciamis, Jawa Barat | Kode Pos: 46253</p>
                <p class="text-[8px] text-slate-400">Telp: (0265) 791707 | Email: bankmini.kone@smkn1kawali.sch.id</p>
            </div>
            <div class="w-14 h-14 shrink-0 flex items-center justify-center">
                <img src="{{ asset('img/bankmini2.png') }}" alt="Logo Bank Mini" class="w-full h-full object-contain">
            </div>
        </div>

        <!-- Judul Dokumen -->
        <div class="text-center mb-5">
            <h3 class="text-sm font-extrabold uppercase tracking-widest text-slate-900 border-b border-slate-200 inline-block pb-0.5">FORMULIR DATA PROFIL NASABAH</h3>
            <p class="text-[11px] text-slate-400 mt-1">Nomor Rekening: <span class="font-bold text-slate-800 text-xs tracking-wider">{{ $nasabah->rekening->id ?? '-' }}</span></p>
        </div>

        <!-- Blok Data Nasabah -->
        <div class="space-y-4 text-[11px] text-slate-700">
            <!-- 1. Informasi Akun & Pekerjaan -->
            <div class="page-break-avoid">
                <h4 class="font-bold text-slate-900 border-b border-slate-100 pb-1 mb-2 uppercase tracking-wider text-[10px] flex items-center gap-1.5">
                    <span class="w-1 h-2.5 bg-blue-600 rounded-sm"></span> Informasi Akun & Kepegawaian
                </h4>
                <div class="grid grid-cols-2 gap-x-6 gap-y-1.5">
                    <div class="flex border-b border-slate-50 pb-1">
                        <span class="w-28 font-semibold text-slate-500">No. Rekening</span>
                        <span class="font-bold text-slate-900">: {{ $nasabah->rekening->id ?? 'Belum dibuat' }}</span>
                    </div>
                    <div class="flex border-b border-slate-50 pb-1">
                        <span class="w-28 font-semibold text-slate-500">Status Akun</span>
                        <span class="font-bold uppercase text-slate-900 text-[10px]">: {{ $nasabah->rekening->status_akun ?? 'Menunggu Verifikasi' }}</span>
                    </div>
                    <div class="flex border-b border-slate-50 pb-1">
                        <span class="w-28 font-semibold text-slate-500">NIS / NIP</span>
                        <span class="text-slate-900">: {{ $nasabah->nis_nip }}</span>
                    </div>
                    <div class="flex border-b border-slate-50 pb-1">
                        <span class="w-28 font-semibold text-slate-500">Jabatan / Status</span>
                        <span class="text-slate-900">: {{ $nasabah->jabatan }}</span>
                    </div>
                    <div class="flex border-b border-slate-50 pb-1">
                        <span class="w-28 font-semibold text-slate-500">Pendidikan</span>
                        <span class="text-slate-900">: {{ $nasabah->pendidikan }}</span>
                    </div>
                    <div class="flex border-b border-slate-50 pb-1">
                        <span class="w-28 font-semibold text-slate-500">Jurusan</span>
                        <span class="text-slate-900">: {{ $nasabah->jurusan->nama_jurusan ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- 2. Informasi Pribadi -->
            <div class="page-break-avoid">
                <h4 class="font-bold text-slate-900 border-b border-slate-100 pb-1 mb-2 uppercase tracking-wider text-[10px] flex items-center gap-1.5">
                    <span class="w-1 h-2.5 bg-blue-600 rounded-sm"></span> Data Pribadi Nasabah
                </h4>
                <div class="grid grid-cols-2 gap-x-6 gap-y-1.5">
                    <div class="flex border-b border-slate-50 pb-1 col-span-2">
                        <span class="w-28 font-semibold text-slate-500">Nama Lengkap</span>
                        <span class="font-bold text-slate-900">: {{ $nasabah->nama_nasabah }}</span>
                    </div>
                    <div class="flex border-b border-slate-50 pb-1">
                        <span class="w-28 font-semibold text-slate-500">Tempat, Tgl Lahir</span>
                        <span class="text-slate-900">: {{ $nasabah->tempat_lahir }}, {{ $nasabah->tanggal_lahir }}</span>
                    </div>
                    <div class="flex border-b border-slate-50 pb-1">
                        <span class="w-28 font-semibold text-slate-500">Jenis Kelamin</span>
                        <span class="text-slate-900">: {{ $nasabah->jenis_kelamin }}</span>
                    </div>
                    <div class="flex border-b border-slate-50 pb-1">
                        <span class="w-28 font-semibold text-slate-500">Agama</span>
                        <span class="text-slate-900">: {{ $nasabah->agama }}</span>
                    </div>
                    <div class="flex border-b border-slate-50 pb-1">
                        <span class="w-28 font-semibold text-slate-500">Jenis Identitas</span>
                        <span class="text-slate-900">: {{ $nasabah->jenis_identitas }}</span>
                    </div>
                    <div class="flex border-b border-slate-50 pb-1">
                        <span class="w-28 font-semibold text-slate-500">No. Telepon / HP</span>
                        <span class="text-slate-900">: {{ $nasabah->no_hp }}</span>
                    </div>
                    <div class="flex border-b border-slate-50 pb-1">
                        <span class="w-28 font-semibold text-slate-500">Alamat Email</span>
                        <span class="text-slate-900">: {{ $nasabah->email }}</span>
                    </div>
                    <div class="flex border-b border-slate-50 pb-1 col-span-2">
                        <span class="w-28 font-semibold text-slate-500">Alamat Lengkap</span>
                        <span class="text-slate-900 leading-normal">: {{ $nasabah->alamat }}</span>
                    </div>
                    <div class="flex border-b border-slate-50 pb-1 col-span-2">
                        <span class="w-28 font-semibold text-slate-500">Wilayah</span>
                        <span class="text-slate-900">: Kel. {{ $nasabah->desa->name ?? '-' }}, Kec. {{ $nasabah->kecamatan->name ?? '-' }}, {{ $nasabah->kabupaten->name ?? '-' }}, {{ $nasabah->provinsi->name ?? '-' }} ({{ $nasabah->kode_pos }})</span>
                    </div>
                </div>
            </div>

            <!-- 3. Informasi Kontak Darurat -->
            <div class="page-break-avoid">
                <h4 class="font-bold text-slate-900 border-b border-slate-100 pb-1 mb-2 uppercase tracking-wider text-[10px] flex items-center gap-1.5">
                    <span class="w-1 h-2.5 bg-blue-600 rounded-sm"></span> Kontak Darurat (Emergency Contact)
                </h4>
                <div class="grid grid-cols-2 gap-x-6 gap-y-1.5">
                    <div class="flex border-b border-slate-50 pb-1">
                        <span class="w-28 font-semibold text-slate-500">Nama Kontak</span>
                        <span class="font-bold text-slate-900">: {{ $nasabah->nama_kontak_darurat }}</span>
                    </div>
                    <div class="flex border-b border-slate-50 pb-1">
                        <span class="w-28 font-semibold text-slate-500">Hubungan</span>
                        <span class="text-slate-900">: {{ $nasabah->hubungan_kontak_darurat }}</span>
                    </div>
                    <div class="flex border-b border-slate-50 pb-1 col-span-2">
                        <span class="w-28 font-semibold text-slate-500">No. Telepon HP</span>
                        <span class="text-slate-900">: {{ $nasabah->no_hp_kontak_darurat }}</span>
                    </div>
                    <div class="flex border-b border-slate-50 pb-1 col-span-2">
                        <span class="w-28 font-semibold text-slate-500">Alamat Kontak</span>
                        <span class="text-slate-900 leading-normal">: {{ $nasabah->alamat_kontak_darurat }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tanda Tangan -->
        <div class="mt-8 grid grid-cols-2 gap-6 text-center text-[11px] text-slate-700 page-break-avoid">
            <div>
                <p class="mb-10">Nasabah,</p>
                <p class="font-bold underline text-slate-900">{{ $nasabah->nama_nasabah }}</p>
                <p class="text-[9px] text-slate-400">Tanda Tangan & Nama Terang</p>
            </div>
            <div>
                <p class="text-slate-500 font-normal mb-1">Ciamis, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }} {{ \Carbon\Carbon::now()->format('H.i') }}</p>
                <p class="mb-10">Petugas Supervisor,</p>
                <p class="font-bold underline text-slate-900">{{ auth()->user()->name }}</p>
                <p class="text-[9px] text-slate-400">Nama Lengkap & Paraf</p>
            </div>
        </div>

    </div>

    <!-- Pemicu Cetak Otomatis di Browser -->
    <script>
        window.onload = function() {
            setTimeout(() => {
                window.print();
            }, 300);
        }
        
        window.onafterprint = function() {
            window.location.href = "{{ route('supervisor.datanasabah') }}";
        }
    </script>
</body>
</html>
