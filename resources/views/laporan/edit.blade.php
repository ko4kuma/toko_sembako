@extends('layouts.app')
@section('title', 'Edit Pegawai')
@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card">
                <div class="card-header">
                    <h4>Edit Pegawai</h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('pegawai.update', $pegawai->id) }}"
                          method="POST">

                        @csrf
                        @method('PUT')

                        <h6 class="text-muted">Data Pribadi</h6>

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text"
                                   name="nama_lengkap"
                                   class="form-control"
                                   value="{{ old('nama_lengkap', $pegawai->nama_lengkap) }}"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">No HP</label>
                            <input type="text"
                                   name="no_hp"
                                   class="form-control"
                                   value="{{ old('no_hp', $pegawai->no_hp) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat"
                                      class="form-control"
                                      rows="2">{{ old('alamat', $pegawai->alamat) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Masuk</label>
                            <input type="date"
                                   name="tanggal_masuk"
                                   class="form-control"
                                   value="{{ old('tanggal_masuk', optional($pegawai->tanggal_masuk)->format('Y-m-d')) }}">
                        </div>

                        <hr>

                        <h6 class="text-muted">Akun Login</h6>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email"
                                   name="email"
                                   class="form-control"
                                   value="{{ old('email', $pegawai->user->email) }}"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password"
                                   name="password"
                                   class="form-control"
                                   placeholder="Kosongkan jika tidak ingin mengubah password">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-select" required>
                                <option value="admin" {{ old('role', $pegawai->user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="kasir" {{ old('role', $pegawai->user->role) == 'kasir' ? 'selected' : '' }}>Kasir</option>
                                <option value="gudang" {{ old('role', $pegawai->user->role) == 'gudang' ? 'selected' : '' }}>Gudang</option>
                                <option value="purchasing" {{ old('role', $pegawai->user->role) == 'purchasing' ? 'selected' : '' }}>Purchasing</option>
                            </select>
                        </div>

                        <button type="submit"
                                class="btn btn-primary">
                            Update
                        </button>

                        <a href="{{ route('pegawai.index') }}"
                           class="btn btn-secondary">
                            Kembali
                        </a>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection