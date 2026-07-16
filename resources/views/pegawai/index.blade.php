@extends('layouts.app')
@section('title', 'Data Pegawai')
@section('content')

    <div class="container mt-4">
        <h1 class="mb-4">Data Pegawai</h1>

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

        <a href="{{ route('pegawai.create') }}" class="btn btn-primary mb-3">
            Tambah Pegawai
        </a>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="60">No</th>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>No HP</th>
                    <th>Tanggal Masuk</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pegawai as $i => $p)
                    <tr>
                        <td class="text-muted">
                            {{ $i + 1 }}
                        </td>

                        <td class="fw-semibold">
                            {{ $p->nama_lengkap }}
                        </td>

                        <td>
                            {{ $p->user->email ?? '-' }}
                        </td>

                        <td>
                            <span class="badge bg-info text-dark">
                                {{ ucfirst($p->user->role ?? '-') }}
                            </span>
                        </td>

                        <td>
                            {{ $p->no_hp ?? '-' }}
                        </td>

                        <td>
                            {{ $p->tanggal_masuk ?? '-' }}
                        </td>

                        <td>
                            <a href="{{ route('pegawai.edit', $p->id) }}"
                                class="btn btn-sm btn-warning me-1">
                                Edit
                            </a>

                            @if($p->user_id !== auth()->id())
                            <form action="{{ route('pegawai.destroy', $p->id) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Yakin ingin hapus pegawai ini? Akun login-nya juga akan ikut terhapus.')">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm btn-danger">
                                    Hapus
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            Belum ada data pegawai
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection