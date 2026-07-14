@extends('layouts.app')
@section('title', 'Data Diskon')
@section('content')

    <div class="container mt-4">
        <h1 class="mb-4">Data Diskon</h1>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <a href="{{ route('diskon.create') }}" class="btn btn-primary mb-3">
            Tambah Diskon
        </a>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="60">No</th>
                    <th>Nama Diskon</th>
                    <th>Tipe</th>
                    <th>Syarat Minimal</th>
                    <th width="150">Persentase</th>
                    <th>Berlaku Mulai</th>
                    <th>Berlaku Sampai</th>
                    <th>Status</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($diskon as $i => $d)
                    <tr>
                        <td class="text-muted">
                            {{ $i + 1 }}
                        </td>

                        <td class="fw-semibold">
                            {{ $d->nama_diskon }}
                        </td>

                        <td>
                            {{ \App\Models\Diskon::TIPE[$d->tipe] ?? $d->tipe }}
                        </td>

                        <td>
                            Rp {{ number_format($d->syarat_minimal) }}
                        </td>

                        <td>
                            <span>
                                {{ $d->persentase }}%
                            </span>
                        </td>

                         <td>
                            {{ $d->berlaku_mulai ? $d->berlaku_mulai->format('d/m/Y') : '-' }}
                        </td>

                        <td>
                            {{ $d->berlaku_sampai ? $d->berlaku_sampai->format('d/m/Y') : '-' }}
                        </td>

                         <td>
                            @if($d->aktif)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('diskon.edit', $d->id) }}"
                                class="btn btn-sm btn-warning me-1">
                                Edit
                            </a>

                            
                            <form action="{{ route('diskon.destroy', $d->id) }}"
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
                        <td colspan="9" class="text-center py-4 text-muted">
                            Belum ada data diskon
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection