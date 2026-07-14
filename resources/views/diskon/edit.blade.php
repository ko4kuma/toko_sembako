@extends('layouts.app')
@section('title', 'Edit Diskon')
@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Diskon</h4>
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
                   <form action="{{ route('diskon.update', $diskon->id) }}" method="POST">
                        @method('PUT')
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">
                                Nama Diskon
                            </label>
                            <input type="text"
                           name="nama_diskon"
                           class="form-control"
                           value="{{ $diskon->nama_diskon }}"
                           required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                Tipe Diskon
                                <select name="tipe" class="form-select" required>
                                    <option value="">-- Pilih Tipe --</option>
                                    @foreach(\App\Models\Diskon::TIPE as $value => $label)
                                        <option value="{{ $value }}" {{ old('tipe', $diskon->tipe) == $value ? 'selected' : '' }}>
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
                                   value="{{ $diskon->syarat_minimal }}"
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
                                       value="{{ old('berlaku_mulai', optional($diskon->berlaku_mulai)->format('Y-m-d')) }}"
                               >
                               <span>sampai</span>
                               <input type="date"
                                      name="berlaku_sampai"
                                      class="form-control"
                                      min="{{ now()->toDateString() }}"
                                      value="{{ old('berlaku_sampai', optional($diskon->berlaku_sampai)->format('Y-m-d')) }}"
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
                           value="{{ $diskon->persentase }}"
                           min="0"
                           max="100"
                           step="0.01"
                           required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label d-block">Status Diskon</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                    type="radio"
                                    name="aktif"
                                    id="aktif_ya"
                                    value="1"
                                    {{ old('aktif', $diskon->aktif) == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="aktif_ya">Aktif</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                    type="radio"
                                    name="aktif"
                                    id="aktif_tidak"
                                    value="0"
                                    {{ old('aktif', $diskon->aktif) == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="aktif_tidak">Tidak Aktif</label>
                            </div>
                        </div>
                        <button type="submit"
                                class="btn btn-primary">
                            Update
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
