@extends('layouts.app')
@section('title', 'Daftar Stok')
@section('content')

    <div class="container mt-4">
        <h1 class="mb-4">Daftar Stok</h1>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <a href="{{ route('stok.create') }}" class="btn btn-primary mb-3">
            Tambah Stok
        </a>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="60">No</th>
                    <th>Barang</th>
                    <th width="150">Jumlah</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($stok as $i => $s)
                    <tr>
                        <td class="text-muted">
                            {{ $i + 1 }}
                        </td>

                        <td class="fw-semibold">
                            {{ $s->barang->nama_barang }}
                        </td>

                        <td>
                            <span ">
                                {{ $s->jumlah }}
                            </span>
                        </td>

                        <td>
                            <a href="{{ route('stok.edit', $s->id) }}"
                                class="btn btn-sm btn-warning me-1">
                                Edit
                            </a>

                            <form action="{{ route('stok.destroy', $s->id) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Yakin ingin hapus data ini?')">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm btn-danger">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">
                            Belum ada data stok
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection