@extends('layout.index')

@section('content')

<div class="container py-4">

    <div class="card  border-1">

        <div class="card-header bg-success text-white text-center">
            <h5 class="mb-0 fw-bold">
                Tambah Stok
            </h5>
        </div>

        <div class="card-body">

            <form action="{{ route('stok.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Barang</label>
                    <select name="barang_id" class="form-select" required>
                        <option value="">Pilih Barang</option>
                        @foreach($barang as $b)
                            <option value="{{ $b->id }}">
                                {{ $b->nama_barang }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Jumlah</label>
                    <input type="number" name="jumlah" class="form-control" placeholder="Masukkan jumlah" required>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">

                    <a href="{{ route('stok.index') }}" class="btn btn-secondary px-4">
                        Kembali
                    </a>

                    <button type="submit" class="btn btn-success px-4">
                        Simpan
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection