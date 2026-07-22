<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Biodata Buku Tabungan</title>
    <style>
        /* Pengaturan ukuran kertas untuk passbook printer (sesuaikan dengan ukuran buku) */
        @page {
            size: 15cm 20cm;
            /* Sesuaikan dengan dimensi buku tabungan yang terbuka */
            margin: 0;
        }

        body {
            font-family: 'Courier New', Courier, monospace;
            /* Font monospaced lebih baik untuk printer passbook */
            font-size: 10pt;
            margin: 0;
            padding: 0;
        }

        /* Sesuaikan jarak margin (top dan left) agar pas tercetak di kolom biodata fisik buku */
        .biodata-container {
            position: absolute;
            top: 2cm;
            /* Jarak dari atas buku */
            left: 1cm;
            /* Jarak dari tepi kiri buku */
        }

        .baris-data {
            margin-bottom: 0.5cm;
            /* Jarak antar baris (Nama & No Rekening) */
        }
    </style>
</head>

    <div class="biodata-container">
        <div class="baris-data">
            <h3>Nama: <strong>{{ $rekening->nasabah->nama_nasabah ?? '-' }}</strong></h3> <!-- Nama Nasabah -->
        </div>
        <div class="baris-data">
            <h3>No. Rek: <strong>{{ $rekening->id }}</strong></h3> <!-- Nomor Rekening -->
        </div>
    </div>
<script>
    // Langsung memunculkan dialog print saat halaman selesai dimuat
    window.onload = function() {
        window.print();
    };

    // (Opsional) Otomatis menutup tab setelah dialog print ditutup
    window.onafterprint = function() {
        window.close();
    };
</script>
</body>

</html>