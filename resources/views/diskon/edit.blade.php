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
                                Persentase
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
