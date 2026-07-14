@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <h3>Detail Transaksi</h3>

    {{-- INFO TRANSAKSI --}}
    <table class="table table-bordered mb-4">

        <tr>
            <th width="200">Nama Member</th>
            <td>{{ $transaksi->member->nama_member }}</td>
        </tr>

        <tr>
            <th>Tanggal</th>
            <td>{{ $transaksi->tanggal }}</td>
        </tr>

        <tr>
            <th>Total</th>
            <td>Rp {{ number_format($transaksi->total) }}</td>
        </tr>

    </table>

    {{-- DETAIL BARANG --}}
    <table class="table table-bordered">

        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Qty</th>
            <th>Subtotal</th>
        </tr>

        @foreach($detail as $d)

        <tr>

            <td>{{ $loop->iteration }}</td>

            <td>
                {{ $d->barang->nama_barang }}
            </td>

            {{-- HARGA BARANG --}}
            <td>
                Rp {{ number_format($d->harga_satuan) }}
            </td>

            {{-- QTY --}}
            <td>
                {{ $d->qty }}
            </td>

            {{-- SUBTOTAL --}}
            <td>
                Rp {{ number_format($d->subtotal) }}
            </td>

        </tr>

        @endforeach

    </table>

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