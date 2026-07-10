    @extends('layouts.supervisor')

@section('title','Supervisor Dashboard')
@section('header_title')
    Selamat Datang, {{ $user->name }}!
@endsection
@section('header_subtitle', 'Lorem Ipsum is simply dummy text of the printing.')

    @section('styles')
    <style>
        /* Fade animation */
        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
    @endsection

    @section('content')
    <div id="viewTabelData" class="fade-in flex flex-1 flex-col justify-start">
        <!-- Search Bar Mobile -->

        
        <!-- Section Title & Tabs -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-5 px-1 gap-4">
            <h3 class="text-[24px] font-bold text-gray-800">Pending Verifikasi</h3>
            
            <div class="flex bg-gray-100 p-1 rounded-xl w-full sm:w-[300px]">
                <a href="{{ route('supervisor.verifikasi.registrasi') }}" class="flex-1 px-4 py-2 text-gray-500 font-medium text-[13px] hover:text-brand-blue transition-colors text-center">Registrasi</a>
                <a href="{{ route('supervisor.verifikasi') }}" class="flex-1 px-4 py-2 bg-white rounded-lg shadow-sm text-brand-blue font-bold text-[13px] text-center transition-all">Transfer</a>
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-[20px] shadow-card p-6 w-full flex flex-col mb-5">
            <div class="flex justify-between items-center mb-1 border-b border-gray-50">
                    <form action="{{ route('supervisor.searchData') }}" method="get" class="flex gap-2 items-center">
                        <div class="relative">
                            <i class="ph ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-lg"></i>
                            <input type="text" placeholder="Cari data..."
                                value="{{ request('keyword') }}" name="keyword"
                                class="w-[250px] pl-12 pr-4 py-2 bg-white border border-gray-100 rounded-xl text-[14px] focus:outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue text-gray-700 placeholder-gray-400 shadow-sm transition-all">
                        </div>
                            
                        <button type="submit" class="px-3 py-1 bg-brand-blue text-white text-[14px] font-medium rounded-xl shadow-sm hover:opacity-90 transition-all">
                            <i class="ph ph-magnifying-glass text-lg"></i>
                        </button>
                    </form>
            @if ($bukti_tf->isNotEmpty())            
                <div class="relative inline-block text-left" id="filterDropdownContainer">
                    <button type="button" onclick="toggleFilterDropdown()" class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold px-4 py-2 rounded-xl transition">
                        <i class="ph-bold ph-sliders-horizontal"></i> Filter Tanggal Export
                    </button>

                    <div id="filterDropdownMenu" class="hidden absolute right-0 mt-2 w-72 origin-top-right rounded-2xl bg-white shadow-xl ring-1 ring-black ring-opacity-5 focus:outline-none p-4 z-50 border border-gray-100">
                        <form action="{{ route('supervisor.exportTransfer') }}" method="GET" class="space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 mb-1">Dari Tanggal</label>
                                <input type="date" name="start_date" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#1c3a5a]">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 mb-1">Sampai Tanggal</label>
                                <input type="date" name="end_date" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#1c3a5a]">
                            </div>
                            
                            <div class="border-t border-gray-100 pt-3 flex justify-end">
                                <button type="submit" class="w-full bg-[#059669] hover:bg-[#047857] text-white font-semibold text-xs py-2 rounded-lg flex items-center justify-center gap-2 transition">
                                    <i class="ph-bold ph-file-xls text-sm"></i> Unduh Excel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                @endif
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr>
                            <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] w-12 border-b border-gray-100">No</th>
                            <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">Nama Pengirim</th>
                            <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">Nama Penerima</th>
                            <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">Nominal Transfer</th>
                            <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">Nomor Telepon</th>
                            <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">Status</th>
                            <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] text-center w-[140px] border-b border-gray-100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-[14px] text-gray-800 font-medium">
                        @forelse ($bukti_tf as $item)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="py-4 px-2 border-b border-gray-50">{{ $loop->iteration }}</td>
                                        <td class="py-4 px-2 border-b border-gray-50">{{ $item->nama_pengirim }}</td>
                                        <td class="py-4 px-2 border-b border-gray-50">{{ $item->nama_penerima }}</td>
                                        <td class="py-4 px-2 border-b border-gray-50"> Rp{{ number_format($item->jumlah_transfer, 0, ',', '.') }}</td>
                                        <td class="py-4 px-2 border-b border-gray-50">{{ $item->no_hp_pengirim }}</td>
                                        @if ($item->status_verifikasi == 'pending')
                                        <td class="py-4 px-2 border-b border-gray-50">
                                            <span class="w-7 h-7 rounded-full bg-yellow-100 text-yellow-800 text-brand-blue flex items-center justify-center transition-colors shadow-sm">
                                                <i class="ph ph-clock text-[20px]"  title="Pending"></i> 
                                            </span>
                                        </td>
                                        @elseif($item->status_verifikasi == 'berhasil')
                                        <td class="py-4 px-2 border-b border-gray-50">
                                            <span class="w-7 h-7 rounded-full bg-green-100 text-green-800 text-brand-blue flex items-center justify-center transition-colors shadow-sm">
                                                <i class="ph ph-check-circle text-[20px]"  title="Berhasil"></i>
                                            </span>
                                        </td>
                                        @else
                                        <td class="py-4 px-2 border-b border-gray-50">
                                            <span class="w-7 h-7 rounded-full bg-red-100 text-red-800 text-brand-blue flex items-center justify-center transition-colors shadow-sm">
                                                <i class="ph ph-x-circle text-[20px]"  title="Tolak"></i>
                                            </span>
                                        </td>
                                        @endif
                                        <td class="py-4 px-2 border-b border-gray-50">
                                            <div class="flex items-center justify-center gap-2">
                                                <!-- Tombol Lihat (Mata) memanggil view Form -->
                                                <button onclick="viewDetail('{{ $item->nama_pengirim }}', '{{ $item->nama_penerima }}', 'Rp{{ number_format($item->jumlah_transfer, 0, ',', '.')}}', '{{ $item->id_rekening }}','Rp{{number_format($item->nominal_admin,0, ',', '.') }}', '{{ $item->no_hp_pengirim }}' ,  '{{ $item->catatan }}', '{{ $item->datetime_tgl }}', '{{ asset('storage/' . $item->bukti_foto) }}' )" class="w-[30px] h-[30px] rounded-full bg-[#e2e8f0] text-brand-blue flex items-center justify-center hover:bg-gray-300 transition-colors" title="Lihat Detail"><i class="ph-fill ph-eye text-[16px]"></i></button>
                                                
                                                <!-- 
                                                    BAGIAN BACKEND: AKSI VERIFIKASI (SETUJUI / TOLAK)
                                                    - Tombol Setujui dan Tolak di bawah idealnya diubah menjadi <form> dengan method POST/PUT 
                                                    yang mengirim status verifikasi ke controller, atau menggunakan request AJAX.
                                                -->
                                                @if($item->status_verifikasi == 'pending')
                                                        <!-- Tombol Aksi Hanya Muncul Jika Status Masih Pending -->
                                                        <form action="{{ route('supervisor.verifikasiTf', $item->id) }}" method="POST" class="inline" onsubmit="alert('Data Berhasil Diubah')">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status_verifikasi" value="berhasil">
                                                            <button onclick="return confirm('Apakah Anda yakin ingin menyetujui transaksi ini?')" type="submit" class="w-[30px] h-[30px] rounded-full bg-[#d1fae5] text-[#10a163] flex items-center justify-center hover:bg-green-200 transition-colors" title="Setujui">
                                                                <i class="ph-bold ph-check-circle text-[16px]"></i>
                                                            </button>
                                                        </form>

                                                        <form action="{{ route('supervisor.verifikasiTf', $item->id) }}" method="POST" class="inline" onsubmit="alert('Data Berhasil Diubah')">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status_verifikasi" value="gagal">
                                                            <button onclick="return confirm('Apakah Anda yakin ingin membatalkan transaksi ini?')" type="submit" class="w-[30px] h-[30px] rounded-full bg-[#fee2e2] text-red-500 flex items-center justify-center hover:bg-red-200 transition-colors" title="Tolak">
                                                                <i class="ph-bold ph-x-circle text-[16px]"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <!-- Tampilkan indikator bahwa aksi sudah terkunci -->
                                                        <span class="text-[9px] text-gray-400 font-italic">
                                                            <i class="ph ph-lock"></i> Telah Diverifikasi
                                                        </span>
                                                    @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty 
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="py-4 px-2 border-b text-gray-500 border-gray-50" colspan="7">Maaf Data Kosong</td>
                                    </tr>
                                    @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <x-pagination total="3" />

        </div>
    </div>

    <!-- ================= CRUD VIEWS (Separated Files) ================= -->
    @include('supervisor.verifikasi.transfer.detail')
    @endsection

    @section('scripts')
    <script>
        // Lihat Detail
        function viewDetail(pengirim, penerima, nominal, rek, admin, telp, catatan,  tgl_pengirim, bukti) {
            document.getElementById('detail_pengirim').value = pengirim;
            document.getElementById('detail_penerima').value = penerima;
            document.getElementById('detail_nominal').value = nominal;
            document.getElementById('detail_rek_penerima').value = rek;
            document.getElementById('detail_telepon').value = telp;
            document.getElementById('detail_admin').value = admin;
            
            // Dummy data untuk field tambahan
            document.getElementById('detail_tanggal').value = tgl_pengirim;
            document.getElementById('detail_catatan').value = catatan;
            // --- BAGIAN PERUBAHAN UNTUK BUKTI TRANSFER ---
                const placeholder = document.getElementById('detail_bukti_container');
                const contentTag = document.getElementById('detail_bukti_content'); // ID baru dari tag <object>

                // 1. Reset state awal agar bersih
                placeholder.classList.add('hidden');
                contentTag.classList.add('hidden');
                contentTag.removeAttribute('data');
                contentTag.removeAttribute('type');

                // 2. Cek apakah link bukti ada atau kosong dari database
                if (bukti) {
                    // Ambil ekstensi filenya (PDF atau gambar) dari variabel 'bukti'
                    const ekstensi = bukti.split('.').pop().toLowerCase();

                    if (ekstensi === 'pdf') {
                        contentTag.setAttribute('data', bukti);
                        contentTag.setAttribute('type', 'application/pdf');
                    } else {
                        contentTag.setAttribute('data', bukti);
                        contentTag.setAttribute('type', 'image/jpeg'); // Standar untuk semua tipe gambar
                    }

                    // Tampilkan tag object
                    contentTag.classList.remove('hidden');
                } else {
                    // Jika dari database tidak ada file bukti, munculkan teks placeholder
                    placeholder.classList.remove('hidden');
                }
                // ---------------------------------------------
                
                switchView('detail');
        }

        // Pindah antara Tabel Data dan Detail
        function switchView(viewName) {
            const views = {
                'tabel': document.getElementById('viewTabelData'),
                'detail': document.getElementById('viewDetailData')
            };

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
                } else {
                    activeView.classList.add('block');
                }
            }
            
            document.querySelector('main').scrollTo({ top: 0, behavior: 'smooth' });
        }

    function toggleFilterDropdown() {
        const menu = document.getElementById('filterDropdownMenu');
        menu.classList.toggle('hidden');
    }

    // Menutup dropdown jika user klik di luar area filter
    window.addEventListener('click', function(e) {
        const menu = document.getElementById('filterDropdownMenu');
        const container = document.getElementById('filterDropdownContainer');
        if (!container.contains(e.target)) {
            menu.classList.add('hidden');
        }
    });
    </script>
    @endsection
