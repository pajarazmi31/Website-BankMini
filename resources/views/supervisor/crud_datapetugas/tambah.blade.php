<div id="viewTambahData" class="fade-in hidden flex-1 mt-4">
    <div class="bg-white rounded-[24px] shadow-card p-6 md:p-10 w-full border border-gray-50 overflow-y-auto custom-scrollbar">
        <h3 class="text-[20px] font-bold text-gray-800 mb-8 flex items-center gap-3">
            <div class="w-[6px] h-7 bg-brand-green rounded-full"></div>
            Tambah Data Petugas
        </h3>
        <form action="{{ route('datapetugas.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                <div>
                    <label class="block text-[13.5px] font-bold text-gray-500 mb-2">Nama Petugas</label>
                    <input type="text" name="name" placeholder="Masukkan nama petugas" class="w-full border border-gray-200 rounded-lg px-4 py-3 text-[14px] text-gray-800 focus:outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition-all bg-white shadow-sm">
                </div>
                <div>
                    <label class="block text-[13.5px] font-bold text-gray-500 mb-2">Password</label>
                    <input type="password" name="password" placeholder="********" class="w-full border border-gray-200 rounded-lg px-4 py-3 text-[14px] text-gray-800 focus:outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition-all bg-white shadow-sm">
                </div>
                <div>
                    <label class="block text-[13.5px] font-bold text-gray-500 mb-2">Email</label>
                    <input type="email" name="email" placeholder="contoh@gmail.com" class="w-full border border-gray-200 rounded-lg px-4 py-3 text-[14px] text-gray-800 focus:outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition-all bg-white shadow-sm">
                </div>
                <div>
                    <label class="block text-[13.5px] font-bold text-gray-500 mb-2">Role</label>
                    <select name="role_id" class="w-full border border-gray-200 rounded-lg px-4 py-3 text-[14px] text-gray-400 focus:outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition-all bg-white shadow-sm appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%239ca3af%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C%2Fpolyline%3E%3C%2Fsvg%3E')] bg-[length:1.2em_1.2em] bg-[right_1rem_center] bg-no-repeat"
                        onchange="this.classList.remove('text-gray-400'); this.classList.add('text-gray-800')">
                        @foreach($roles as $role)
                        <option value="{{ $role->id }}">
                            {{ $role->nama_role }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-12">
                <button type="button" onclick="switchView('tabel')" class="w-full bg-[#797979] hover:bg-gray-600 text-white font-bold py-3.5 rounded-xl transition-colors text-[15px]">Kembali</button>
                <button type="submit" class="w-full bg-button-gradient hover:bg-green-700 text-white font-bold py-3.5 rounded-xl transition-colors text-[15px] shadow-lg shadow-green-900/10">Simpan Petugas</button>
            </div>
        </form>
    </div>
</div>