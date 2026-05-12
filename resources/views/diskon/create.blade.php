@extends('layout.index')

@section('content')

<div class="container py-4">

    <div class="card border-1">

        <div class="card-header bg-success text-white text-center">
            <h5 class="mb-0 fw-bold">
                Tambah Diskon
            </h5>
        </div>

        <div class="card-body">

            <form action="{{ route('diskon.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Diskon</label>
                    <input type="text"
                           name="nama_diskon"
                           class="form-control"
                           placeholder="Masukkan nama diskon"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Persentase (%)</label>
                    <input type="number"
                           name="persentase"
                           class="form-control"
                           placeholder="Contoh: 10"
                           min="0"
                           max="100"
                           step="0.01"
                           required>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">

                    <a href="{{ route('diskon.index') }}" class="btn btn-secondary px-4">
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