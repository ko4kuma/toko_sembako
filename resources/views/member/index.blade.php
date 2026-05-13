@extends('layout')

@section('content')

<div class="container mt-4">

    <a href="{{ route('member.create') }}" class="btn btn-primary mb-3">
        Tambah Member
    </a>

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Nama Member</th>
            <th>Alamat</th>
            <th>Telepon</th>
            <th>Aksi</th>
        </tr>

        @foreach($member as $m)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $m->nama_member }}</td>
            <td>{{ $m->alamat }}</td>
            <td>{{ $m->telepon }}</td>
            <td>
                <a href="{{ route('member.edit',$m->id) }}"
                    class="btn btn-warning btn-sm">
                    Edit
                </a>

                <form action="{{ route('member.destroy',$m->id) }}"
                    method="POST"
                    style="display:inline">

                    @csrf
                    @method('DELETE')

                    <button class="btn btn-danger btn-sm">
                        Hapus
                    </button>
                </form>
            </td>
        </tr>
        @endforeach

    </table>

</div>

@endsection