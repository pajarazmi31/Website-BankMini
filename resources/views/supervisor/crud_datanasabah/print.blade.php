<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body onload="window.print()">
    {{ $nasabah->nama_nasabah }}
    {{ $nasabah->rekening->id }}
    {{ $nasabah->tempat_lahir }}
    {{ $nasabah->tanggal_lahir }}
    {{ $nasabah->jurusan_id }}
    {{ $nasabah->jenis_kelamin }}
    {{ $nasabah->pendidikan }}
    {{ $nasabah->alamat }}
    {{ $nasabah->provinsi_id }}
    {{ $nasabah->kab_kota_id }}
    {{ $nasabah->kecamatan_id }}
    {{ $nasabah->kelurahan_id }}
    {{ $nasabah->kode_pos }}
    {{ $nasabah->email }}
    {{ $nasabah->agama }}
    {{ $nasabah->no_hp }}
    {{ $nasabah->jabatan }}
    {{ $nasabah->jenis_identitas }}
    {{ $nasabah->nama_kontak_darurat }}
    {{ $nasabah->alamat_kontak_darurat }}
    {{ $nasabah->no_hp_kontak_darurat }}
    {{ $nasabah->hubungan_kontak_darurat }}

    <script>
    window.onafterprint = function() {
        window.location.href="{{ route('supervisor.datanasabah') }}"
    }
    </script>

</body>
</html>
