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
            ID Transfer
        </th>

        <th style="font-weight:bold; border:1px solid black;" width="25">
            Rekening Pengirim
        </th>

        <th style="font-weight:bold; border:1px solid black;" width="25">
            Rekening Penerima
        </th>

        <th style="font-weight:bold; border:1px solid black;" width="20">
            Nominal Transfer
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
            {{ $item->rekeningPengirim->nasabah->nama_nasabah ?? '-' }}
            <br>
            ({{ $item->id_rekening_pengirim }})
        </td>


        <td style="border:1px solid black;">
            {{ $item->rekeningPenerima->nasabah->nama_nasabah ?? '-' }}
            <br>
            ({{ $item->id_rekening_penerima }})
        </td>


        <td style="border:1px solid black;">
            Rp {{ number_format($item->jumlah_transfer,0,',','.') }}
        </td>


        <td style="border:1px solid black;">
            Rp {{ number_format($item->total_biaya,0,',','.') }}
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

        <td colspan="3"
            style="font-weight:bold;
            background:#D9EAD3;
            border:1px solid black;
            text-align:center;">
            TOTAL
        </td>


        <td style="font-weight:bold;border:1px solid black;">
            Rp {{ number_format($data->sum('jumlah_transfer'),0,',','.') }}
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


    <tr><td colspan="7"></td></tr>
    <tr><td colspan="7"></td></tr>
    <tr><td colspan="7"></td></tr>


    <tr>
        <td colspan="5"></td>
        <td colspan="2" align="center">
            <b>{{ auth()->user()->name }}</b>
        </td>
    </tr>


</table>