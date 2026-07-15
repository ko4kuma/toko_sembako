@extends('layouts.app')
@section('title', 'Riwayat Penjualan')
@section('content')

<div class="container mt-4">

    <h1 class="mb-4">Riwayat Penjualan</h1>
    <table class="table table-bordered">

        <tr>
            <th>No</th>
            <th>Nama Member</th>
            <th>Tanggal</th>
            <th>Total</th>
            <th>Aksi</th>
        </tr>

        @foreach($transaksi as $t)

        <tr>

            <td>{{ $loop->iteration }}</td>
            <td>
                @if($t->member)
                    {{ $t->member->nama_member }}
                @else
                    Non Member
                @endif
            </td>
            <td>{{ $t->tanggal }}</td>
            <td>Rp {{ $t->total_akhir }}</td>


            <td>

                <a href="{{ route('transaksi.detail', $t->id) }}"
                   class="btn btn-info btn-sm">

                    Detail

                </a>

            </td>

        </tr>

        @endforeach

    </table>

</div>

@endsection