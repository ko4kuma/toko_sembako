@extends('layouts.app')
@section('title', 'Edit Member')
@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Member</h4>
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
                    <form action="{{ route('member.update',$member->id) }}"
                          method="POST">
                        @method('PUT')
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">
                                Nama Member
                            </label>
                            <input type="text"
                                   name="nama_member"
                                   class="form-control"
                                   value="{{ $member->nama_member }}"class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                Alamat
                            </label>
                            <textarea name="alamat"
                                      class="form-control"
                                      rows="3">{{ $member->alamat }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                No HP
                            </label>
                            <input type="text"
                                   name="no_hp"
                                   class="form-control"
                                   value="{{ $member->no_hp }}">
                        </div>
                        <button type="submit"
                                class="btn btn-primary">
                            Update
                        </button>
                        <a href="{{ route('member.index') }}"
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