<!DOCTYPE html>
<html>
<head>
    <title>Struk Transaksi</title>

    <style>
        body {
            font-family: Arial;
        }

        .struk {
            width: 300px;
            margin: auto;
        }

        h3 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #000;
            font-size: 12px;
        }

        th, td {
            padding: 5px;
            text-align: left;
        }

        .center {
            text-align: center;
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

<div class="struk">

    <h3>STRUK TRANSAKSI</h3>
    <p class="center">Toko Sembako</p>
    <hr>

    <p>
        <b>Member:</b> 
        @if($transaksi->member)
            {{ $transaksi->member->nama_member }}
        @else
            Non Member
        @endif
    </p>
    <p><b>Tanggal:</b> {{ $transaksi->tanggal }}</p>
    <p><b>Kasir:</b> {{ $transaksi->user->name ?? '-' }}</p>

    <hr>

    <table>

        <tr>
            <th>Nama Barang</th>
            <th>Qty</th>
            <th>Harga</th>
        </tr>

        @foreach($detail as $d)

        <tr>
            <td>{{ $d->barang->nama_barang }}</td>
            <td>{{ $d->qty }}</td>
            <td>Rp {{ number_format($d->subtotal) }}</td>
        </tr>

        @endforeach

    </table>

    <hr>

    <p><b>Subtotal:</b> Rp {{ number_format($transaksi->total) }}</p>
    <p><b>Diskon:</b>
        @if($transaksi->diskon > 0)
            Rp {{ number_format($transaksi->diskon) }}
        @else
            -
        @endif
    </p>
    <p><b>Total Akhir:</b> Rp {{ number_format($transaksi->total_akhir) }}</p>

    <hr>

    <p><b>Metode:</b> {{ ucfirst($transaksi->pembayaran->metode ?? '-') }}</p>
    <p><b>Dibayar:</b> Rp {{ number_format($transaksi->pembayaran->jumlah ?? 0) }}</p>
    <p><b>Kembalian:</b> Rp {{ number_format($transaksi->pembayaran->kembalian ?? 0) }}</p>
    
    <br>

    <button onclick="window.print()" class="btn-print">
        Print
    </button>

</div>

</body>
</html>