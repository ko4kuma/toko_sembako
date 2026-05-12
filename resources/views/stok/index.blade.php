@extends('layout.index')

@section('content')

<div class="container py-4">

    <div class="card border-0">

        {{-- CARD HEADER --}}
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">

                <h5 class="mb-0 fw-bold ">
                    Data Stok
                </h5>

                <a href="{{ route('stok.create') }}" class="btn btn-light btn-sm fw-semibold bg-success text-white">
                    + Tambah
                </a>

            </div>
        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-primary">
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

        </div>
    </div>

</div>

@endsection