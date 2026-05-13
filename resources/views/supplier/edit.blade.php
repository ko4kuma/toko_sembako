@extends('layouts.app')
@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Supplier</h4>
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
                    <form action="{{ route('supplier.update', $supplier) }}"
                          method="POST">
                        @method('PUT')
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">
                                Nama Supplier
                            </label>
                            <input type="text"
                                   name="nama_supplier"
                                   class="form-control"
                                   value="{{ old('nama_supplier',  $supplier->nama_supplier) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                Alamat
                            </label>
                            <textarea name="alamat"
                                      class="form-control"
                                      rows="3">{{ old('alamat', $supplier->alamat) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                No HP
                            </label>
                            <input type="text"
                                   name="no_hp"
                                   class="form-control"
                                   value="{{ old('no_hp', $supplier->no_hp) }}">
                        </div>
                        <button type="submit"
                                class="btn btn-primary">
                            Simpan
                        </button>
                        <a href="{{ route('supplier.index') }}"
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