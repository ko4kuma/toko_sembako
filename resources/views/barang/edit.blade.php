@extends('layouts.app')
@section('title', 'Edit Barang')
@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card">
                <div class="card-header">
                    <h4>Edit Barang</h4>
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

                    <form action="{{ route('barang.update', $barang) }}"
                          method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">
                                Nama Barang
                            </label>
                            <input type="text"
                                   name="nama_barang"
                                   class="form-control"
                                   value="{{ old('nama_barang', $barang->nama_barang) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                Harga
                            </label>

                            <input type="number"
                                   name="harga"
                                   class="form-control"
                                   step="0.01"
                                   min="0"
                                   value="{{ old('harga', $barang->harga) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                Kategori
                            </label>

                            <select name="kategori_id"
                                    class="form-select">

                                <option value="">
                                    -- Pilih Kategori --
                                </option>

                                @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}"
                                        {{ old('kategori_id', $barang->kategori_id) == $kategori->id ? 'selected' : '' }}>

                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach

                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                Supplier
                            </label>

                            <select name="supplier_id"
                                    class="form-select">

                                <option value="">
                                    -- Pilih Supplier --
                                </option>

                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}"
                                        {{ old('supplier_id', $barang->supplier_id) == $supplier->id ? 'selected' : '' }}>

                                        {{ $supplier->nama_supplier }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        <button type="submit"
                                class="btn btn-primary">
                            Update
                        </button>

                        <a href="{{ route('barang.index') }}"
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