@extends('layout')

@section('content')

<div class="container mt-4">

    <a href="{{ route('transaksi.create') }}"
       class="btn btn-primary mb-3">

       Tambah Transaksi
    </a>

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
        <td>{{ $t->member->nama_member }}</td>
        <td>{{ $t->tanggal }}</td>
        <td>Rp {{ $t->total }}</td>

        <td>
            <a href="{{ route('transaksi.detail',$t->id) }}"
            class="btn btn-info btn-sm">

            Detail

            </a>
            <a href="{{ route('transaksi.edit',$t->id) }}"
               class="btn btn-warning btn-sm">

               Edit
            </a>
            

            <form action="{{ route('transaksi.destroy',$t->id) }}"
                  method="POST"
                  style="display:inline">

                @csrf
                @method('DELETE')

                <button class="btn btn-danger btn-sm">
                    Hapus
                </button>

            </form>

        </td>

    </tr>

    @endforeach

</table>

</div>

@endsection