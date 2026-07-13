<table>
    <tr>
        <th colspan="9" style="font-weight: bold; font-size: 18px; text-align: center;">
            BANK MINI SMKN 1 KAWALI
        </th>
    </tr>

    <tr>
        <th colspan="9" style="font-weight: bold; font-size: 16px; text-align: center;">
            LAPORAN BUKTI TRANSFER
        </th>
    </tr>

    <tr>
        <th colspan="9" style="font-style: italic; text-align: center;">
            @if($startDate && $endDate)
                Periode: {{ date('d-m-Y', strtotime($startDate)) }} s/d {{ date('d-m-Y', strtotime($endDate)) }}
            @else
                Periode: Semua Data
            @endif
        </th>
    </tr>

    <tr>
        <td colspan="9"></td>
    </tr> 

    <thead>
        <tr>
            <th style="font-weight: bold; text-align: center; background-color: #2B4C7E; color: #FFFFFF;">ID</th>
            <th style="font-weight: bold; text-align: center; background-color: #2B4C7E; color: #FFFFFF;">Nama Pengirim</th>
            <th style="font-weight: bold; text-align: center; background-color: #2B4C7E; color: #FFFFFF;">Nama Penerima</th>
            <th style="font-weight: bold; text-align: center; background-color: #2B4C7E; color: #FFFFFF;">No Rekening Penerima</th>
            <th style="font-weight: bold; text-align: center; background-color: #2B4C7E; color: #FFFFFF;">Nominal Admin</th>
            <th style="font-weight: bold; text-align: center; background-color: #2B4C7E; color: #FFFFFF;">Nominal Transfer</th>
            <th style="font-weight: bold; text-align: center; background-color: #2B4C7E; color: #FFFFFF;">Nomor Telepon</th>
            <th style="font-weight: bold; text-align: center; background-color: #2B4C7E; color: #FFFFFF;">Status Verifikasi</th>
            <th style="font-weight: bold; text-align: center; background-color: #2B4C7E; color: #FFFFFF;">Tanggal Transaksi</th>
        </tr>
    </thead>
    
    <tbody>
        @foreach($daftar_bukti as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->nama_pengirim }}</td>
                <td>{{ $item->nama_penerima }}</td>
                <td>{{ $item->id_rekening }} </td>
                <td>Rp {{ number_format($item->nominal_admin, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($item->jumlah_transfer, 0, ',', '.') }}</td>
                <td>{{ $item->no_hp_pengirim }}</td>
                <td>{{ ucfirst($item->status_verifikasi) }}</td>
                <td>{{ $item->datetime_tgl }}</td>
            </tr>
        @endforeach
    </tbody>
</table>