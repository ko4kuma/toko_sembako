<!DOCTYPE html>
<html>
<head>
    <title>Laporan Omset & Laba Rugi</title>

    <style>
        body {
            font-family: Arial;
            margin: 40px;
        }

        h3 {
            text-align: center;
        }

        p.center {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        .laba {
            font-weight: bold;
        }

        @media print {
            .btn-print {
                display: none;
            }
        @page {
            margin: 0;
        }
        }
    </style>
</head>
<body onload="window.print()">

    <h3>LAPORAN OMSET & LABA RUGI</h3>
    <p class="center">Toko Sembako</p>
    <p class="center">
        Periode: {{ \Carbon\Carbon::parse($dari)->format('d/m/Y') }}
        &mdash;
        {{ \Carbon\Carbon::parse($sampai)->format('d/m/Y') }}
    </p>

    <table>
        <tr>
            <th width="250">Omset (Penjualan)</th>
            <td>Rp {{ number_format($omset) }}</td>
        </tr>
        <tr>
            <th>Modal (Pembelian)</th>
            <td>Rp {{ number_format($modal) }}</td>
        </tr>
        <tr class="laba">
            <th>Laba Kotor</th>
            <td>Rp {{ number_format($labaKotor) }}</td>
        </tr>
    </table>
    <h4 style="margin-top:30px;">Rincian Transaksi Penjualan</h4>
<table>
    <tr>
        <th>Tanggal</th>
        <th>Kasir</th>
        <th>Member</th>
        <th>Total</th>
    </tr>
    @forelse($daftarTransaksi as $t)
    <tr>
        <td>{{ $t->tanggal }}</td>
        <td>{{ $t->user->name ?? '-' }}</td>
        <td>{{ $t->member->nama_member ?? 'Non Member' }}</td>
        <td>Rp {{ number_format($t->total_akhir) }}</td>
    </tr>
    @empty
    <tr>
        <td colspan="4">Tidak ada transaksi</td>
    </tr>
    @endforelse
</table>

<h4>Rincian Pembelian</h4>
<table>
    <tr>
        <th>Tanggal</th>
        <th>Purchasing</th>
        <th>Supplier</th>
        <th>Total</th>
    </tr>
    @forelse($daftarPembelian as $p)
    <tr>
        <td>{{ $p->tanggal }}</td>
        <td>{{ $p->user->name ?? '-' }}</td>
        <td>{{ $p->supplier->nama_supplier ?? '-' }}</td>
        <td>Rp {{ number_format($p->total) }}</td>
    </tr>
    @empty
    <tr>
        <td colspan="4">Tidak ada pembelian</td>
    </tr>
    @endforelse
</table>
    <br>

    <button onclick="window.print()" class="btn-print">
        Print
    </button>

</body>
</html>