@extends('layout.index')

@section('content')
    <div class="container py-4">

        <div class="card border-0">

            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">

                    <h5 class="mb-0 fw-bold">
                        Data Pembayaran
                    </h5>

                    <a href="{{ route('pembayaran.create') }}" class="btn btn-success btn-sm fw-semibold">
                        + Tambah
                    </a>

                </div>
            </div>
            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-primary">
                            <tr>
                                <th>No</th>
                                <th>Member</th>
                                <th>Metode</th>
                                <th>Total Bayar</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($pembayaran as $i => $p)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td class="fw-semibold">
                                        {{ $p->transaksi->member->nama_member ?? 'Non Member' }}
                                    </td>
                                    <td>
                                        <span>
                                            {{ $p->metode }}
                                        </span>
                                    </td>
                                    <td class="">
                                        Rp {{ number_format($p->jumlah, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        <span class="badge bg-success">
                                            Lunas
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('pembayaran.edit', $p->id) }}" class="btn btn-sm btn-warning">
                                            Edit
                                        </a>
                                        <form action="{{ route('pembayaran.destroy', $p->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Yakin ingin hapus data ini?')">
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
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        Belum ada data pembayaran
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
