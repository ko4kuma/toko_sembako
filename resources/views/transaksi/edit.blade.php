@extends('layout')

@section('content')

<div class="container mt-4">

<form action="{{ route('transaksi.update',$transaksi->id) }}"
      method="POST">

    @csrf
    @method('PUT')

    {{-- MEMBER --}}
    <div class="mb-3">

        <label>Member</label>

        <select name="member_id"
                class="form-control">

            @foreach($member as $m)

                <option value="{{ $m->id }}"
                    {{ $transaksi->member_id == $m->id ? 'selected' : '' }}>

                    {{ $m->nama_member }}

                </option>

            @endforeach

        </select>

    </div>

    {{-- TANGGAL --}}
    <div class="mb-3">

        <label>Tanggal</label>

        <input type="date"
               name="tanggal"
               value="{{ $transaksi->tanggal }}"
               class="form-control">

    </div>

    <hr>

    <h5>Data Barang</h5>

    <div id="barang-wrapper">

        {{-- LOOP DETAIL (INI FIX UTAMA) --}}
        @foreach($detail as $d)

        <div class="row mb-3 barang-item">

            {{-- BARANG --}}
            <div class="col-md-5">

                <label>Barang</label>

                <select name="barang_id[]"
                        class="form-control">

                    @foreach($barang as $b)

                        <option value="{{ $b->id }}"
                            {{ $d->barang_id == $b->id ? 'selected' : '' }}>

                            {{ $b->nama_barang }} - Rp {{ $b->harga }}

                        </option>

                    @endforeach

                </select>

            </div>

            {{-- QTY --}}
            <div class="col-md-3">

                <label>Qty</label>

                <input type="number"
                       name="qty[]"
                       value="{{ $d->qty }}"
                       class="form-control">

            </div>

            {{-- HAPUS --}}
            <div class="col-md-2 d-flex align-items-end">

                <button type="button"
                        class="btn btn-danger remove-barang">

                    Hapus

                </button>

            </div>

        </div>

        @endforeach

    </div>

    {{-- TAMBAH BARANG --}}
    <button type="button"
            class="btn btn-info mb-3"
            id="tambah-barang">

        + Tambah Barang

    </button>

    <br>

    <button class="btn btn-primary">
        Update
    </button>

</form>

</div>

{{-- JAVASCRIPT --}}
<script>

document.getElementById('tambah-barang')
.addEventListener('click', function () {

    let wrapper = document.getElementById('barang-wrapper');

    let item = document.querySelector('.barang-item');

    let clone = item.cloneNode(true);

    // reset qty
    clone.querySelector('input').value = '';

    wrapper.appendChild(clone);
});

// hapus barang
document.addEventListener('click', function(e){

    if(e.target.classList.contains('remove-barang'))
    {
        let items = document.querySelectorAll('.barang-item');

        if(items.length > 1)
        {
            e.target.closest('.barang-item').remove();
        }
    }

});

</script>

@endsection