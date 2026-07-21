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
            width: 150mm;
            height: 85mm;

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

        .space-header {
            height: 50px;
            /* SILAKAN UBAH ANGKA INI JIKA JARAKNYA KURANG ATAU TERLALU LEBAR */
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

        @media print {
            .halaman-baru {
                page-break-before: always;
            }

            .no-print {
                display: none;
            }
        }

        .baris-transaksi {
            height: 50px;
            /* Sesuaikan dengan jarak antar baris buku fisik Anda */
        }
    </style>
</head>

<body>
    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; font-weight: bold; cursor: pointer;">Cetak Sekarang</button>
        <button onclick="window.close()" style="padding: 10px 20px; cursor: pointer;">Tutup Tab</button>
    </div>

    @php
    // 1. Hitung total seluruh data transaksi yang ada di database
    $total_transaksi = count($transaksi);

    // 2. SET POINTER DATA (Ini kunci masalahnya)
    // Jika mulai_baris = 8, maka kita abaikan 7 transaksi pertama.
    // Array dimulai dari 0, jadi data ke-8 ada di index 7.
    $index_data = $mulai_baris - 1;

    // 3. Hitung berapa sisa transaksi yang BENAR-BENAR akan dicetak
    $sisa_transaksi = $total_transaksi - $index_data;
    if ($sisa_transaksi < 0) $sisa_transaksi=0; // Jaga-jaga jika input baris melebihi total data

        // 4. Hitung total slot fisik (baris kosong + sisa transaksi)
        $total_slot_dibutuhkan=($mulai_baris - 1) + $sisa_transaksi;

        // 5. Hitung butuh berapa halaman (1 halaman=10 baris)
        $total_halaman=ceil($total_slot_dibutuhkan / 10);
        if ($total_halaman < 1) $total_halaman=1;
        @endphp

        <!-- Looping berdasarkan jumlah halaman -->
        @for ($halaman = 1; $halaman <= $total_halaman; $halaman++)

            <div class="{{ $halaman > 1 ? 'halaman-baru' : '' }}">
            <div class="space-header"></div>
            <table class="tabel-transaksi">
                <tbody>
                    <!-- Looping FIX 10 baris per halaman -->
                    @for ($baris = 1; $baris <= 10; $baris++)
                        @php
                        // Menentukan ini baris ke-berapa secara keseluruhan (akumulasi dari halaman)
                        $slot_ke=(($halaman - 1) * 10) + $baris;
                        @endphp

                        <tr class="baris-transaksi">
                        @if ($slot_ke < $mulai_baris)
                            <!-- KONDISI A: Baris kosong karena dilewati (Transaksi 1-7) -->
                            <td colspan="6"></td>
                            @elseif ($index_data < $total_transaksi)
                                <!-- KONDISI B: Cetak sisa data transaksi -->
                                @php
                                // Ambil data sesuai index_data saat ini
                                $t = $transaksi->get($index_data);
                                $index_data++; // Naikkan penunjuk ke transaksi berikutnya
                                @endphp

                                <td class="text-left">{{ $slot_ke }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($t->tanggal)->format('d/m/Y') }}

                                    <!-- Cek apakah jenis transaksinya termasuk kategori transfer -->
                                    @if(in_array($t->jenis, ['TFK', 'TFM', 'TFL']))
                                    <br><span style="font-size: 10px; color: #555;">{{ $t->keterangan ?? '-' }}</span>
                                    @endif
                                </td>
                                <td class="text-left">{{ $t->jenis }}</td>
                                <td class="text-left">
                                    {{ $t->debit > 0 ? number_format($t->debit, 0, ',', '.') : '-' }}
                                    <br>ADM {{ number_format($t->biaya_admin, 0, ',', '.') }}
                                </td>
                                <td class="text-left">{{ $t->kredit > 0 ? number_format($t->kredit, 0, ',', '.') : '-' }}</td>
                                <td class="text-left" style="font-weight: bold;">{{ number_format($t->saldo, 0, ',', '.') }}</td>
                                @else
                                <!-- KONDISI C: Baris kosong karena data sudah habis dicetak -->
                                <td colspan="6"></td>
                                @endif
                                </tr>
                                @endfor
                </tbody>
            </table>
            </div>

            @endfor

            <script>
                window.onload = function() {
                    setTimeout(function() {
                        window.print();
                    }, 500);
                }
            </script>
</body>

</html>