@extends('layouts.supervisor')

@section('title', 'Supervisor - Data Petugas')
@section('header_title', 'Selamat Datang, Supervisor!')
@section('header_subtitle', 'Lorem Ipsum is simply dummy text of the printing.')

@section('styles')
<style>
    /* Animasi transisi antar view */
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
<!-- ================= VIEW 1: TABEL DATA PETUGAS ================= -->
<div id="viewTabelData" class="fade-in flex flex-1 flex-col justify-start">
    <!-- Search Bar Mobile -->
    <div class="md:hidden relative mb-5">
        <i class="ph ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-lg"></i>
        <input type="text" placeholder="Cari data..." class="w-full pl-12 pr-4 py-3.5 bg-white border border-gray-100 rounded-2xl text-[14px] focus:outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue text-gray-700 placeholder-gray-400 shadow-sm transition-all">
    </div>


    <!-- Table Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4 px-1">
        <h3 class="text-[20px] md:text-[22px] font-bold text-gray-800">Data Petugas</h3>
        <button onclick="switchView('tambah')" class="bg-gradient-to-r from-[#143657] to-[#316392] text-white px-3 py-1.5 rounded-[10px] text-[13px] font-bold flex items-center gap-2 hover:opacity-90 transition-all shadow-md w-full sm:w-auto justify-center">
            <i class="ph ph-plus text-base"></i> Tambah Data
        </button>

    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-[20px] shadow-card p-6 w-full flex flex-col">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr>
                        <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] w-16 border-b border-gray-100 pl-4">No</th>
                        <th class="py-4 px-4 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">Nama Petugas</th>
                        <th class="py-4 px-4 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">Password</th>
                        <th class="py-4 px-4 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100 hidden md:table-cell">Email</th>
                        <th class="py-4 px-4 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">Role</th>
                        <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] text-center w-36 border-b border-gray-100">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-[14px] text-gray-800 font-medium">
                    @php
                        $petugasList = [
                            ['no' => 1, 'nama' => 'Pajar Azmi Anugraha', 'email' => 'user@gmail.com', 'role' => 'Teller'],
                            ['no' => 2, 'nama' => 'Salsabila Rosi Cahyani', 'email' => 'user@gmail.com', 'role' => 'Customer Service'],
                            ['no' => 3, 'nama' => 'Anisa Siti Nur Fajriyanti', 'email' => 'user@gmail.com', 'role' => 'Teller'],
                            ['no' => 4, 'nama' => 'Yanto Supriyanto', 'email' => 'user@gmail.com', 'role' => 'Customer Service'],
                            ['no' => 5, 'nama' => 'Ali Mahendra', 'email' => 'user@gmail.com', 'role' => 'Teller'],
                        ];
                    @endphp
                    @foreach($petugasList as $p)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="py-4 px-2 border-b border-gray-50 text-gray-600 pl-4">{{ $p['no'] }}.</td>
                        <td class="py-4 px-4 border-b border-gray-50 text-gray-700 font-medium">{{ $p['nama'] }}</td>
                        <td class="py-4 px-4 border-b border-gray-50 text-gray-600 font-medium tracking-widest">*****</td>
                        <td class="py-4 px-4 border-b border-gray-50 hidden md:table-cell text-gray-700 font-medium">{{ $p['email'] }}</td>
                        <td class="py-4 px-4 border-b border-gray-50 text-gray-700 font-medium">{{ $p['role'] }}</td>
                        <td class="py-4 px-2 border-b border-gray-50">
                            <div class="flex items-center justify-center gap-3">
                                <button onclick="viewDetail('{{ $p['nama'] }}', '{{ $p['email'] }}', '{{ $p['role'] }}')" class="w-[28px] h-[28px] rounded-full bg-[#f1f5f9] text-[#1c3a5a] flex items-center justify-center hover:bg-gray-200 transition-colors" title="Lihat Detail"><i class="ph-fill ph-eye text-[15px]"></i></button>
                                <button onclick="viewEdit('{{ $p['nama'] }}', '{{ $p['email'] }}', '{{ $p['role'] }}')" class="w-[28px] h-[28px] rounded-full bg-[#dcfce7] text-[#16a34a] flex items-center justify-center hover:bg-green-200 transition-colors" title="Edit Data"><i class="ph-fill ph-pencil-simple text-[15px]"></i></button>
                                <button onclick="openDeleteModal(() => showToast('Data Petugas Berhasil Dihapus!'))" class="w-[28px] h-[28px] rounded-full bg-[#fee2e2] text-[#ef4444] flex items-center justify-center hover:bg-red-200 transition-colors" title="Hapus Data"><i class="ph-fill ph-trash text-[15px]"></i></button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <x-pagination />

    </div>
</div>

<!-- ================= CRUD VIEWS (Separated Files) ================= -->
@include('supervisor.crud_datapetugas.tambah')
@include('supervisor.crud_datapetugas.edit')
@include('supervisor.crud_datapetugas.detail')
@endsection

@section('scripts')
<script>
    // Lihat Detail
    function viewDetail(nama, email, role) {
        document.getElementById('detail_nama').value = nama;
        document.getElementById('detail_email').value = email;
        document.getElementById('detail_role_text').value = role;
        
        switchView('detail');
    }

    // Edit Data
    function viewEdit(nama, email, role) {
        document.getElementById('edit_nama').value = nama;
        document.getElementById('edit_email').value = email;
        
        let roleSelect = document.getElementById('edit_role');
        for(let i=0; i<roleSelect.options.length; i++) {
            if(roleSelect.options[i].text.toLowerCase() === role.toLowerCase()) {
                roleSelect.selectedIndex = i;
                break;
            }
        }
        switchView('edit');
    }

    // Pindah antara Tabel Data dan Form Input
    function switchView(viewName) {
        const views = {
            'tabel': document.getElementById('viewTabelData'),
            'tambah': document.getElementById('viewTambahData'),
            'edit': document.getElementById('viewEditData'),
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
</script>
@endsection