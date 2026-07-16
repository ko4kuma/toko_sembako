@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="container py-4">
    <h2 class="mb-3">Dashboard</h2>
    <div class="row g-3">
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title">Selamat datang</h5>
                    <p class="card-text">Halo, {{ auth()->user()->name ?? auth()->user()->email }}.</p>
                </div>
            </div>
        </div>
    </div>
    {{-- cek kondisi role --}}
    @if(auth()->user()->role === 'admin')
    <div class="row g-3 mt-1">

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Omset Hari Ini</h6>
                    <h4>Rp {{ number_format($omsetHariIni) }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Modal Hari Ini</h6>
                    <h4>Rp {{ number_format($modalHariIni) }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Laba Hari Ini</h6>
                    <h4 class="{{ $labaHariIni >= 0 ? 'text-success' : 'text-danger' }}">
                        Rp {{ number_format($labaHariIni) }}
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Opname Menunggu Approval</h6>
                    <h4>{{ $opnamePending }}</h4>
                </div>
            </div>
        </div>

    </div>

    <div class="row g-3 mt-1">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted mb-3">Breakdown Metode Pembayaran (Hari Ini)</h6>
                    <canvas id="pieMetode" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if(auth()->user()->role === 'kasir')
    <div class="row g-3 mt-1">

        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Transaksi Saya Hari Ini</h6>
                    <h4>{{ $jumlahTransaksiHariIni }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Omset Saya Hari Ini</h6>
                    <h4>Rp {{ number_format($omsetHariIniSaya) }}</h4>
                </div>
            </div>
        </div>

    </div>
    @endif

    @if(auth()->user()->role === 'gudang')
    <div class="row g-3 mt-1">

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Opname Draft Saya</h6>
                    <h4>{{ $opnameDraft }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Menunggu Approval</h6>
                    <h4>{{ $opnameMenungguSaya }}</h4>
                </div>
            </div>
        </div>

    </div>

    <div class="row g-3 mt-3">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted mb-3">Stok Menipis (&lt; 10)</h6>
                    <table class="table table-sm table-bordered mb-0">
                        <tr>
                            <th>Nama Barang</th>
                            <th>Stok</th>
                        </tr>
                        @forelse($stokMenipis as $b)
                        <tr>
                            <td>{{ $b->nama_barang }}</td>
                            <td>{{ $b->stokTerkini() }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted">Tidak ada barang dengan stok menipis</td>
                        </tr>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if(auth()->user()->role === 'purchasing')
    <div class="row g-3 mt-1">

        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Pembelian Bulan Ini</h6>
                    <h4>{{ $jumlahPembelianBulanIni }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Total Belanja Bulan Ini</h6>
                    <h4>Rp {{ number_format($totalBelanjaBulanIni) }}</h4>
                </div>
            </div>
        </div>

    </div>
    @endif
</div>
@endsection
@if(auth()->user()->role === 'admin')
@push('scripts')
<script>
    const ctx = document.getElementById('pieMetode');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($pieMetode->keys()) !!},
            datasets: [{
                data: {!! json_encode($pieMetode->values()) !!},
                backgroundColor: ['#0d6efd', '#198754', '#ffc107', '#dc3545']
            }]
        }
    });
</script>
@endpush
@endif