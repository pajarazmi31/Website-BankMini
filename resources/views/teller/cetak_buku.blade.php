<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>&nbsp;</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            /* Font standar mesin printer bank */
            font-size: 12px;
            color: #000;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .info-nasabah {
            margin-bottom: 20px;
        }

        .info-nasabah table {
            width: 50%;
        }

        .info-nasabah td {
            padding: 2px 5px;
        }

        .tabel-transaksi {
            width: 100%;
            border-collapse: collapse;
        }

        .tabel-transaksi th {
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            padding: 8px 5px;
            text-align: left;
        }

        .tabel-transaksi td {
            padding: 6px 5px;
            vertical-align: top;
        }

        .text-right {
            text-align: right;
        }

        /* Menyembunyikan tombol cetak saat diprint */
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; font-weight: bold; cursor: pointer;">Cetak Sekarang</button>
        <button onclick="window.close()" style="padding: 10px 20px; cursor: pointer;">Tutup Tab</button>
    </div>

    <table class="tabel-transaksi">
        <tbody>
            @forelse($transaksi as $index => $t)
                
                @if(($index + 1) < $mulai_baris)
                    <!-- BARIS KOSONG -->
                    <tr style="height: 25px;"> 
                        <td colspan="7"></td> <!-- Ubah colspan jadi 7 -->
                    </tr>
                @else
                    <!-- BARIS DATA ASLI -->
                    <tr style="height: 25px;">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($t->tanggal)->format('d/m/Y') }}</td>
                        
                        <!-- Panggil kode jenis transaksi -->
                        <td style="text-align: center;">{{ $t->jenis }}</td>
                        
                        <td class="text-left">{{ $t->biaya_admin > 0 ? number_format($t->biaya_admin, 0, ',', '.') : '-' }}</td>
                        <td class="text-left">{{ $t->debit > 0 ? number_format($t->debit, 0, ',', '.') : '-' }}</td>
                        <td class="text-left">{{ $t->kredit > 0 ? number_format($t->kredit, 0, ',', '.') : '-' }}</td>
                        <td class="text-left" style="font-weight: bold;">{{ number_format($t->saldo, 0, ',', '.') }}</td>
                    </tr>
                @endif

            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding-top: 20px;">Belum ada riwayat transaksi.</td> <!-- Ubah colspan jadi 7 -->
                </tr>
            @endforelse
        </tbody>
    </table>

    <script>
        // Beri jeda 500 milidetik (setengah detik) agar browser selesai merender tabel
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        }
    </script>
</body>

</html>