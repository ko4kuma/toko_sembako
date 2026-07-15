@extends('layouts.app')
@section('title', 'Pergerakan Stok')
@section('content')

    <div class="container mt-4">
        <h1 class="mb-4">Pergerakan Stok</h1>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="60">No</th>
                    <th>Tanggal</th>
                    <th>Barang</th>
                    <th>Jenis</th>
                    <th width="120">Jumlah</th>
                    <th>Stok Sebelum</th>
                    <th>Stok Sesudah</th>
                    <th>Referensi</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($stok as $i => $s)
                    <tr>
                        <td class="text-muted">
                            {{ $i + 1 }}
                        </td>
                        <td>
                            {{ $s->created_at->format('d/m/Y H:i') }}
                        </td>

                        <td class="fw-semibold">
                            {{ $s->barang->nama_barang }}
                        </td>

                        <td>
                            @if($s->jenis === 'masuk')
                                <span class="badge bg-success">Masuk</span>
                            @elseif($s->jenis === 'keluar')
                                <span class="badge bg-danger">Keluar</span>
                            @else
                                <span class="badge bg-warning text-dark">Penyesuaian</span>
                            @endif
                        </td>

                        <td>
                            {{ $s->jumlah }}
                        </td>

                        <td>
                            {{ $s->stok_sebelum }}
                        </td>

                        <td>
                            {{ $s->stok_sesudah }}
                        </td>

                        <td>
                            @if($s->referensi_type === \App\Models\Transaksi::class)
                                <a href="{{ route('transaksi.detail', $s->referensi_id) }}">
                                    Transaksi #{{ $s->referensi_id }}
                                </a>
                            @elseif($s->referensi_type === \App\Models\Pembelian::class)
                                <a href="{{ route('pembelian.detail', $s->referensi_id) }}">
                                    Pembelian #{{ $s->referensi_id }}
                                </a>
                            @elseif($s->referensi_type === \App\Models\StokOpname::class)
                                <a href="{{ route('stok-opname.isi', $s->referensi_id) }}">
                                    Opname #{{ $s->referensi_id }}
                                </a>
                            @else
                                Manual
                            @endif
                        </td>
                        <td>
                            {{ $s->keterangan ?? '-' }}
                        </td>
                        
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-4 text-muted">
                            Belum ada data stok
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection