@extends('layouts.app')
@section('title', 'Riwayat Pembelian')
@section('content')

<div class="container mt-4">

    <h1 class="mb-4">Riwayat Pembelian</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('pembelian.create') }}" class="btn btn-primary mb-3">
        + Tambah Pembelian
    </a>

    <table class="table table-bordered">

        <tr>
            <th>No</th>
            <th>Supplier</th>
            <th>Tanggal</th>
            <th>Total</th>
            <th width="200">Dicatat oleh</th>
            <th>Aksi</th>
        </tr>

        @forelse($pembelian as $p)

        <tr>

            <td>{{ $loop->iteration }}</td>
            <td>
                @if($p->supplier)
                    {{ $p->supplier->nama_supplier }}
                @else
                    -
                @endif
            </td>
            <td>{{ $p->tanggal }}</td>
            <td>Rp {{ number_format($p->total) }}</td>
            <td>{{ $p->user->name ?? '-' }}</td>
            <td>
                <a href="{{ route('pembelian.detail', $p->id) }}" class="btn btn-info btn-sm">
                    Detail
                </a>
            
                <a href="{{ route('pembelian.edit', $p->id) }}"
                class="btn btn-warning btn-sm">
                Edit
            </a>
            </td>
        </tr>

        @empty
        <tr>
            <td colspan="5" class="text-center py-4 text-muted">
                Belum ada data pembelian
            </td>
        </tr>
        @endforelse

    </table>

</div>

@endsection