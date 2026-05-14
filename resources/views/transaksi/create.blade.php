@extends('layout')

@section('content')

<div class="container mt-4">

<form action="{{ route('transaksi.store') }}"
      method="POST">

    @csrf

    {{-- MEMBER --}}
    <div class="mb-3">

        <label>Member</label>

        <select name="member_id"
                class="form-control"
                required>

            <option value="">-- Pilih Member --</option>

            @foreach($member as $m)

                <option value="{{ $m->id }}">
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
               class="form-control"
               required>

    </div>

    <hr>

    <h5>Data Barang</h5>

    {{-- TEMPAT FORM BARANG --}}
    <div id="barang-wrapper">

        <div class="row mb-3 barang-item">

            <div class="col-md-5">

                <label>Barang</label>

                <select name="barang_id[]"
                        class="form-control"
                        required>

                    <option value="">-- Pilih Barang --</option>

                    @foreach($barang as $b)

                        <option value="{{ $b->id }}">
                            {{ $b->nama_barang }}
                            - Rp {{ $b->harga }}
                        </option>

                    @endforeach

                </select>

            </div>

            <div class="col-md-3">

                <label>Qty</label>

                <input type="number"
                       name="qty[]"
                       class="form-control"
                       required
                       min="1">

            </div>

            <div class="col-md-2 d-flex align-items-end">

                <button type="button"
                        class="btn btn-danger remove-barang">

                    Hapus

                </button>

            </div>

        </div>

    </div>

    {{-- TOMBOL TAMBAH --}}
    <button type="button"
            class="btn btn-info mb-3"
            id="tambah-barang">

        + Tambah Barang

    </button>

    <br>

    <button class="btn btn-success">
        Simpan Transaksi
    </button>

</form>

</div>

{{-- JAVASCRIPT --}}
<script>

document.getElementById('tambah-barang')
.addEventListener('click', function () {

    let wrapper =
        document.getElementById('barang-wrapper');

    let item =
        document.querySelector('.barang-item');

    let clone = item.cloneNode(true);

    // reset value
    clone.querySelector('select').value = "";
    clone.querySelector('input').value = "";

    wrapper.appendChild(clone);
});

// hapus barang
document.addEventListener('click', function(e){

    if(e.target.classList.contains('remove-barang'))
    {
        let items =
            document.querySelectorAll('.barang-item');

        if(items.length > 1)
        {
            e.target.closest('.barang-item').remove();
        }
    }

});

</script>

@endsection