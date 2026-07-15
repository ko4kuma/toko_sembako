@extends('layouts.app')
@section('title', 'Tambah Pembelian')
@section('content')

<div class="container mt-4">

{{-- ERROR VALIDASI --}}
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
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<h3>Tambah Pembelian</h3>

<form action="{{ route('pembelian.store') }}" method="POST">

    @csrf

    {{-- SUPPLIER --}}
    <div class="mb-3">
        <label class="form-label">Supplier</label>
        <select name="supplier_id" class="form-control">
            <option value="">-- Tanpa Supplier --</option>
            @foreach($supplier as $s)
                <option value="{{ $s->id }}">{{ $s->nama_supplier }}</option>
            @endforeach
        </select>
    </div>

    {{-- TANGGAL --}}
    <div class="mb-3">
        <label class="form-label">Tanggal</label>
        <input type="date" name="tanggal" class="form-control"
               value="{{ old('tanggal', now()->toDateString()) }}" required>
    </div>

    <hr>

    <h5>Data Barang</h5>

    <div id="barang-wrapper">

        <div class="row mb-3 barang-item align-items-end">

            {{-- BARANG --}}
            <div class="col-md-4">
                <label class="form-label">Barang</label>
                <select name="barang_id[]" class="form-control pilih-barang" required>
                    <option value="">-- Pilih Barang --</option>
                    @foreach($barang as $b)
                        <option value="{{ $b->id }}">
                            {{ $b->nama_barang }} (Stok: {{ $b->stokTerkini() }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- QTY --}}
            <div class="col-md-2">
                <label class="form-label">Qty</label>
                <input type="number" name="qty[]" class="form-control qty-input" min="1" required>
            </div>

            {{-- HARGA BELI --}}
            <div class="col-md-2">
                <label class="form-label">Harga Beli/Satuan</label>
                <input type="number" name="harga_beli[]" class="form-control harga-beli-input" min="0" required>
            </div>

            {{-- SUBTOTAL (READONLY) --}}
            <div class="col-md-2">
                <label class="form-label">Subtotal</label>
                <input type="text" class="form-control subtotal-display" readonly value="0">
            </div>

            {{-- TOMBOL HAPUS --}}
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm remove-barang">Hapus</button>
            </div>

        </div>

    </div>

    <button type="button" class="btn btn-info mb-3" id="tambah-barang">
        + Tambah Barang
    </button>

    <br>

    <div class="mb-3">
        <strong>Total Pembelian: Rp <span id="total-pembelian">0</span></strong>
    </div>

    <button type="submit" class="btn btn-success">
        Simpan Pembelian
    </button>

</form>

</div>

{{-- JAVASCRIPT --}}
<script>

document.getElementById('tambah-barang').addEventListener('click', function () {
    let wrapper = document.getElementById('barang-wrapper');
    let item = document.querySelector('.barang-item');
    let clone = item.cloneNode(true);

    clone.querySelector('.pilih-barang').value = "";
    clone.querySelector('.qty-input').value = "";
    clone.querySelector('.harga-beli-input').value = "";
    clone.querySelector('.subtotal-display').value = "0";

    wrapper.appendChild(clone);
    refreshBarangOptions();
});

// HAPUS BARANG
document.addEventListener('click', function(e){
    if(e.target.classList.contains('remove-barang'))
    {
        let items = document.querySelectorAll('.barang-item');

        if(items.length > 1)
        {
            e.target.closest('.barang-item').remove();
            refreshBarangOptions();
            hitungTotal();
        }
    }
});

// DISABLE BARANG YANG UDAH DIPILIH DI SELECT LAIN
function refreshBarangOptions() {
    let semuaSelect = document.querySelectorAll('.pilih-barang');

    let terpilih = [];
    semuaSelect.forEach(function(s) {
        if (s.value) terpilih.push(s.value);
    });

    semuaSelect.forEach(function(select) {
        let valueSendiri = select.value;

        select.querySelectorAll('option').forEach(function(opt) {
            if (!opt.value) return;

            if (terpilih.includes(opt.value) && opt.value !== valueSendiri) {
                opt.disabled = true;
            } else {
                opt.disabled = false;
            }
        });
    });
}

// HITUNG SUBTOTAL PER BARIS & TOTAL KESELURUHAN
function hitungTotal() {
    let total = 0;

    document.querySelectorAll('.barang-item').forEach(function(item) {
        let qty = parseInt(item.querySelector('.qty-input').value || 0);
        let hargaBeli = parseInt(item.querySelector('.harga-beli-input').value || 0);
        let subtotal = qty * hargaBeli;

        item.querySelector('.subtotal-display').value = subtotal.toLocaleString('id-ID');
        total += subtotal;
    });

    document.getElementById('total-pembelian').innerText = total.toLocaleString('id-ID');
}

document.addEventListener('input', function (e) {
    if (e.target.classList.contains('qty-input') || e.target.classList.contains('harga-beli-input')) {
        hitungTotal();
    }
});

document.addEventListener('change', function (e) {
    if (e.target.classList.contains('pilih-barang')) {
        refreshBarangOptions();
    }
});

document.addEventListener('DOMContentLoaded', function () {
    refreshBarangOptions();
});

</script>

@endsection