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
    width:90px;
}

.separator{
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
    <strong>STRUK PENYETORAN</strong>
</div>

<div class="line"></div>

<table>
    <tr>
        <td class="label">No Transaksi</td>
        <td class="separator">:</td>
        <td>ST-{{ str_pad($setoran->id, 5, '0', STR_PAD_LEFT) }}</td>
    </tr>

    <tr>
        <td class="label">Tanggal</td>
        <td class="separator">:</td>
        <td>{{ $setoran->created_at->format('d-m-Y H:i') }}</td>
    </tr>

    <tr>
        <td class="label">No Rekening</td>
        <td class="separator">:</td>
        <td>{{ $setoran->id_rekening }}</td>
    </tr>

    <tr>
        <td class="label">Nasabah</td>
        <td class="separator">:</td>
        <td>{{ $setoran->nama_lengkap }}</td>
    </tr>

    <tr>
        <td class="label">Penyetor</td>
        <td class="separator">:</td>
        <td>{{ $setoran->nama_penyetor }}</td>
    </tr>

    <tr>
        <td class="label">Petugas</td>
        <td class="separator">:</td>
        <td>{{ $user->name }}</td>
    </tr>
</table>

<div class="line"></div>

<table>
    <tr>
        <td class="label">Nominal Setoran</td>
        <td class="separator">:</td>
        <td>
            Rp {{ number_format($setoran->jumlah_penyetoran, 0, ',', '.') }}
        </td>
    </tr>

    <tr>
        <td class="label">Biaya Admin</td>
        <td class="separator">:</td>
        <td>
            Rp {{ number_format(optional($setoran->transaksi)->nominal ?? 0, 0, ',', '.') }}
        </td>
    </tr>

    <tr class="total">
        <td class="label">Total</td>
        <td class="separator">:</td>
        <td>
            Rp {{ number_format($setoran->total_biaya, 0, ',', '.') }}
        </td>
    </tr>
</table>

<div class="line"></div>

<table>
    <tr>
        <td class="label">Terbilang</td>
        <td class="separator">:</td>
        <td>{{ $setoran->uang_terbilang }}</td>
    </tr>
</table>

<div class="footer">
    <div class="line"></div>
    Terima Kasih Telah Menabung
</div>

<script>
    window.onafterprint = function() {
        window.location.href = "{{ route('teller.setoran') }}"
    }
</script>

</body>
</html>
