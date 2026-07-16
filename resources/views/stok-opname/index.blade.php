@extends('layouts.app')
@section('title', 'Stok Opname')
@section('content')

<div class="container mt-4">

    <h1 class="mb-4">Stok Opname</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @can('create', $stokOpname)
        <a href="{{ route('stok-opname.create') }}" class="btn btn-primary mb-3">
            Buat Sesi Opname Baru
        </a>
    @endcan

    <table class="table table-bordered">

        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Dibuat oleh</th>
            <th>Keterangan</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>

        @forelse($stokOpname as $s)
        <tr>

            <td>{{ $loop->iteration }}</td>
            <td>{{ $s->tanggal }}</td>
            <td>{{ $s->user->name ?? '-' }}</td>
            <td>{{ $s->keterangan ?? '-' }}</td>

            <td>
                @if($s->status === 'draft')
                    <span class="badge bg-secondary">Draft</span>
                @elseif($s->status === 'menunggu_approval')
                    <span class="badge bg-warning text-dark">Menunggu Approval</span>
                @else
                    <span class="badge bg-success">Disetujui</span>
                @endif
            </td>

            {{-- AKSI --}}
            <td>
                @can('edit', $s)
                    <a href="{{ route('stok-opname.isi', $s->id) }}"
                    class="btn btn-warning btn-sm">
                        Lanjutkan
                    </a>
                @endcan

                @cannot('edit', $s)
                    <a href="{{ route('stok-opname.isi', $s->id) }}"
                    class="btn btn-info btn-sm">
                        Lihat Detail
                    </a>
                @endcannot

                @can('delete', $s)
                    <form action="{{ route('stok-opname.destroy', $s->id) }}"
                        method="POST"
                        class="d-inline"
                        onsubmit="return confirm('Yakin ingin menghapus sesi opname ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">
                            Hapus
                        </button>
                    </form>
                @endcan
            </td>

        </tr>

        @empty
        <tr>
            <td colspan="6" class="text-center py-4 text-muted">
                Belum ada sesi opname
            </td>
        </tr>
        @endforelse

    </table>

</div>

@endsection