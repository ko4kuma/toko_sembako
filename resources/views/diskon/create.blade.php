@extends('layouts.app')
@section('title', 'Tambah Diskon')
@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Tambah Diskon</h4>
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
                    <form action="{{ route('diskon.store') }}"
                          method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">
                                Nama Diskon
                            </label>
                            <input type="text"
                                   name="nama_diskon"
                                   class="form-control"
                                   placeholder="Masukkan nama diskon"
                           required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                Tipe Diskon
                                <select name="tipe" class="form-select" required>
                                    <option value="">-- Pilih Tipe --</option>
                                    @foreach(\App\Models\Diskon::TIPE as $value => $label)
                                        <option value="{{ $value }}">
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                Syarat Minimal Pembelian
                            </label>
                            <input type="number"
                                   name="syarat_minimal"
                                   class="form-control"
                                   placeholder="Masukkan syarat minimal"
                           required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                Berlaku mulai
                            </label>
                            <div class="d-flex align-items-center gap-2">
                                <input type="date"
                                       name="berlaku_mulai"
                                       class="form-control"
                                       min="{{ now()->toDateString() }}"
                                       value="{{ ('berlaku_mulai') }}"
                               >
                               <span>sampai</span>
                               <input type="date"
                                      name="berlaku_sampai"
                                      class="form-control"
                                      min="{{ now()->toDateString() }}"
                                      value="{{ ('berlaku_sampai') }}"
                              >

                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                Persentase (%)
                            </label>
                            <input type="number"
                           name="persentase"
                           class="form-control"
                           placeholder="Contoh: 10"
                           min="0"
                           max="100"
                           step="0.01"
                           required>
                        </div>

                        <button type="submit"
                                class="btn btn-primary">
                            Simpan
                        </button>
                        <a href="{{ route('diskon.index') }}"
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