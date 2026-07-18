@extends('layouts.app')

@section('title', 'Buat Sesi Opname')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card">
                <div class="card-header">
                    <h4>Buat Sesi Opname Baru</h4>
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
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('stok-opname.store') }}"
                          method="POST">

                        @csrf
                        <div class="mb-3">
                            <label class="form-label">
                                Tanggal
                            </label>

                            <input type="date"
                                   name="tanggal"
                                   class="form-control"
                                   value="{{ old('tanggal', now()->toDateString()) }}"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Keterangan
                            </label>

                            <textarea name="keterangan"
                                      class="form-control"
                                      rows="3"
                                      placeholder="Contoh: Opname akhir bulan Juli">{{ old('keterangan') }}</textarea>
                        </div>

                        <button type="submit"
                                class="btn btn-primary">
                            Buat & Mulai Isi Data
                        </button>

                        <a href="{{ route('stok-opname.index') }}"
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