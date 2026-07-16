@extends('layouts.app')
@section('title', 'Laporan Omset & Laba Rugi')
@section('content')

<div class="container mt-4">

    <h3>Laporan Omset & Laba Rugi</h3>

    {{-- FORM FILTER --}}
    <form method="GET" action="{{ route('laporan.index') }}" class="row g-2 mb-4 align-items-end">

        <div class="col-md-3">
            <label class="form-label">Dari Tanggal</label>
            <input type="date" name="dari" class="form-control" value="{{ $dari }}" required>
        </div>

        <div class="col-md-3">
            <label class="form-label">Sampai Tanggal</label>
            <input type="date" name="sampai" class="form-control" value="{{ $sampai }}" required>
        </div>

        <div class="col-md-2">
            <button type="submit" class="btn btn-primary">
                Tampilkan
            </button>
        </div>

    </form>

    @if($sudahFilter)

    {{-- HASIL LAPORAN --}}
    <div class="card">
        <div class="card-body">

            <p class="text-muted mb-3">
                Periode: {{ \Carbon\Carbon::parse($dari)->format('d/m/Y') }}
                &mdash;
                {{ \Carbon\Carbon::parse($sampai)->format('d/m/Y') }}
            </p>

            <table class="table table-bordered">
                <tr>
                    <th width="250">Omset (Penjualan)</th>
                    <td>Rp {{ number_format($omset) }}</td>
                </tr>
                <tr>
                    <th>Modal (Pembelian)</th>
                    <td>Rp {{ number_format($modal) }}</td>
                </tr>
                <tr class="table-{{ $labaKotor >= 0 ? 'success' : 'danger' }}">
                    <th>Laba Kotor</th>
                    <td><strong>Rp {{ number_format($labaKotor) }}</strong></td>
                </tr>
            </table>


            <hr class="my-4">
            <h5>Rincian Penjualan</h5>
            <table class="table table-bordered table-sm">
                <tr>
                    <th>Tanggal</th>
                    <th>Kasir</th>
                    <th>Member</th>
                    <th>Total</th>
                </tr>
                @forelse($daftarTransaksi as $t)
                <tr>
                    <td>{{ $t->tanggal }}</td>
                    <td>{{ $t->user->name ?? '-' }}</td>
                    <td>{{ $t->member->nama_member ?? 'Non Member' }}</td>
                    <td>Rp {{ number_format($t->total_akhir) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">Tidak ada transaksi</td>
                </tr>
                @endforelse
            </table>

            <h5>Rincian Pembelian</h5>
            <table class="table table-bordered table-sm">
                <tr>
                    <th>Tanggal</th>
                    <th>Purchasing</th>
                    <th>Supplier</th>
                    <th>Total</th>
                </tr>
                @forelse($daftarPembelian as $p)
                <tr>
                    <td>{{ $p->tanggal }}</td>
                    <td>{{ $p->user->name ?? '-' }}</td>
                    <td>{{ $p->supplier->nama_supplier ?? '-' }}</td>
                    <td>Rp {{ number_format($p->total) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">Tidak ada pembelian</td>
                </tr>
                @endforelse
            </table>

            <a href="{{ route('laporan.print', ['dari' => $dari, 'sampai' => $sampai]) }}"
                target="_blank"
                class="btn btn-primary">

                    Cetak Laporan

            </a>
        </div>
    </div>

    @endif

</div>

@endsection