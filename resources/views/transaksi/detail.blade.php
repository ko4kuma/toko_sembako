@extends('layouts.app')
@section('title', 'Detail Transaksi')
@section('content')

<div class="container mt-4">

    <h3>Detail Transaksi</h3>

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

    </table>

    {{-- DETAIL BARANG --}}
    <table class="table table-bordered">

        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Qty</th>
            <th>Subtotal</th>
            <th>Diskon</th>
            <th>Subtotal Akhir</th>
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
            
            {{-- NOMINAL DISKON --}}
            <td>
                @if($d->transaksi->diskon > 0)
                    Rp {{ number_format($d->transaksi->diskon) }}
                @else
                    -
                @endif
            </td>

            {{-- SUBTOTAL AKHIR --}}
            <td>
                Rp {{ number_format($d->transaksi->total_akhir) }}
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