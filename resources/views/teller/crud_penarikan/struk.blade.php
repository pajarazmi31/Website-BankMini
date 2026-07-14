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
    <strong>STRUK PENARIKAN</strong>
</div>

<div class="line"></div>

<table>
    <tr>
        <td class="label">No Transaksi</td>
        <td class="titik">:</td>
        <td>PN-{{ str_pad($penarikan->id, 5, '0', STR_PAD_LEFT) }}</td>
    </tr>

```
<tr>
    <td class="label">Tanggal</td>
    <td class="titik">:</td>
    <td>{{ $penarikan->created_at->format('d-m-Y H:i') }}</td>
</tr>

<tr>
    <td class="label">No Rekening</td>
    <td class="titik">:</td>
    <td>{{ $penarikan->id_rekening }}</td>
</tr>

<tr>
    <td class="label">Nama Penarik</td>
    <td class="titik">:</td>
    <td>{{ $penarikan->nama_penarik }}</td>
</tr>
```

</table>

<div class="line"></div>

<table>
    <tr>
        <td class="label">Nominal</td>
        <td class="titik">:</td>
        <td>
            Rp {{ number_format($penarikan->jumlah_penarikan,0,',','.') }}
        </td>
    </tr>

```
<tr>
    <td class="label">Biaya Admin</td>
    <td class="titik">:</td>
    <td>
        Rp {{ number_format($penarikan->biaya_transaksi,0,',','.') }}
    </td>
</tr>

<tr class="total">
    <td class="label">Total Biaya</td>
    <td class="titik">:</td>
    <td>
        Rp {{ number_format($penarikan->total_biaya,0,',','.') }}
    </td>
</tr>
```

</table>

<div class="line"></div>

<table>
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
            window.location.href = "{{ route('teller.penarikan') }}"
        }
    </script>
</body>
</html>
