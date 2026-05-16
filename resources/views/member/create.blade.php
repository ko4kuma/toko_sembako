@extends('layouts.app')

@section('content')

<div class="container mt-4">

<form action="{{ route('member.store') }}" method="POST">

    @csrf

    <div class="mb-3">
        <label>Nama Member</label>
        <input type="text" name="nama_member" class="form-control">
    </div>

    <div class="mb-3">
        <label>Alamat</label>
        <textarea name="alamat" class="form-control"></textarea>
    </div>

    <div class="mb-3">
        <label>No Hp</label>
        <input type="text" name="no_hp" class="form-control">
    </div>

    <button class="btn btn-success">
        Simpan
    </button>

</form>

</div>

@endsection