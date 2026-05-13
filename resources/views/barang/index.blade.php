@extends('layouts.app')

@section('title', 'Daftar Barang')

@section('content')

<div class="container mt-4">
    <h1 class="mb-4">Daftar Barang</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <a href="{{ route('barang.create') }}"
       class="btn btn-primary mb-3">
        Tambah Barang
    </a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Kategori</th>
                <th>Supplier</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>

            @forelse($barangs as $barang)
                <tr>
                    <td>{{ $loop->iteration }}</td>

                    <td>
                        {{ $barang->nama_barang }}
                    </td>

                    <td>
                        Rp {{ number_format($barang->harga, 0, ',', '.') }}
                    </td>
                    <td>
                        {{ $barang->kategori->nama_kategori }}
                    </td>
                    <td>
                        {{ $barang->supplier->nama_supplier }}
                    </td>
                    <td>
                        <a href="{{ route('barang.edit', $barang->id) }}"
                           class="btn btn-warning btn-sm">
                            Edit
                        </a>
                        <form action="{{ route('barang.destroy', $barang->id) }}"
                              method="POST"
                              class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin hapus data?')">

                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6"
                        class="text-center">
                        Data barang kosong
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection