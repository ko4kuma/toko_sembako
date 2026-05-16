@extends('layouts.app')

@section('content')

<div class="container mt-4">

<form action="{{ route('member.update',$member->id) }}" method="POST">

    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Nama Member</label>

        <input type="text"
               name="nama_member"
               value="{{ $member->nama_member }}"
               class="form-control">
    </div>

    <div class="mb-3">
        <label>Alamat</label>

        <textarea name="alamat"
                  class="form-control">{{ $member->alamat }}</textarea>
    </div>

    <div class="mb-3">
        <label>No Hp</label>

        <input type="text"
               name="no_hp"
               value="{{ $member->no_hp }}"
               class="form-control">
    </div>

    <button class="btn btn-primary">
        Update
    </button>

</form>

</div>

@endsection