@extends('layouts.teller')

@section('title', 'Teller - Data Penarikan')
@section('header_title')
    Selamat Datang, {{ $teller->nama_petugas }}!
@endsection
@section('header_subtitle', 'Lorem Ipsum is simply dummy text of the printing.')

@section('styles')
<style>
    .fade-in { animation: fadeIn 0.3s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endsection

@section('content')


<!-- ================= VIEW 1: TABEL DATA PENARIKAN ================= -->
<div id="viewTabelData" class="fade-in block flex-1 flex flex-col justify-start">
    <!-- Search Bar Mobile -->
    <div class="md:hidden relative mb-5">
        <i class="ph ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-lg"></i>
        <input type="text" placeholder="Cari nama atau no. rekening..." class="w-full pl-12 pr-4 py-3.5 bg-white border border-gray-100 rounded-2xl text-[14px] focus:outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue text-gray-700 placeholder-gray-400 shadow-sm transition-all">
    </div>

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4 px-1">
        <h3 class="text-[22px] font-bold text-gray-800">Data Penarikan</h3>
        <button onclick="switchView('tambah')" class="bg-gradient-to-r from-[#143657] to-[#316392] text-white px-3 py-1.5 rounded-[10px] text-[13px] font-bold flex items-center gap-2 hover:opacity-90 transition-all shadow-md w-full sm:w-auto justify-center">
            <i class="ph ph-plus text-base"></i> Tambah Data
        </button>
    </div>

    <div class="bg-white rounded-[20px] shadow-card p-6 w-full flex flex-col">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr>
                        <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] w-12 border-b border-gray-100">No</th>
                        <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">Nama</th>
                        <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">No. Rekening</th>
                        <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">Nominal Rupiah</th>
                        <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">Tanggal</th>
                        <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">Petugas</th>
                        <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] text-center w-36 border-b border-gray-100">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-[14px] text-gray-800 font-medium">
                   @forelse($data as $index => $d)

            <tr class="hover:bg-gray-50/50 transition-colors">

                <td class="py-4 px-2 border-b border-gray-50">
                    {{ $index + 1 }}.
                </td>

                <td class="py-4 px-2 border-b border-gray-50">
                    {{ $d->nama_penarik }}
                </td>

                <td class="py-4 px-2 border-b border-gray-50">
                    {{ $d->id_rekening }}
                </td>

                <td class="py-4 px-2 border-b border-gray-50 text-gray-800">
                    Rp. {{ number_format($d->jumlah_penarikan, 0, ',', '.') }}
                </td>

                <td class="py-4 px-2 border-b border-gray-50">
                    {{ \Carbon\Carbon::parse($d->created_at)->format('d-m-Y H:i') }}
                </td>

                <td class="py-4 px-2 border-b border-gray-50">
                    {{ $teller->nama_petugas }}
                </td>

                <td class="py-4 px-2 border-b border-gray-50 text-center">

                    <div class="flex items-center justify-center gap-2">

                        <button
                            onclick="showDetail(
                                '{{ $d->nama_penarik }}',
                                '{{ $d->id_rekening }}',
                                '{{ number_format($d->jumlah_penarikan,0,",",".") }}',
                                '{{ $teller->nama_petugas }}'
                            )"

                            class="w-[28px] h-[28px] rounded-full bg-[#e2e8f0] text-brand-blue flex items-center justify-center hover:bg-gray-300 transition-colors"
                            title="Lihat Detail">

                            <i class="ph-fill ph-eye text-[15px]"></i>

                        </button>

                        <button
                            onclick="editData(
                                '{{ $d->id }}',
                                '{{ $d->nama_penarik }}',
                                '{{ $d->id_rekening }}',
                                '{{ $d->jumlah_penarikan }}',
                                '{{ $teller->nama_petugas }}'
                            )"

                            class="w-[28px] h-[28px] rounded-full bg-[#d1fae5] text-[#10a163] flex items-center justify-center hover:bg-green-200 transition-colors"
                            title="Edit">

                            <i class="ph-fill ph-pencil-simple text-[15px]"></i>

                        </button>

                <form
                    action="{{ route('penarikan.delete', $d->id) }}"
                    method="POST"
                    onsubmit="return confirm('Yakin hapus data ini?')"
                >

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="w-[28px] h-[28px] rounded-full bg-[#fee2e2] text-red-500 flex items-center justify-center hover:bg-red-200 transition-colors"
                        title="Hapus"
                    >

                        <i class="ph-fill ph-trash text-[15px]"></i>

                    </button>

                </form>

                    </div>

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="6"
                    class="py-8 text-center text-gray-400">

                    Belum ada data penarikan

                </td>

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
@include('teller.crud_penarikan.tambah')
@include('teller.crud_penarikan.detail')
@include('teller.crud_penarikan.edit')

@endsection

@section('scripts')
<script>
    function switchView(viewName) {
        const views = {
            'tabel': document.getElementById('viewTabelData'),
            'tambah': document.getElementById('viewTambahData'),
            'edit': document.getElementById('viewEditData'),
            'detail': document.getElementById('viewDetailData')
        };

        Object.values(views).forEach(v => {
            if(v) v.classList.add('hidden');
        });

        const activeView = views[viewName];
        const searchBar = document.getElementById('searchBarContainer');

        if (activeView) {
            activeView.classList.remove('hidden');
            if (viewName === 'tabel') {
                activeView.classList.add('flex');
                if (searchBar) searchBar.classList.remove('md:hidden');
            } else {
                activeView.classList.add('block');
                if (searchBar) searchBar.classList.add('md:hidden');
            }
        }
        document.querySelector('main').scrollTo({ top: 0, behavior: 'smooth' });
    }

    function showDetail(nama, rek, nominal, petugas){
        document.getElementById('detail_nama').value = nama;
        document.getElementById('detail_rek').value = rek;
        document.getElementById('detail_nominal').value ='Rp. ' + nominal;
        document.getElementById('detail_petugas').value =petugas;
        switchView('detail');
    }

    function editData(id, nama, rek, nominal, petugas)
    {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_nama').value = nama;
        document.getElementById('edit_rek').value = rek;
        document.getElementById('edit_nominal').value = nominal;
        document.getElementById('edit_petugas').value = petugas;
        document.getElementById('editForm').action = '/penarikan/update/' + id;
        switchView('edit');
    }
</script>
@endsection
