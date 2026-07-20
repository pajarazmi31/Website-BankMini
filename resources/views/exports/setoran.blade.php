<table border="1">

        <!-- JUDUL -->
        <tr>
            <td colspan="8" style="text-align:center; font-size:18px; font-weight:bold;">
                BANK MINI SMKN 1 KAWALI
            </td>
        </tr>

        <tr>
            <td colspan="8" style="text-align:center; font-size:14px; font-weight:bold;">
                {{ $judul }}
            </td>
        </tr>

        <tr>
            <td colspan="8" style="text-align:center;">
                Dicetak pada :
                {{ now()->format('d-m-Y H:i') }}
            </td>
        </tr>

        <!-- Baris kosong -->
        <tr></tr>

        <!-- HEADER -->
        <tr>

            <th style="font-weight:bold; border:1px solid black;" width="18">
                ID Setoran
            </th>

            <th style="font-weight:bold; border:1px solid black;" width="25">
                No Rekening
            </th>

            <th style="font-weight:bold; border:1px solid black;" width="35">
                Nama Nasabah
            </th>

            <th style="font-weight:bold; border:1px solid black;" width="35">
                Nama Penyetor
            </th>

            <th style="font-weight:bold; border:1px solid black;" width="20">
                Nominal
            </th>

            <th style="font-weight:bold; border:1px solid black;" width="20">
                Total Biaya
            </th>

            <th style="font-weight:bold; border:1px solid black;" width="20">
                Tanggal
            </th>

            <!-- TAMBAHAN: Header Petugas -->
            <th style="font-weight:bold; border:1px solid black;" width="25">
                Petugas
            </th>

        </tr>

        @foreach($data as $item)

        <tr>

            <td style="border:1px solid black;">
                {{ $item->id }}
            </td>

            <td style="border:1px solid black;">
                {{ $item->id_rekening }}
            </td>

            <td style="border:1px solid black;">
                {{ $item->nama_lengkap }}
            </td>

            <td style="border:1px solid black;">
                {{ $item->nama_penyetor }}
            </td>

            <td style="border:1px solid black;">
                Rp {{ number_format($item->jumlah_penyetoran,0,',','.') }}
            </td>

            <td style="border:1px solid black;">
                Rp {{ number_format($item->total_biaya,0,',','.') }}
            </td>

            <td style="border:1px solid black;">
                {{ $item->created_at->format('d-m-Y') }}
            </td>

            <!-- TAMBAHAN: Menampilkan Nama Petugas per Data -->
            <td style="border:1px solid black;">
                {{ optional($item->petugas)->user->name ?? '-' }}
            </td>

        </tr>

        @endforeach

        <tr>
            <td colspan="8"></td>
        </tr>

        <tr>

            <td colspan="4"
                style="font-weight:bold;
                    background:#D9EAD3;
                    border:1px solid black;
                    text-align:center;">
                TOTAL
            </td>

            <td style="font-weight:bold;border:1px solid black;">
                Rp {{ number_format($data->sum('jumlah_penyetoran'),0,',','.') }}
            </td>

            <td style="font-weight:bold;border:1px solid black;">
                Rp {{ number_format($data->sum('total_biaya'),0,',','.') }}
            </td>

        </tr>

        <tr><td colspan="8"></td></tr>
        <tr><td colspan="8"></td></tr>

        <tr>
            <td colspan="6"></td> <!-- Diubah jadi 6 supaya pas posisinya -->
            <td colspan="2" align="center">
                Kawali, {{ now()->format('d-m-Y') }}
            </td>
        </tr>

        <tr>
            <td colspan="6"></td>
            <td colspan="2" align="center">
                Petugas Cetak,
            </td>
        </tr>

        <tr><td colspan="8"></td></tr>
        <tr><td colspan="8"></td></tr>
        <tr><td colspan="8"></td></tr>

        <tr>
            <td colspan="6"></td>
            <td colspan="2" align="center">
                <b>{{ auth()->user()->name }}</b>
            </td>
        </tr>

    </table>