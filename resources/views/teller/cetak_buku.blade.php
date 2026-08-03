<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>&nbsp;</title>
    <style>
        @page {
            size: 139mm 174mm;
            margin: 0;
        }

        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            color: #000;
            margin: 0;
            padding: 20px;
            width: 145mm;
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

        /* --- PENGATURAN JARAK ATAS --- */
        /* Ini jarak untuk halaman 1 */
        .spasi-halaman-1 {
            height: 35px; 
            display: block; 
        }

        /* INI YANG ANDA UBAH UNTUK HALAMAN 2 DAN SETERUSNYA */
        .spasi-halaman-lanjutan {
            height: 56px; /* <--- UBAH ANGKA INI (Misal: 60px, 90px, dst) SAMPAI PAS */
            display: block;
        }
        /* ----------------------------- */

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
                break-before: page;
            }

            .no-print {
                display: none;
            }
        }

        /* --- INI YANG GW UBAH BIAR JATUH KE BAWAHNYA PAS --- */
        .baris-transaksi {
            height: 62px; /* <--- Tadinya 50px. Kalau 10 barisnya masih kurang ke bawah, naikin angkanya jadi 68px atau 70px */
        }
    </style>
</head>

<body>
    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; font-weight: bold; cursor: pointer; background-color: #007bff; color: white; border: none; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">Cetak Sekarang</button>
        <button onclick="window.close()" style="padding: 10px 20px; font-weight: bold; cursor: pointer; background-color: #6c757d; color: white; border: none; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-left: 10px;">Tutup Tab</button>
    </div>

    @php
        $total_transaksi = count($transaksi);
        $index_data = $mulai_baris - 1;
        $sisa_transaksi = $total_transaksi - $index_data;
        if ($sisa_transaksi < 0) $sisa_transaksi = 0; 
        
        $total_slot_dibutuhkan = ($mulai_baris - 1) + $sisa_transaksi;
        $total_halaman = ceil($total_slot_dibutuhkan / 10);
        if ($total_halaman < 1) $total_halaman = 1;
    @endphp

    <table class="tabel-transaksi">
        @for ($halaman = 1; $halaman <= $total_halaman; $halaman++)

            <tbody class="{{ $halaman > 1 ? 'halaman-baru' : '' }}">
                
                <!-- Trik Kotak Kosong (DIV) agar tidak diabaikan saat print -->
                <tr>
                    <td colspan="6" style="padding: 0; border: none;">
                        <div class="{{ $halaman > 1 ? 'spasi-halaman-lanjutan' : 'spasi-halaman-1' }}"></div>
                    </td>
                </tr>

                @for ($baris = 1; $baris <= 10; $baris++)
                    @php
                        $slot_ke = (($halaman - 1) * 10) + $baris;
                    @endphp

                    <tr class="baris-transaksi">
                        @if ($slot_ke < $mulai_baris)
                            <td style="width: 30px;"></td>
                            <td style="width: 90px;"></td>
                            <td style="width: 50px;"></td>
                            <td style="width: 120px;"></td>
                            <td style="width: 90px;"></td>
                            <td></td>
                        @elseif ($index_data < $total_transaksi)
                            @php
                                $t = $transaksi->get($index_data);
                                $index_data++; 
                            @endphp

                            <td class="text-left" style="width: 30px;">{{ $baris }}</td>
                            
                            <td style="width: 90px;">
                            {{ \Carbon\Carbon::parse($t->tanggal)->format('d/m/Y') }}
                            @if(in_array($t->jenis, ['TFK', 'TFM', 'TFL']))
                                @php
                                    $nama = $t->keterangan ?? '-';
                                    // Cek apakah ada spasi (berarti minimal 2 kata)
                                    if ($nama !== '-' && strpos(trim($nama), ' ') !== false) {
                                        $pecah = explode(' ', trim($nama));
                                        $hasil = '';
                                        
                                        // 1. Cek apakah kata pertama adalah ANGKA (misal: NIS 242510191)
                                        if (isset($pecah[0]) && is_numeric($pecah[0])) {
                                            $hasil .= $pecah[0] . ' '; // Angka NIS dibiarkan utuh
                                            array_shift($pecah); // Buang angka dari daftar singkatan
                                        }
                                        
                                        // 2. Ambil kata berikutnya sebagai Nama Depan (contoh: Dinar / Siswa)
                                        if (count($pecah) > 0) {
                                            $hasil .= array_shift($pecah);
                                        }
                                        
                                        // 3. Looping sisa kata buat diambil huruf pertamanya + kasih titik
                                        $singkatan = '';
                                        foreach($pecah as $kata) {
                                            if (!empty($kata)) {
                                                $singkatan .= strtoupper(substr($kata, 0, 1)) . '.';
                                            }
                                        }
                                        
                                        // 4. Gabungin hasil akhirnya
                                        if ($singkatan !== '') {
                                            $nama = $hasil . ' ' . $singkatan;
                                        } else {
                                            $nama = $hasil; // Kalau cuma 1 kata setelah NIS (misal: "242510191 Siswa")
                                        }
                                    }
                                @endphp
                                <br><span style="font-size: 12px; color: #141414;">{{ $nama }}</span>
                            @endif
                        </td>
                            
                            <td class="text-left" style="width: 50px;">{{ $t->jenis }}</td>
                            <td class="text-left" style="width: 120px;">
                                {{ $t->debit > 0 ? number_format($t->debit, 0, ',', '.') : '-' }}
                                <br>ADM {{ number_format($t->biaya_admin, 0, ',', '.') }}
                            </td>
                            <td class="text-left" style="width: 90px;">{{ $t->kredit > 0 ? number_format($t->kredit, 0, ',', '.') : '-' }}</td>
                            <td class="text-left" style="font-weight: bold;">{{ number_format($t->saldo, 0, ',', '.') }}</td>
                        @else
                            <td style="width: 30px;"></td>
                            <td style="width: 90px;"></td>
                            <td style="width: 50px;"></td>
                            <td style="width: 120px;"></td>
                            <td style="width: 90px;"></td>
                            <td></td>
                        @endif
                    </tr>
                @endfor
            </tbody>
        @endfor
    </table>

    <script>
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        }
    </script>
</body>

</html>