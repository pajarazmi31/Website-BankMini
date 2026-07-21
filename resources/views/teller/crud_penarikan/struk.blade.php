<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<style>
@page {
    size: 80mm 150mm;
    margin: 0;
}

html, body {
    width: 80mm;
    height: 150mm;
    margin: 0;
    padding: 5mm;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
    font-size: 11px;
}

body {
    zoom: 100%;
}

.title {
    text-align: center;
    margin-bottom: 10px;
}

.title h2 {
    margin: 0;
    font-size: 18px;
}

.title strong {
    font-size: 13px;
}

.line {
    border-top: 1px dashed #000;
    margin: 8px 0;
}

table {
    width: 100%;
    border-collapse: collapse;
}

td {
    padding: 2px 0;
    vertical-align: top;
    word-break: break-word;
}

.label {
    width: 32%;
}

.separator {
    width: 5%;
    text-align: center;
}

.total {
    font-weight: bold;
    font-size: 12px;
}

.footer {
    margin-top: 15px;
    text-align: center;
    font-size: 11px;
}
</style>

</head>
<body onload="window.print()">

<div class="title">
    <h3 style="margin:0;">BANK MINI</h3>
    <div style="font-weight:bold; margin-top:3px;">SMKN 1 KAWALI</div>
    <div style="font-weight:bold; margin-top:3px;">JL.Talagasari, No.35, Kawalimukti</div>
    <div style="font-weight:bold; margin-top:3px;">STRUK PENARIKAN</div>
</div>

<div class="line"></div>

<table>

        <tr>
        <td class="label">No Transaksi</td>
        <td class="separator">:</td>
        <td>{{ 'PN-' . str_pad($penarikan->id, 5, '0', STR_PAD_LEFT) }}</td>
    </tr>

    <tr>
        <td class="label">Tanggal</td>
        <td class="separator">:</td>
        <td>{{ $penarikan->updated_at->format('d-m-Y H:i') }}</td>
    </tr>

    <tr>
        <td class="label">No Rekening</td>
        <td class="separator">:</td>
        <td>{{ $penarikan->id_rekening }}</td>
    </tr>

    <tr>
        <td class="label">Nama Penarik</td>
        <td class="separator">:</td>
        <td>{{ $penarikan->nama_penarik }}</td>
    </tr>

    <tr>
        <td class="label">Petugas</td>
        <td class="separator">:</td>
        <td>{{ optional($penarikan->petugas)->user->name ?? '-' }}</td>
    </tr>
</table>

<div class="line"></div>

<table>
    <tr>
        <td class="label">Nominal</td>
        <td class="separator">:</td>
        <td>
            Rp {{ number_format($penarikan->jumlah_penarikan,0,',','.') }}
        </td>
    </tr>

    <tr>
        <td class="label">Biaya Admin</td>
        <td class="separator">:</td>
        <td>
            Rp {{ number_format($penarikan->transaksi->nominal ?? 0,0,',','.') }}
        </td>
    </tr>

    <tr class="total">
        <td class="label">Total Biaya</td>
        <td class="separator">:</td>
        <td>
            Rp {{ number_format($penarikan->total_biaya,0,',','.') }}
        </td>
    </tr>
</table>

<div class="line"></div>

<table>
    <tr>
        <td class="label">Pembayaran</td>
        <td class="separator">:</td>
        <td>
            {{ $penarikan->pilihan_biaya_transaksi ?? 'Cash' }}
        </td>
    </tr>
</table>

<div style="height: 15px;"></div>

<!-- Ruang Tanda Tangan agar sama persis struk setoran -->
<div style="margin-top:20px;">
    <table style="width:100%; text-align:center;">
        <tr>
            <td style="width:50%;">Teller</td>
            <td style="width:50%;">Nasabah</td>
        </tr>
        <tr>
            <td style="height:60px;"></td>
            <td></td>
        </tr>
        <tr>
            <td>( <strong>{{ optional($penarikan->petugas)->user->name ?? '-' }}</strong> )</td>
            <td>( <strong>{{ $penarikan->nama_penarik }}</strong> )</td>
        </tr>
    </table>
</div>

<div class="footer">
    <div class="line"></div>
    Terima Kasih Telah Menggunakan Layanan Kami
    <div style="margin-top: 4px; font-weight: normal; font-size: 10px;">
        SMS/WA 0812-3456-7890
    </div>
</div>

<script>
    window.onafterprint = function() {
        window.close(); // Menutup tab struk ini secara otomatis
    }

    // Jaga-jaga jika onafterprint tidak terpicu di beberapa browser
    setTimeout(function() {
        window.close();
    }, 1000); // Tutup setelah 1 detik jika dialog cetak selesai/batal
</script>

</body>
</html>
