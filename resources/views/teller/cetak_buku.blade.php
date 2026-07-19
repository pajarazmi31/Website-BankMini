<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Buku Tabungan - {{ $rekening->id }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace; /* Font standar mesin printer bank */
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
        .text-right { text-align: right; }
        
        /* Menyembunyikan tombol cetak saat diprint */
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; font-weight: bold; cursor: pointer;">Cetak Sekarang</button>
        <button onclick="window.close()" style="padding: 10px 20px; cursor: pointer;">Tutup Tab</button>
    </div>

    <div class="header">
        <h2 style="margin: 0;">BUKU TABUNGAN NASABAH</h2>
        <p style="margin: 5px 0 0 0;">SMK Negeri 1 Kawali</p>
    </div>

    <div class="info-nasabah">
        <table>
            <tr>
                <td><strong>No. Rekening</strong></td>
                <td>: {{ $rekening->id }}</td>
            </tr>
            <tr>
                <td><strong>Nama Nasabah</strong></td>
                <td>: {{ $rekening->nasabah->nama_nasabah ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Tanggal Cetak</strong></td>
                <td>: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</td>
            </tr>
        </table>
    </div>

    <table class="tabel-transaksi">
        <thead>
            <tr>
                <th style="width: 5%;">NO</th>
                <th style="width: 15%;">TANGGAL</th>
                <th style="width: 15%;">ADM</th>
                <th class="text-right" style="width: 20%;">DEBIT (KELUAR)</th>
                <th class="text-right" style="width: 20%;">KREDIT (MASUK)</th>
                <th class="text-right" style="width: 25%;">SALDO</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksi as $index => $t)
                
                @if(($index + 1) < $mulai_baris)
                    <!-- BARIS KOSONG (SUDAH PERNAH DICETAK) -->
                    <!-- Fungsi ini murni untuk menekan kertas / head printer turun ke baris selanjutnya -->
                    <tr style="height: 25px;"> 
                        <td colspan="6"></td>
                    </tr>
                @else
                    <!-- BARIS DATA ASLI (YANG BELUM DICETAK) -->
                    <tr style="height: 25px;">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($t->tanggal)->format('d/m/Y') }}</td>
                        <td class="text-right">{{ $t->biaya_admin > 0 ? number_format($t->biaya_admin, 0, ',', '.') : '-' }}</td>
                        <td class="text-right">{{ $t->debit > 0 ? number_format($t->debit, 0, ',', '.') : '-' }}</td>
                        <td class="text-right">{{ $t->kredit > 0 ? number_format($t->kredit, 0, ',', '.') : '-' }}</td>
                        <td class="text-right" style="font-weight: bold;">{{ number_format($t->saldo, 0, ',', '.') }}</td>
                    </tr>
                @endif

            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding-top: 20px;">Belum ada riwayat transaksi.</td>
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