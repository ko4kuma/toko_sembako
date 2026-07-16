@extends('layouts.app')
@section('title', 'Detail Penjualan')
@section('content')

<div class="container mt-4">

    <h1 class="mb-4">Detail Penjualan</h1>

    {{-- INFO TRANSAKSI --}}
    <table class="table table-bordered mb-4">

        <tr>
            <th width="200">Nama Member</th>
            <td>
                @if($transaksi->member)
                    {{ $transaksi->member->nama_member }}
                @else
                    Non Member
                @endif
            </td>
        </tr>

        <tr>
            <th>Tanggal</th>
            <td>{{ $transaksi->tanggal }}</td>
        </tr>

        <tr>
            <th>Total Setelah Diskon</th>
            <td>Rp {{ number_format($transaksi->total_akhir) }}</td>
        </tr>
        <tr>
            <th>Kasir</th>
            <td>{{ $transaksi->user->name ?? '-' }}</td>
        </tr>

    </table>
    <hr>
    {{-- DETAIL BARANG --}}
    <table class="table table-bordered">

        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Harga Satuan</th>
            <th>Qty</th>
            <th>Harga</th>
        </tr>

        @foreach($detail as $d)

        <tr>

            <td>{{ $loop->iteration }}</td>

            <td>
                {{ $d->barang->nama_barang }}
            </td>

            {{-- HARGA SATUAN --}}
            <td>
                Rp {{ number_format($d->harga_satuan) }}
            </td>
            
            {{-- QTY --}}
            <td>
                {{ $d->qty }}
            </td>
            
            {{-- HARGA --}}
            <td>
                Rp {{ number_format($d->subtotal) }}
            </td>

        </tr>

        @endforeach

    </table>
        <hr>
        <div class="mb-4">
            <p class="mb-0"><strong>Subtotal:</strong> Rp {{ number_format($transaksi->total) }}</p>
            <p class="mb-1"><strong>Diskon:</strong>
                @if($transaksi->diskon > 0)
                    Rp {{ number_format($transaksi->diskon) }}
                @else
                    -
                @endif
            </p>
            <p class="mb-0"><strong>Total Akhir:</strong> Rp {{ number_format($transaksi->total_akhir) }}</p>
        </div>

        <hr>

        <div class="mb-4">
            <p class="mb-0"><strong>Metode Pembayaran:</strong> {{ ucfirst($transaksi->pembayaran->metode ?? '-') }}</p>
            <p class="mb-0"><strong>Jumlah Dibayar:</strong> Rp {{ number_format($transaksi->pembayaran->jumlah ?? 0) }}</p>
            <p class="mb-0"><strong>Kembalian:</strong> Rp {{ number_format($transaksi->pembayaran->kembalian ?? 0) }}</p>
        </div>

    <a href="/transaksi"
       class="btn btn-secondary">

       Kembali

    </a>
    
    <a href="{{ route('transaksi.struk', $transaksi->id) }}"
       target="_blank"
       class="btn btn-primary">

        Cetak Struk

    </a>

</div>

@endsection