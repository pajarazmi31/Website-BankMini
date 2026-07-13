<table border="1">

    <!-- JUDUL -->
    <tr>
        <td colspan="7" style="text-align:center; font-size:18px; font-weight:bold;">
            BANK MINI SMKN 1 KAWALI
        </td>
    </tr>

    <tr>
        <td colspan="7" style="text-align:center; font-size:14px; font-weight:bold;">
            {{ $judul }}
        </td>
    </tr>

    <tr>
        <td colspan="7" style="text-align:center;">
            Dicetak pada :
            {{ now()->format('d-m-Y H:i') }}
        </td>
    </tr>

    <tr></tr>


    <!-- HEADER -->
    <tr>

        <th style="font-weight:bold; border:1px solid black;" width="18">
            ID Penarikan
        </th>

        <th style="font-weight:bold; border:1px solid black;" width="25">
            No Rekening
        </th>

        <th style="font-weight:bold; border:1px solid black;" width="35">
            Nama Penarik
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
            {{ $item->nama_penarik ?? '-' }}
        </td>


        <td style="border:1px solid black;">
            Rp {{ number_format($item->jumlah_penarikan,0,',','.') }}
        </td>


        <td style="border:1px solid black;">
            Rp {{ number_format($item->total_biaya ?? 0,0,',','.') }}
        </td>


        <td style="border:1px solid black;">
            {{ $item->created_at->format('d-m-Y') }}
        </td>

    </tr>

    @endforeach


    <tr>
        <td colspan="7"></td>
    </tr>


    <!-- TOTAL -->
    <tr>

        <td colspan="4"
            style="font-weight:bold;
            background:#D9EAD3;
            border:1px solid black;
            text-align:center;">
            TOTAL
        </td>


        <td style="font-weight:bold;border:1px solid black;">
            Rp {{ number_format($data->sum('jumlah_penarikan'),0,',','.') }}
        </td>


        <td style="font-weight:bold;border:1px solid black;">
            Rp {{ number_format($data->sum('total_biaya'),0,',','.') }}
        </td>

    </tr>


    <tr><td colspan="7"></td></tr>
    <tr><td colspan="7"></td></tr>


    <tr>
        <td colspan="5"></td>
        <td colspan="2" align="center">
            Kawali, {{ now()->format('d-m-Y') }}
        </td>
    </tr>


    <tr>
        <td colspan="5"></td>
        <td colspan="2" align="center">
            Petugas,
        </td>
    </tr>


    <tr>
        <td colspan="7"></td>
    </tr>

    <tr>
        <td colspan="7"></td>
    </tr>

    <tr>
        <td colspan="7"></td>
    </tr>


    <tr>
        <td colspan="5"></td>
        <td colspan="2" align="center">
            <b>{{ auth()->user()->name }}</b>
        </td>
    </tr>


</table>