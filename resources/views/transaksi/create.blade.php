@extends('layouts.app')

@section('content')

<div class="container mt-4">

{{-- ✅ ERROR VALIDASI --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- ✅ ERROR DARI CONTROLLER --}}
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

{{-- ✅ SUCCESS MESSAGE --}}
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

{{-- FORM TRANSAKSI --}}
<form action="{{ route('transaksi.store') }}"
      method="POST">

    @csrf

    {{-- MEMBER --}}
    <div class="mb-3">

        <label class="form-label">Member</label>

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

        <label class="form-label">Tanggal</label>

        <input type="date"
               name="tanggal"
               class="form-control"
               required>

    </div>

    <hr>

    <h5>Data Barang</h5>

    {{-- WRAPPER BARANG --}}
    <div id="barang-wrapper">

        <div class="row mb-3 barang-item">

            {{-- BARANG --}}
            <div class="col-md-5">

                <label class="form-label">Barang</label>

                <select name="barang_id[]"
                        class="form-control"
                        required>

                    <option value="">-- Pilih Barang --</option>

                    @foreach($barang as $b)

                        <option value="{{ $b->id }}">

                            {{ $b->nama_barang }}
                            - Rp {{ number_format($b->harga) }}
                            (Stok: {{ $b->stok->jumlah }})

                        </option>

                    @endforeach

                </select>

            </div>

            {{-- QTY --}}
            <div class="col-md-3">

                <label class="form-label">Qty</label>

                <input type="number"
                       name="qty[]"
                       class="form-control"
                       min="1"
                       required>

            </div>

            {{-- TOMBOL HAPUS --}}
            <div class="col-md-2 d-flex align-items-end">

                <button type="button"
                        class="btn btn-danger remove-barang">

                    Hapus

                </button>

            </div>

        </div>

    </div>

    {{-- TAMBAH BARANG --}}
    <button type="button"
            class="btn btn-info mb-3"
            id="tambah-barang">

        + Tambah Barang

    </button>

    <br>

    {{-- SUBMIT --}}
    <button type="submit"
            class="btn btn-success">

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

    let clone =
        item.cloneNode(true);

    // reset value
    clone.querySelector('select').value = "";
    clone.querySelector('input').value = "";

    wrapper.appendChild(clone);
});

// HAPUS BARANG
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