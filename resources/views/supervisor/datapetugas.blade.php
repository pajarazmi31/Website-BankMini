    @extends('layouts.supervisor')

    @section('title','Supervisor Dashboard')
    @section('header_title')
    Selamat Datang, {{ $user->name }}!
    @endsection
    @section('header_subtitle', 'Lorem Ipsum is simply dummy text of the printing.')

    @section('styles')
    <style>
        /* Animasi transisi antar view */
        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    @endsection

    @section('content')

    @if ($errors->any())
    <div style="color: red; background: #f8d7da; padding: 10px; margin-bottom: 10px;">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <!-- ================= VIEW 1: TABEL DATA PETUGAS ================= -->
    <div id="viewTabelData" class="fade-in flex flex-1 flex-col justify-start">
        <!-- Search Bar Mobile -->
        <div class="md:hidden relative mb-5">
            <i class="ph ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-lg"></i>
            <input type="text" placeholder="Cari data..." class="w-full pl-12 pr-4 py-3.5 bg-white border border-gray-100 rounded-2xl text-[14px] focus:outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue text-gray-700 placeholder-gray-400 shadow-sm transition-all">
        </div>


        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-4 px-1">
            <div>
                <h3 class="text-[20px] md:text-[22px] font-bold text-gray-800">Data Petugas</h3>
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-3 w-full lg:w-auto">
                <form action="{{ route('datapetugas.import') }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-2 w-full sm:w-auto bg-gray-50 p-1.5 rounded-[12px] border border-gray-200">
                    @csrf
                    <input type="file" name="file_excel" required class="text-[12px] text-gray-500 file:mr-3 file:py-1 file:px-2 file:rounded-[8px] file:border-0 file:text-[12px] file:font-semibold file:bg-blue-50 file:text-brand-blue hover:file:bg-blue-100 cursor-pointer max-w-[180px]">
                    <button type="submit" class="bg-emerald-600 text-white px-3 py-1.5 rounded-[8px] text-[12px] font-bold flex items-center gap-1.5 hover:bg-emerald-700 transition-all shadow-sm">
                        <i class="ph ph-file-arrow-up text-base"></i> Import
                    </button>
                </form>

                <a href="{{ route('datapetugas.download-template') }}" class="border border-gray-300 text-gray-700 bg-white px-3 py-2 rounded-[10px] text-[13px] font-bold flex items-center gap-2 hover:bg-gray-50 transition-all shadow-sm w-full sm:w-auto justify-center text-center">
                    <i class="ph ph-download text-base"></i> Template
                </a>

                <button onclick="switchView('tambah')" class="bg-gradient-to-r from-[#143657] to-[#316392] text-white px-3 py-2 rounded-[10px] text-[13px] font-bold flex items-center gap-2 hover:opacity-90 transition-all shadow-md w-full sm:w-auto justify-center">
                    <i class="ph ph-plus text-base"></i> Tambah Data
                </button>
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-[20px] shadow-card p-6 w-full flex flex-col">
            <div class="flex items-center gap-2 mb-4">
                <span class="text-[13px] text-gray-600 font-medium">Tampilkan:</span>
                <select onchange="changePerPage(this.value)" class="bg-white border border-gray-200 text-gray-700 text-[13px] rounded-[10px] px-3 py-1.5 font-semibold focus:outline-none focus:border-brand-blue shadow-sm cursor-pointer">
                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10 data</option>
                    <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20 data</option>
                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50 data</option>
                    <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100 data</option>
                </select>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                        <tr>
                            <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] w-16 border-b border-gray-100 pl-4">No</th>
                            <th class="py-4 px-4 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">Nama Petugas</th>
                            <th class="py-4 px-4 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">Kelas </th>
                            <th class="py-4 px-4 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100 hidden md:table-cell">Email</th>
                            <th class="py-4 px-4 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">Role</th>
                            <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] text-center w-36 border-b border-gray-100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-[14px] text-gray-800 font-medium">
                        @foreach($petugas as $index => $p)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="py-4 px-2 border-b border-gray-50 text-gray-600 pl-4">
                                {{ $petugas->firstItem() + $index }}.
                            </td>
                            <td class="py-4 px-4 border-b border-gray-50 text-gray-700 font-medium">{{ $p->user->name }}</td>
                            <td class="py-4 px-4 border-b border-gray-50 text-gray-700 font-medium">{{ $p->kelas }}</td>
                            <td class="py-4 px-4 border-b border-gray-50 hidden md:table-cell text-gray-700 font-medium">{{ $p->user->email }}</td>
                            <td class="py-4 px-4 border-b border-gray-50 text-gray-700 font-medium">{{ $p->user->role->nama_role }}</td>
                            <td class="py-4 px-2 border-b border-gray-50">
                                <div class="flex items-center justify-center gap-3">
                                    <button onclick="viewDetail('{{ $p->user->name }}','{{ $p->kelas }}', '{{ $p->user->email }}', '{{ $p->user->role->nama_role }}')" class="w-[28px] h-[28px] rounded-full bg-[#f1f5f9] text-[#1c3a5a] flex items-center justify-center hover:bg-gray-200 transition-colors" title="Lihat Detail"><i class="ph-fill ph-eye text-[15px]"></i></button>
                                    <button onclick="viewEdit(
                                        '{{ $p->id }}',
                                        '{{ $p->user->name }}',
                                        '{{ $p->kelas }}',
                                        '{{ $p->user->email }}',
                                        '{{ $p->user->role_id }}')" class="w-[28px] h-[28px] rounded-full bg-[#dcfce7] text-[#16a34a] flex items-center justify-center hover:bg-green-200 transition-colors" title="Edit Data"><i class="ph-fill ph-pencil-simple text-[15px]"></i></button>
                                    <button onclick="openDeleteModal(() => hapusPetugas('{{ $p->id }}'))" class="w-[28px] h-[28px] rounded-full bg-[#fee2e2] text-[#ef4444] flex items-center justify-center hover:bg-red-200 transition-colors" title="Hapus Data"><i class="ph-fill ph-trash text-[15px]"></i></button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <x-pagination :paginator="$petugas" />

        </div>
    </div>

    <!-- ================= CRUD VIEWS (Separated Files) ================= -->
    @include('supervisor.crud_datapetugas.tambah')
    @include('supervisor.crud_datapetugas.edit')
    @include('supervisor.crud_datapetugas.detail')

    <form id="formDeletePetugas" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    @endsection

    @section('scripts')
    <script>
        // Lihat Detail
        function viewDetail(nama, kelas, email, role) {
            document.getElementById('detail_nama').value = nama;
            document.getElementById('detail_kelas').value = kelas;
            document.getElementById('detail_email').value = email;
            document.getElementById('detail_role_text').value = role;

            switchView('detail');
        }

        // Edit Data
        function viewEdit(id, nama, kelas, email, roleId) {

            // ambil form
            const form = document.getElementById('formEditPetugas');

            // set action form
            form.action = `/datapetugas/update/${id}`;

            // isi input
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_kelas').value = kelas;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_role').value = roleId;

            // tampilkan view edit
            switchView('edit');
        }

        function switchView(viewName) {
            const views = {
                'tabel': document.getElementById('viewTabelData'),
                'tambah': document.getElementById('viewTambahData'),
                'edit': document.getElementById('viewEditData'),
                'detail': document.getElementById('viewDetailData')
            };

            Object.values(views).forEach(v => {
                if (v) {
                    v.classList.add('hidden');
                    v.classList.remove('flex', 'block');
                }
            });

            const activeView = views[viewName];

            if (activeView) {
                activeView.classList.remove('hidden');

                if (viewName === 'tabel') {
                    activeView.classList.add('flex');
                } else {
                    activeView.classList.add('block');
                }
            }

            document.querySelector('main').scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        function changePerPage(value) {
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', value);
            url.searchParams.set('page', 1); // Reset kembali ke halaman 1 setiap kali jumlah data diubah
            window.location.href = url.toString();
        }

        document.addEventListener('DOMContentLoaded', function() {

            @if($errors->any())
            switchView('tambah');
            @elseif(session('active_view'))
            switchView('{{ session('
                active_view ') }}');
            @endif

        });
    </script>
    @endsection