@extends('layouts.app')
@section('title', 'Edit Stok')
@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Stok</h4>
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
                    <form action="{{ route('stok.update', $stok->id) }}"
                          method="POST">
                        @method('PUT')
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Barang</label>
                            <select name="barang_id" class="form-select" required>
                                <option value="">Pilih Barang</option>

                                @foreach($barang as $b)
                                    <option value="{{ $b->id }}"
                                        {{ $stok->barang_id == $b->id ? 'selected' : '' }}>
                                        {{ $b->nama_barang }}
                                    </option>
                                @endforeach

                            </select>
                        </div>        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Jumlah</label>
                            <input type="number"
                                name="jumlah"
                                class="form-control"
                                value="{{ $stok->jumlah }}"
                                required>
                        </div> 
                        <button type="submit"
                                class="btn btn-primary">
                            Update
                        </button>
                        <a href="{{ route('stok.index') }}"
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