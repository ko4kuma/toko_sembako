@extends('layouts.app')
@section('title', 'Detail Pembelian')
@section('content')

<div class="container mt-4">

    <h1 class="mb-4">Detail Pembelian</h1>

    {{-- INFO PEMBELIAN --}}
    <table class="table table-bordered mb-4">

        <tr>
            <th width="200">Supplier</th>
            <td>
                @if($pembelian->supplier)
                    {{ $pembelian->supplier->nama_supplier }}
                @else
                    -
                @endif
            </td>
        </tr>

        <tr>
            <th>Tanggal</th>
            <td>{{ $pembelian->tanggal }}</td>
        </tr>

        <tr>
            <th>Total</th>
            <td>Rp {{ number_format($pembelian->total) }}</td>
        </tr>
        <tr>
            <th>Dicatat Oleh</th>
            <td>{{ $pembelian->user->name ?? '-' }}</td>
        </tr>

    </table>

    {{-- DETAIL BARANG --}}
    <table class="table table-bordered">

        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Qty</th>
            <th>Harga Beli</th>
            <th>Subtotal</th>
        </tr>

        @foreach($detail as $d)

        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $d->barang->nama_barang }}</td>
            <td>{{ $d->qty }}</td>
            <td>Rp {{ number_format($d->harga_beli) }}</td>
            <td>Rp {{ number_format($d->subtotal) }}</td>
        </tr>

        @endforeach

    </table>

    <a href="{{ route('pembelian.index') }}" class="btn btn-secondary">
        Kembali
    </a>

</div>

@endsection