<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<style>
body{
    font-family: Arial, sans-serif;
    font-size: 12px;
    margin: 20px;
}

.title{
    text-align:center;
    margin-bottom:20px;
}

.line{
    border-top:1px dashed #000;
    margin:10px 0;
}

table{
    width:100%;
    border-collapse:collapse;
}

td{
    padding:3px 0;
    vertical-align:top;
}

.label{
    width:100px;
}

.titik{
    width:10px;
}

.total{
    font-weight:bold;
    font-size:14px;
}

.footer{
    margin-top:20px;
    text-align:center;
}
</style>

</head>
<body onload="window.print()">

<div class="title">
    <h2>BANK MINI</h2>
    <strong>STRUK TRANSFER</strong>
</div>

<div class="line"></div>

<table>
    <tr>
        <td class="label">Nama Pengirim</td>
        <td class="titik">:</td>
        <td>{{ optional($transfer->rekeningPengirim->nasabah)->nama_nasabah ?? '-' }}</td>
    </tr>

    <tr>
        <td class="label">Rek Pengirim</td>
        <td class="titik">:</td>
        <td>{{ $transfer->id_rekening_pengirim }}</td>
    </tr>

    <tr>
        <td class="label">Nama Penerima</td>
        <td class="titik">:</td>
        <td>{{ optional($transfer->rekeningPenerima->nasabah)->nama_nasabah ?? '-' }}</td>
    </tr>

    <tr>
        <td class="label">Rek Penerima</td>
        <td class="titik">:</td>
        <td>{{ $transfer->id_rekening_penerima }}</td>
    </tr>
</table>

<div class="line"></div>

<table>
    <tr>
        <td class="label">Nominal</td>
        <td class="titik">:</td>
        <td>
            Rp {{ number_format($transfer->jumlah_transfer,0,',','.') }}
        </td>
    </tr>

    <tr>
        <td class="label">Biaya Admin</td>
        <td class="titik">:</td>
        <td>
            Rp {{ number_format($transfer->total_biaya - $transfer->jumlah_transfer,0,',','.') }}
        </td>
    </tr>

    <tr class="total">
        <td class="label">Total Biaya</td>
        <td class="titik">:</td>
        <td>
            Rp {{ number_format($transfer->total_biaya,0,',','.') }}
        </td>
    </tr>
</table>

<div class="line"></div>

<table>
    <tr>
        <td class="label">Catatan</td>
        <td class="titik">:</td>
        <td>{{ $transfer->catatan ?: '-' }}</td>
    </tr>

    <tr>
        <td class="label">Petugas</td>
        <td class="titik">:</td>
        <td>{{ $user->name }}</td>
    </tr>
</table>

<div class="footer">
    <div class="line"></div>
    Terima Kasih Telah Menggunakan Layanan Kami
</div>

<script>
    window.onafterprint = function() {
        window.location.href = "{{ route('teller.transfer') }}"
    }
</script>

</body>
</html>
