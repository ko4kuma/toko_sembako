@extends('layouts.app')
@section('title', 'Edit Pembelian')

@section('content')

<div class="container mt-4">

@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<h3>Edit Pembelian</h3>

<form action="{{ route('pembelian.update',$pembelian->id) }}" method="POST">

    @csrf
    @method('PUT')

    {{-- SUPPLIER --}}
    <div class="mb-3">
        <label class="form-label">Supplier</label>

        <select name="supplier_id" class="form-control">
            <option value="">-- Tanpa Supplier --</option>

            @foreach($supplier as $s)
                <option value="{{ $s->id }}"
                    {{ $pembelian->supplier_id == $s->id ? 'selected' : '' }}>
                    {{ $s->nama_supplier }}
                </option>
            @endforeach

        </select>
    </div>

    {{-- TANGGAL --}}
    <div class="mb-3">
        <label class="form-label">Tanggal</label>

        <input
            type="date"
            name="tanggal"
            class="form-control"
            value="{{ $pembelian->tanggal }}"
            required>
    </div>

    <hr>

    <h5>Data Barang</h5>

    <div id="barang-wrapper">

        @foreach($pembelian->detail as $detail)

        <div class="row mb-3 barang-item align-items-end">

            <div class="col-md-4">
                <label>Barang</label>

                <select name="barang_id[]" class="form-control pilih-barang">

                    <option value="">-- Pilih Barang --</option>

                    @foreach($barang as $b)

                        <option value="{{ $b->id }}"
                            {{ $detail->barang_id == $b->id ? 'selected' : '' }}>

                            {{ $b->nama_barang }}
                            (Stok : {{ $b->stokTerkini() }})

                        </option>

                    @endforeach

                </select>

            </div>

            <div class="col-md-2">

                <label>Qty</label>

                <input
                    type="number"
                    class="form-control qty-input"
                    name="qty[]"
                    value="{{ $detail->qty }}"
                    min="1">

            </div>

            <div class="col-md-2">

                <label>Harga Beli</label>

                <input
                    type="number"
                    class="form-control harga-beli-input"
                    name="harga_beli[]"
                    value="{{ $detail->harga_beli }}">

            </div>

            <div class="col-md-2">

                <label>Subtotal</label>

                <input
                    class="form-control subtotal-display"
                    readonly
                    value="{{ number_format($detail->subtotal,0,',','.') }}">

            </div>

            <div class="col-md-2">

                <button type="button"
                    class="btn btn-danger btn-sm remove-barang">
                    Hapus
                </button>

            </div>

        </div>

        @endforeach

    </div>

    <button
        type="button"
        class="btn btn-info mb-3"
        id="tambah-barang">

        + Tambah Barang

    </button>

    <br>

    <div class="mb-3">

        <strong>
            Total Pembelian :
            Rp <span id="total-pembelian">
                {{ number_format($pembelian->total,0,',','.') }}
            </span>
        </strong>

    </div>

    <button class="btn btn-success">
        Update Pembelian
    </button>

</form>

</div>

{{-- Template --}}
<div id="template-barang" style="display:none;">

<div class="row mb-3 barang-item align-items-end">

    <div class="col-md-4">

        <label>Barang</label>

        <select name="barang_id[]" class="form-control pilih-barang">

            <option value="">-- Pilih Barang --</option>

            @foreach($barang as $b)

            <option value="{{ $b->id }}">
                {{ $b->nama_barang }}
                (Stok : {{ $b->stokTerkini() }})
            </option>

            @endforeach

        </select>

    </div>

    <div class="col-md-2">

        <label>Qty</label>

        <input type="number"
            class="form-control qty-input"
            name="qty[]">

    </div>

    <div class="col-md-2">

        <label>Harga Beli</label>

        <input type="number"
            class="form-control harga-beli-input"
            name="harga_beli[]">

    </div>

    <div class="col-md-2">

        <label>Subtotal</label>

        <input class="form-control subtotal-display"
            readonly
            value="0">

    </div>

    <div class="col-md-2">

        <button
            type="button"
            class="btn btn-danger btn-sm remove-barang">

            Hapus

        </button>

    </div>

</div>

</div>

<script>

function hitungTotal(){

    let total=0;

    document.querySelectorAll('.barang-item').forEach(function(item){

        let qty=parseInt(item.querySelector('.qty-input').value)||0;

        let harga=parseInt(item.querySelector('.harga-beli-input').value)||0;

        let subtotal=qty*harga;

        item.querySelector('.subtotal-display').value=
            subtotal.toLocaleString('id-ID');

        total+=subtotal;

    });

    document.getElementById('total-pembelian').innerText=
        total.toLocaleString('id-ID');

}

document.addEventListener('input',function(e){

    if(e.target.classList.contains('qty-input')
    ||e.target.classList.contains('harga-beli-input')){

        hitungTotal();

    }

});

document.getElementById('tambah-barang').onclick=function(){

    let clone=document.querySelector('#template-barang .barang-item').cloneNode(true);

    document.getElementById('barang-wrapper').appendChild(clone);

};

document.addEventListener('click',function(e){

    if(e.target.classList.contains('remove-barang')){

        if(document.querySelectorAll('.barang-item').length>1){

            e.target.closest('.barang-item').remove();

            hitungTotal();

        }

    }

});

window.onload=hitungTotal;

</script>

@endsection