@extends('layouts.app')
@section('title', 'Isi Data Opname')
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

{{-- ✅ ERROR/SUCCESS DARI CONTROLLER --}}
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<h3>Sesi Opname — {{ $stokOpname->tanggal }}</h3>
<p>
    Status:
    @if($stokOpname->status === 'draft')
        <span class="badge bg-warning text-dark">Draft</span>
    @else
        <span class="badge bg-success">Selesai</span>
    @endif
</p>

@if($stokOpname->status === 'draft')

{{-- FORM ISI DATA (HANYA MUNCUL KALAU MASIH DRAFT) --}}
<form action="{{ route('stok-opname.simpan-detail', $stokOpname->id) }}" method="POST">

    @csrf

    <div id="barang-wrapper">

        <div class="row mb-3 barang-item align-items-end">

            {{-- BARANG --}}
            <div class="col-md-4">
                <label class="form-label">Barang</label>
                <select name="barang_id[]" class="form-control pilih-barang" required>
                    <option value="">-- Pilih Barang --</option>
                    @foreach($barang as $b)
                        <option value="{{ $b->id }}" data-stok="{{ $b->stokTerkini() }}">
                            {{ $b->nama_barang }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- STOK SISTEM (READONLY) --}}
            <div class="col-md-2">
                <label class="form-label">Stok Sistem</label>
                <input type="text" class="form-control stok-sistem-display" readonly value="0">
            </div>

            {{-- STOK FISIK --}}
            <div class="col-md-2">
                <label class="form-label">Stok Fisik</label>
                <input type="number" name="stok_fisik[]" class="form-control stok-fisik" min="0" required>
            </div>

            {{-- SELISIH (READONLY) --}}
            <div class="col-md-2">
                <label class="form-label">Selisih</label>
                <input type="text" class="form-control selisih-display" readonly value="0">
            </div>

            {{-- CATATAN --}}
            <div class="col-md-2">
                <label class="form-label">Catatan</label>
                <input type="text" name="catatan[]" class="form-control">
            </div>
            {{-- TOMBOL HAPUS --}}
            <div class="col-md-1">
                <button type="button" class="btn btn-danger btn-sm remove-barang">
                    Hapus
                </button>
            </div>

        </div>

    </div>

    <button type="button" class="btn btn-info mb-3" id="tambah-barang">
        + Tambah Barang
    </button>

    <br>

    <button type="submit" class="btn btn-primary">
        Simpan sebagai Draft
    </button>

</form>

<hr>

<form action="{{ route('stok-opname.selesaikan', $stokOpname->id) }}" method="POST"
      onsubmit="return confirm('Yakin selesaikan opname ini? Stok akan disesuaikan dan tidak bisa diubah lagi.')">
    @csrf
    <button type="submit" class="btn btn-danger">
        Selesaikan Opname
    </button>
</form>

@endif

{{-- TABEL DATA YANG SUDAH TERSIMPAN --}}
<hr>
<h5>Data Tersimpan</h5>
<table class="table table-bordered">
    <tr>
        <th>No</th>
        <th>Barang</th>
        <th>Stok Sistem</th>
        <th>Stok Fisik</th>
        <th>Selisih</th>
        <th>Catatan</th>
    </tr>
    @forelse($stokOpname->detail as $d)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $d->barang->nama_barang }}</td>
        <td>{{ $d->stok_sistem }}</td>
        <td>{{ $d->stok_fisik }}</td>
        <td>{{ $d->selisih }}</td>
        <td>{{ $d->catatan ?? '-' }}</td>
    </tr>
    @empty
    <tr>
        <td colspan="6" class="text-center py-3 text-muted">Belum ada data barang yang diisi</td>
    </tr>
    @endforelse
</table>

<a href="{{ route('stok-opname.index') }}" class="btn btn-secondary">Kembali</a>

</div>

{{-- JAVASCRIPT --}}
<script>

document.getElementById('tambah-barang')?.addEventListener('click', function () {
    let wrapper = document.getElementById('barang-wrapper');
    let item = document.querySelector('.barang-item');
    let clone = item.cloneNode(true);

    clone.querySelector('.pilih-barang').value = "";
    clone.querySelector('.stok-fisik').value = "";
    clone.querySelector('input[name="catatan[]"]').value = "";
    clone.querySelector('.stok-sistem-display').value = "0";
    clone.querySelector('.selisih-display').value = "0";

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
        }
    }
});

// SAAT PILIH BARANG, TAMPILIN STOK SISTEM
document.addEventListener('change', function (e) {
    if (e.target.classList.contains('pilih-barang')) {
        let select = e.target;
        let item = select.closest('.barang-item');
        let selectedOption = select.options[select.selectedIndex];
        let stokSistem = parseInt(selectedOption.dataset.stok || 0);

        item.querySelector('.stok-sistem-display').value = stokSistem;
        hitungSelisih(item);
        refreshBarangOptions();
    }
});

// HITUNG SELISIH TIAP KALI STOK FISIK DIKETIK
document.addEventListener('input', function (e) {
    if (e.target.classList.contains('stok-fisik')) {
        let item = e.target.closest('.barang-item');
        hitungSelisih(item);
    }
});

function hitungSelisih(item) {
    let stokSistem = parseInt(item.querySelector('.stok-sistem-display').value || 0);
    let stokFisik = parseInt(item.querySelector('.stok-fisik').value || 0);
    let selisih = stokFisik - stokSistem;

    item.querySelector('.selisih-display').value = selisih;
}
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
document.addEventListener('DOMContentLoaded', function () {
    refreshBarangOptions();
});
</script>

@endsection