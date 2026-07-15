@extends('layouts.app')
@section('content')

<div class="container mt-4">


    <table class="table table-bordered">

        <tr>
            <th>No</th>
            <th>ID Transaksi</th>
            <th>ID Barang</th>
            <th>Qty</th>
            <th>Subtotal</th>
            <th>Aksi</th>
        </tr>

        @foreach($detail as $d)

        <tr>

            <td>{{ $loop->iteration }}</td>
            <td>{{ $d->transaksi_id }}</td>
            <td>{{ $d->barang->nama_barang }}</td>
            <td>{{ $d->qty }}</td>
            <td>{{ $d->subtotal }}</td>

            <td>


                <form action="{{ route('detail-transaksi.destroy',$d->id) }}"
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