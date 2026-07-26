<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tambah Data Master Siswa</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <form action="{{ route('datamaster.siswa') }}" method="post">
        @csrf
        <label for="nama_lengkap">Nama Lengkap</label> <br>
        <input type="text" class="nama_lengkap" name="nama_lengkap" required> <br>
        <label for="nis">NIS</label> <br>
        <input type="number" required name="nis">  <br>
        <label for="nisn">NISN</label> <br>
        <input type="number" required name="nisn"> <br>
        <label for="jurusan_id">Jurusan</label>
        <select name="jurusan_id" id="" name="jurusan_id" required>
            <option value="1">TKRO</option>
            <option value="2">TJKT</option>
            <option value="3">PPLG</option>
            <option value="4">DPIB</option>
            <option value="5">MPLB</option>
            <option value="6">AKUNTANSI</option>
            <option value="7">SK</option>
        </select> <br>
        <label for="jenis_kelamin">Jenis Kelamin</label>
        <select name="jenis_kelamin" name="jenis_kelamin" id="" required>
            <option value="Laki-Laki">Laki Laki</option>
            <option value="Perempuan">Perempuan</option>
        </select> <br>
        <label for="tempat_lahir" >Tempat Lahir</label>
        <input type="text" required name="tempat_lahir"> <br>
        <label for="tanggal_lahir">Tanggal Lahir</label> <br>
        <input type="date" required name="tanggal_lahir"> <br>
        <label for="agama">Agama</label>
        <select name="agama" name="agama" id="" required>
            <option value="Islam">Islam</option>
            <option value="Protestan">Protestan</option>
            <option value="Katholik">Khatolik</option>
            <option value="Hindu">Hindu</option>
            <option value="Buddha">Buddha</option>
            <option value="Khonghucu">Khonghucu</option>
        </select> <br>
        <label for="rt">RT</label> <br>
        <input type="number" name="rt" required> <br>
        <label for="rw">RW</label><br>
        <input type="number" name="rw" required> <br>
        <label for="dusun">Dusun</label> <br>
        <input type="text" name="dusun" required> <br>
                            <label class="block text-[13px] font-semibold text-gray-500 mb-2">Provinsi</label>
                            <select name="provinsi" id="provinsi" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 pr-10 text-[14px] text-gray-800 bg-white appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2218%22%20height%3D%2218%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%236B7280%22%20stroke-width%3D%222.5%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpath%20d%3D%22m6%209%206%206%206-6%22%2F%3E%3C%2Fsvg%3E')] bg-[length:18px] bg-[right_1rem_center] bg-no-repeat focus:outline-none focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 transition-all shadow-sm hover:border-gray-300 cursor-pointer">
                                <option value="" disabled selected>Pilih Provinsi</option>
                                @foreach ($provinsi as $prov)
                                <option value="{{ $prov->id }}">
                                    {{ ucwords(strtolower($prov->name)) }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-500 mb-2">Kabupaten/Kota</label>
                            <select name="kab_kota" id="kabupaten" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 pr-10 text-[14px] text-gray-800 bg-white appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2218%22%20height%3D%2218%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%236B7280%22%20stroke-width%3D%222.5%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpath%20d%3D%22m6%209%206%206%206-6%22%2F%3E%3C%2Fsvg%3E')] bg-[length:18px] bg-[right_1rem_center] bg-no-repeat focus:outline-none focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 transition-all shadow-sm hover:border-gray-300 cursor-pointer">
                                <option value="" disabled selected>Pilih Kabupaten</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-500 mb-2">Kecamatan</label>
                            <select name="kecamatan" id="kecamatan" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 pr-10 text-[14px] text-gray-800 bg-white appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2218%22%20height%3D%2218%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%236B7280%22%20stroke-width%3D%222.5%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpath%20d%3D%22m6%209%206%206%206-6%22%2F%3E%3C%2Fsvg%3E')] bg-[length:18px] bg-[right_1rem_center] bg-no-repeat focus:outline-none focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 transition-all shadow-sm hover:border-gray-300 cursor-pointer">
                                <option value="" disabled selected>Pilih Kecamatan</option>
                            </select>
                        </div>
                        <div>
            <select name="kelurahan" id="desa">
                <option value="" disabled selected>Pilih Desa</option>
            </select>
        <label for="kode_pos">Kode Pos</label> <br>
        <input type="number" name="kode_pos" required>
        <button type="submit">Tambah</button>

        @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK'
            });
        </script>
        @endif

    </form>

<script>
$(document).ready(function () {

    // ==========================
    // PROVINSI -> KABUPATEN
    // ==========================
    $('#provinsi').change(function () {

        let id = $(this).val();

        $('#kabupaten').html('<option value="">Pilih Kabupaten</option>');
        $('#kecamatan').html('<option value="">Pilih Kecamatan</option>');
        $('#desa').html('<option value="">Pilih Desa</option>');

        if(id == '') return;

        $.ajax({
            url: '/get-kabupaten/' + id,
            type: 'GET',
            success: function(data){

                $.each(data, function(index, item){

                    $('#kabupaten').append(
                        '<option value="'+item.id+'">'+item.name+'</option>'
                    );

                });

            }
        });

    });


    // ==========================
    // KABUPATEN -> KECAMATAN
    // ==========================
    $('#kabupaten').change(function () {

        let id = $(this).val();

        $('#kecamatan').html('<option value="">Pilih Kecamatan</option>');
        $('#desa').html('<option value="">Pilih Desa</option>');

        if(id == '') return;

        $.ajax({
            url: '/get-kecamatan/' + id,
            type: 'GET',
            success: function(data){

                $.each(data, function(index, item){

                    $('#kecamatan').append(
                        '<option value="'+item.id+'">'+item.name+'</option>'
                    );

                });

            }
        });

    });


    // ==========================
    // KECAMATAN -> DESA
    // ==========================
    $('#kecamatan').change(function () {

        let id = $(this).val();

        $('#desa').html('<option value="">Pilih Desa</option>');

        if(id == '') return;

        $.ajax({
            url: '/get-desa/' + id,
            type: 'GET',
            success: function(data){

                console.log(data);

                $.each(data, function(index, item){

                    $('#desa').append(
                        '<option value="'+item.id+'">'+item.name+'</option>'
                    );

                });

            },
            error: function(xhr){
                console.log(xhr.responseText);
            }
        });

    });

});
</script>
</body>
</html>
