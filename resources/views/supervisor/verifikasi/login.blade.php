@extends('layouts.supervisor')

@section('title','Supervisor Dashboard')
@section('header_title')
Selamat Datang, {{ $user->name }}!
@endsection
@section('header_subtitle', 'Lorem Ipsum is simply dummy text of the printing.')

@section('content')
<div id="viewTabel" class="fade-in flex flex-1 flex-col justify-start">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-5 px-1 gap-4">

        <h3 class="text-[24px] font-bold text-gray-800">
            Data Verifikasi Login
        </h3>

        <div class="flex bg-gray-100 p-1 rounded-xl w-full sm:w-[300px]">
            <a href="{{ route('supervisor.verifikasi.login') }}"
                class="flex-1 px-4 py-2 bg-white rounded-lg shadow-sm text-brand-blue font-bold text-[13px] text-center">
                Login
            </a>

            <a href="{{ route('supervisor.verifikasi.registrasi') }}"
                class="flex-1 px-4 py-2 text-gray-500 font-medium text-[13px] text-center">
                Registrasi
            </a>

            <a href="{{ route('supervisor.verifikasi') }}"
                class="flex-1 px-4 py-2 text-gray-500 font-medium text-[13px] text-center">
                Transfer
            </a>
        </div>
    </div>

    <div class="bg-white rounded-[20px] shadow-card p-6 w-full">
        <div class="flex justify-between items-center mb-1 border-b border-gray-50">
            <form action="{{ route('supervisor.verifikasi.login') }}" method="get" class="flex gap-2 items-center">
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
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-[13px] text-gray-600 font-medium">Tampilkan:</span>
                    <select onchange="changePerPage(this.value)" class="bg-white border border-gray-200 text-gray-700 text-[13px] rounded-[10px] px-3 py-1.5 font-semibold focus:outline-none focus:border-brand-blue shadow-sm cursor-pointer">
                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10 data</option>
                        <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20 data</option>
                        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50 data</option>
                        <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100 data</option>
                    </select>
                </div>
                @if($data->count() > 0)
                <form action="{{ route('supervisor.verifikasi.login.destroyAll') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus SELURUH data verifikasi login? Tindakan ini tidak dapat dibatalkan!');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-0.5 bg-red-50 text-red-600 hover:bg-red-100 font-medium text-[13px] rounded-xl transition-all border border-red-200">
                        <i class="ph ph-trash text-lg"></i>
                        <span>Hapus Semua Data</span>
                    </button>
                </form>
                @endif
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">

                <thead>
                    <tr>
                        <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] w-12 border-b border-gray-100">No</th>
                        <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">Nama</th>
                        <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">Email</th>
                        <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">Role</th>
                        <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] border-b border-gray-100">Status</th>
                        <th class="py-4 px-2 text-[#a3a3a3] font-medium text-[13px] text-center w-40 border-b border-gray-100">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody class="text-[14px] text-gray-800 font-medium">

                    @forelse($data as $index => $item)

                    <tr class="hover:bg-gray-50/50 transition-colors">

                        <td class="py-4 px-2 border-b border-gray-50 text-gray-600 pl-4">
                            {{ $data->firstItem() + $index }}.
                        </td>

                        <td class="py-4 px-2 border-b border-gray-50">
                            {{ $item->user->name }}
                        </td>

                        <td class="py-4 px-2 border-b border-gray-50">
                            {{ $item->user->email }}
                        </td>

                        <td class="py-4 px-2 border-b border-gray-50">
                            {{ $item->user->role->nama_role }}
                        </td>

                        <td class="py-4 px-2 border-b border-gray-50">
                            @if($item->status == 'pending')

                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 text-xs">
                                <i class="ph ph-clock"></i>
                                Pending
                            </span>

                            @elseif($item->status == 'disetujui')

                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-green-100 text-green-800 text-xs">
                                <i class="ph ph-check-circle"></i>
                                Disetujui
                            </span>

                            @else

                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-100 text-red-800 text-xs">
                                <i class="ph ph-x-circle"></i>
                                Ditolak
                            </span>

                            @endif
                        </td>

                        <td class="py-4 px-2 border-b border-gray-50 ">
                            <div class="flex items-center justify-center gap-2">
                                <button
                                    type="button"
                                    onclick="viewDetail(
                                            '{{ $item->id }}',
                                            '{{ $item->user->name }}',
                                            '{{ $item->user->email }}',
                                            '{{ $item->user->role->nama_role }}',
                                            '{{ $item->status }}',
                                            '{{ $item->created_at->format('d/m/Y H:i') }}',
                                            '{{ $item->waktu_verifikasi ? \Carbon\Carbon::parse($item->waktu_verifikasi)->format('d/m/Y H:i') : '-' }}'
                                        )"
                                    class="w-[30px] h-[30px] rounded-full bg-[#e2e8f0] text-brand-blue flex items-center justify-center hover:bg-gray-300 transition-colors" title="Lihat Detail"><i class="ph-fill ph-eye text-[16px]"></i>

                                </button>

                                @if($item->status == 'pending')

                                <form
                                    action="{{ route('supervisor.verifikasi.login.setujui',$item->id) }}"
                                    method="POST">

                                    @csrf

                                    <button
                                        onclick="return confirm('Setujui login ini?')"
                                        class="w-[30px] h-[30px] rounded-full bg-[#d1fae5] text-[#10a163] flex items-center justify-center">

                                        <i class="ph-bold ph-check-circle"></i>

                                    </button>

                                </form>

                                <form
                                    action="{{ route('supervisor.verifikasi.login.tolak',$item->id) }}"
                                    method="POST">

                                    @csrf

                                    <button
                                        onclick="return confirm('Tolak login ini?')"
                                        class="w-[30px] h-[30px] rounded-full bg-[#fee2e2] text-red-500 flex items-center justify-center">

                                        <i class="ph-bold ph-x-circle"></i>

                                    </button>

                                </form>

                                @else

                                <span class="text-[10px] text-gray-400">
                                    <i class="ph ph-lock"></i>
                                    Selesai
                                </span>

                                @endif

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="8"
                            class="text-center py-8 text-gray-500">
                            Tidak ada permintaan login
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>
        </div>
        <!-- Pagination -->
        <x-pagination :paginator="$data" />
    </div>

</div>
@include('supervisor.verifikasi.login.detail')
@endsection

@section('scripts')
<script>
    function switchView(view) {
        document.getElementById('viewTabel')
            .classList.add('hidden');

        document.getElementById('viewDetailLogin')
            .classList.add('hidden');

        document.getElementById(view)
            .classList.remove('hidden');
    }

    function viewDetail(
        id,
        nama,
        email,
        role,
        status,
        waktuLogin,
        waktuVerifikasi
    ) {

        document.getElementById('detail_id').value = id;
        document.getElementById('detail_nama').value = nama;
        document.getElementById('detail_email').value = email;
        document.getElementById('detail_role').value = role;
        document.getElementById('detail_status').value = status;
        document.getElementById('detail_login').value = waktuLogin;
        document.getElementById('detail_verifikasi').value = waktuVerifikasi;

        switchView('viewDetailLogin');
    }

    function changePerPage(value) {
        const url = new URL(window.location.href);
        url.searchParams.set('per_page', value);
        url.searchParams.set('page', 1); // Reset kembali ke halaman 1 setiap kali jumlah data diubah
        window.location.href = url.toString();
    }
</script>
@endsection