@extends('layouts.app')
@section('title', 'Tambah Kategori Barang')
@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Tambah Kategori Barang</h4>
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
                    <form action="{{ route('kategori.store') }}"
                          method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">
                                Nama Kategori Barang
                            </label>
                            <input type="text"
                                   name="nama_kategori"
                                   class="form-control"
                                   value="{{ old('nama_kategori') }}">
                        </div>
                        <button type="submit"
                                class="btn btn-primary">
                            Simpan
                        </button>
                        <a href="{{ route('kategori.index') }}"
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