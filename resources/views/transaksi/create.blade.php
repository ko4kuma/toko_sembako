@extends('layouts.app')
@section('title', 'Kasir')
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

    {{-- TANGGAL --}}
    <div class="mb-3">

        <label class="form-label">Tanggal</label>

        <input type="date"
               name="tanggal"
               class="form-control"
               value="{{ old('tanggal', now()->toDateString()) }}"
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

                        <option
                            value="{{ $b->id }}"
                            data-harga="{{ $b->harga }}"
                        >
                            {{ $b->nama_barang }}
                            - Rp {{ number_format($b->harga) }}
                            (Stok: {{ $b->stokTerkini() }})
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
    <hr>

    <h5>Diskon</h5>

    {{-- TOTAL BELANJA (tampilan aja, dihitung via JS) --}}
    <div class="mb-3">
        <strong>Total Belanja: Rp <span id="total-belanja">0</span></strong>
    </div>

    {{-- WRAPPER DISKON --}}
    <div id="diskon-wrapper">
        {{-- Item diskon akan ditambahin di sini lewat JS --}}
    </div>

    <button type="button" class="btn btn-info mb-3" id="tambah-diskon">
        + Tambah Diskon
    </button>

    <div class="mb-3">
        <strong>Total Diskon: Rp <span id="total-diskon">0</span></strong>
    </div>

    <div class="mb-3">
        <strong>Total Akhir: Rp <span id="total-akhir">0</span></strong>
    </div>

    <hr>

    <h5>Pembayaran</h5>

    {{-- METODE PEMBAYARAN --}}
    <div class="mb-3">
        <label class="form-label">Metode Pembayaran</label>
        <select name="metode" id="metode-pembayaran" class="form-control" required>
            <option value="">-- Pilih Metode --</option>
            <option value="cash">Cash</option>
            <option value="transfer">Transfer</option>
            <option value="qris">QRIS</option>
            <option value="debit">Debit</option>
        </select>
    </div>

    {{-- JUMLAH DIBAYAR --}}
    <div class="mb-3">
        <label class="form-label">Jumlah Dibayar</label>
        <input type="number"
               name="jumlah"
               id="jumlah-dibayar"
               class="form-control"
               min="0"
               required>
    </div>

    {{-- KEMBALIAN --}}
    <div class="mb-3">
        <strong>Kembalian: Rp <span id="kembalian">0</span></strong>
    </div>

    {{-- SUBMIT --}}
    <button type="submit" class="btn btn-success">

        Bayar

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
    refreshBarangOptions();
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
            refreshBarangOptions();
        }
    }

});

// ================================
// STATE DISKON YANG DIPILIH
// ================================
let diskonTerpilih = []; // [{diskon_id, tipe, persentase, nama, member_id}]
let diskonEligibleCache = [];
let semuaDiskon = [];

// ================================
// HITUNG TOTAL BELANJA
// ================================
function hitungTotalBelanja() {
    let total = 0;

    document.querySelectorAll('.barang-item').forEach(function(item) {
        let select = item.querySelector('select[name="barang_id[]"]');
        let qtyInput = item.querySelector('input[name="qty[]"]');

        if (select.value && qtyInput.value) {
            let selectedOption = select.options[select.selectedIndex];
            let harga = parseInt(selectedOption.dataset.harga || 0);
            let qty = parseInt(qtyInput.value || 0);
            total += harga * qty;
        }
    });

    return total;
}

function refreshBarangOptions() {
    let semuaSelect = document.querySelectorAll('select[name="barang_id[]"]');

    // KUMPULIN SEMUA VALUE YANG UDAH DIPILIH
    let terpilih = [];
    semuaSelect.forEach(function(s) {
        if (s.value) terpilih.push(s.value);
    });

    // LOOP TIAP SELECT, DISABLE OPTION YANG DIPILIH DI SELECT LAIN
    semuaSelect.forEach(function(select) {
        let valueSendiri = select.value;

        select.querySelectorAll('option').forEach(function(opt) {
            if (!opt.value) return; // skip "-- Pilih Barang --"

            if (terpilih.includes(opt.value) && opt.value !== valueSendiri) {
                opt.disabled = true;
            } else {
                opt.disabled = false;
            }
        });
    });
}

// ================================
// PEMBAYARAN: hitung kembalian & auto-fill non-cash
// ================================
function hitungKembalian() {
    let totalAkhir = hitungTotalBelanja();
    diskonTerpilih.forEach(function(d) {
        totalAkhir -= hitungTotalBelanja() * (d.persentase / 100);
    });

    let metode = document.getElementById('metode-pembayaran').value;
    let jumlahInput = document.getElementById('jumlah-dibayar');
    let jumlahDibayar = parseInt(jumlahInput.value || 0);

    if (metode && metode !== 'cash') {
        // NON-CASH: auto-fill pas, readonly
        jumlahInput.value = totalAkhir;
        jumlahInput.readOnly = true;
        jumlahDibayar = totalAkhir;
    } else {
        // CASH: bisa diketik manual
        jumlahInput.readOnly = false;
    }

    let kembalian = jumlahDibayar - totalAkhir;
    document.getElementById('kembalian').innerText = (kembalian > 0 ? kembalian : 0).toLocaleString('id-ID');
}

document.getElementById('metode-pembayaran').addEventListener('change', hitungKembalian);
document.getElementById('jumlah-dibayar').addEventListener('input', hitungKembalian);

// ================================
// HITUNG ULANG SEMUA (total, diskon, total akhir)
// ================================

let diskonTimeout = null;
function hitungUlang() {
    let total = hitungTotalBelanja();
    document.getElementById('total-belanja').innerText = total.toLocaleString('id-ID');

    let totalDiskon = 0;
    diskonTerpilih.forEach(function(d) {
        totalDiskon += total * (d.persentase / 100);
    });

    let totalAkhir = total - totalDiskon;

    document.getElementById('total-diskon').innerText = totalDiskon.toLocaleString('id-ID');
    document.getElementById('total-akhir').innerText = totalAkhir.toLocaleString('id-ID');

    // REFRESH LIST DISKON ELIGIBLE TIAP TOTAL BERUBAH
    clearTimeout(diskonTimeout);

    diskonTimeout =
        setTimeout(function () {

            fetchDiskonEligible(total);

        }, 300);
}

function fetchDiskonEligible(total) {

    // AMBIL DARI SERVER SEKALI SAJA
    if (semuaDiskon.length === 0) {

        fetch(`/diskon/eligible?total=${total}`)
            .then(res => res.json())
            .then(data => {

                semuaDiskon = data;

                diskonEligibleCache =
                    semuaDiskon.filter(function (d) {

                        return total >= d.syarat_minimal;

                    });

            });

        return;
    }

    // FILTER LANGSUNG DARI CACHE
    diskonEligibleCache =
        semuaDiskon.filter(function (d) {

            return total >= d.syarat_minimal;

        });

}

// ================================
// RENDER SELECT PILIHAN DISKON (yang belum dipilih aja)
// ================================
function getOptionsDiskonBelumDipilih() {
    let idsTerpilih = diskonTerpilih.map(d => d.diskon_id);

    return diskonEligibleCache
        .filter(d => !idsTerpilih.includes(d.id))
        .map(d => `<option value="${d.id}" data-tipe="${d.tipe}" data-persentase="${d.persentase}" data-nama="${d.nama_diskon}">${d.nama_diskon} (${d.persentase}%)</option>`)
        .join('');
}

// ================================
// TOMBOL "+ TAMBAH DISKON"
// ================================
document.getElementById('tambah-diskon').addEventListener('click', function () {
    let options = getOptionsDiskonBelumDipilih();

    if (!options) {
        alert('Tidak ada diskon lain yang bisa ditambahkan.');
        return;
    }

    let wrapper = document.getElementById('diskon-wrapper');

    let div = document.createElement('div');
    div.classList.add('row', 'mb-2', 'diskon-item', 'align-items-center');

    div.innerHTML = `
        <div class="col-md-5">
            <select class="form-control pilih-diskon">
                <option value="">-- Pilih Diskon --</option>
                ${options}
            </select>
        </div>
        <div class="col-md-5 member-search-wrapper" style="display:none;">
            <input type="text" class="form-control cari-member" placeholder="Ketik no HP member...">
            <div class="list-group hasil-member" style="position:absolute; z-index:10;"></div>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger btn-sm remove-diskon">Hapus</button>
        </div>
    `;

    wrapper.appendChild(div);
});

// ================================
// SAAT PILIH DISKON DARI SELECT
// ================================
document.addEventListener('change', function (e) {
    if (e.target.classList.contains('pilih-diskon')) {
        let select = e.target;
        let selectedOption = select.options[select.selectedIndex];
        let item = select.closest('.diskon-item');
        let memberWrapper = item.querySelector('.member-search-wrapper');

        if (!select.value) {
            memberWrapper.style.display = 'none';
            return;
        }

        let diskonId = select.value;
        let tipe = selectedOption.dataset.tipe;
        let persentase = parseFloat(selectedOption.dataset.persentase);
        let nama = selectedOption.dataset.nama;

        // TAMPILIN SEARCH BOX MEMBER KALAU TIPE-NYA MEMBER
        if (tipe === 'member') {
            memberWrapper.style.display = 'block';
        } else {
            memberWrapper.style.display = 'none';
        }

        // SIMPAN KE STATE (member_id null dulu kalau tipe member, nunggu dipilih)
        diskonTerpilih.push({
            diskon_id: parseInt(diskonId),
            tipe: tipe,
            persentase: persentase,
            nama: nama,
            member_id: null
        });

        // KUNCI SELECT INI biar gak bisa diganti-ganti sembarangan (opsional, tapi lebih aman)
        select.disabled = true;

        hitungUlang();
        hitungKembalian();
    }
});

// ================================
// SEARCH BOX MEMBER (ketik no HP)
// ================================
document.addEventListener('input', function (e) {
    if (e.target.classList.contains('cari-member')) {
        let input = e.target;
        let keyword = input.value;
        let item = input.closest('.diskon-item');
        let hasilBox = item.querySelector('.hasil-member');

        if (keyword.length < 3) {
            hasilBox.innerHTML = '';
            return;
        }

        fetch(`/member/search?q=${keyword}`)
            .then(res => res.json())
            .then(data => {
                hasilBox.innerHTML = data.map(m =>
                    `<button type="button" class="list-group-item list-group-item-action pilih-member-hasil" data-id="${m.id}" data-nama="${m.nama_member}">${m.nama_member} - ${m.no_hp}</button>`
                ).join('');
            });
    }
});

// ================================
// SAAT PILIH MEMBER DARI HASIL PENCARIAN
// ================================
document.addEventListener('click', function (e) {
    if (e.target.classList.contains('pilih-member-hasil')) {
        let btn = e.target;
        let item = btn.closest('.diskon-item');
        let memberWrapper = item.querySelector('.member-search-wrapper');
        let memberId = btn.dataset.id;
        let memberNama = btn.dataset.nama;

        // GANTI SEARCH BOX JADI READONLY ABU-ABU
        memberWrapper.innerHTML = `
            <input type="text" class="form-control" value="${memberNama}" readonly style="background-color:#e9ecef;">
        `;

        // UPDATE STATE: isi member_id ke diskon yang lagi diproses
        // (asumsi 1 diskon-item cuma bisa 1 diskon tipe member aktif dalam satu waktu)
        let select = item.querySelector('.pilih-diskon');
        let diskonId = select.value;

        let target = diskonTerpilih.find(d => d.diskon_id === parseInt(diskonId));
        if (target) {
            target.member_id = memberId;
        }
    }
});

// ================================
// HAPUS DISKON YANG DIPILIH
// ================================
document.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-diskon')) {
        let item = e.target.closest('.diskon-item');
        let select = item.querySelector('.pilih-diskon');
        let diskonId = select.value;

        // HAPUS DARI STATE
        diskonTerpilih = diskonTerpilih.filter(d => d.diskon_id !== parseInt(diskonId));

        item.remove();
        
        let total = hitungTotalBelanja();
        document.getElementById('total-belanja').innerText = total.toLocaleString('id-ID');

        let totalDiskon = 0;
        diskonTerpilih.forEach(function(d) {
            totalDiskon += total * (d.persentase / 100);
        });
        let totalAkhir = total - totalDiskon;

        document.getElementById('total-diskon').innerText = totalDiskon.toLocaleString('id-ID');
        document.getElementById('total-akhir').innerText = totalAkhir.toLocaleString('id-ID');

        fetchDiskonEligible(total); // langsung fetch, tanpa debounce
        hitungKembalian();
    }
});

// ================================
// RECALCULATE TIAP KALI QTY/BARANG BERUBAH
// ================================
document.addEventListener('input', function (e) {
    if (e.target.matches('input[name="qty[]"]')) {
        hitungUlang();
    }
});

document.addEventListener('change', function (e) {
    if (e.target.matches('select[name="barang_id[]"]')) {
        hitungUlang();
        refreshBarangOptions();
    }
});
// ================================
// SEBELUM SUBMIT: masukin diskon_ids[] dan member_id ke form via hidden input
// ================================
document.querySelector('form').addEventListener('submit', function (e) {
    let form = e.target;
    // VALIDASI: metode pembayaran wajib dipilih
    let metode = document.getElementById('metode-pembayaran').value;
    if (!metode) {
        e.preventDefault();
        alert('Pilih metode pembayaran terlebih dahulu.');
        return;
    }

    // VALIDASI: jumlah dibayar cash gak boleh kurang
    if (metode === 'cash') {
        let jumlahDibayar = parseInt(document.getElementById('jumlah-dibayar').value || 0);
        let kembalianText = document.getElementById('kembalian').innerText.replace(/\./g, '');
        // cek ulang manual biar aman
        let totalAkhirText = document.getElementById('total-akhir').innerText.replace(/\./g, '');
        if (jumlahDibayar < parseInt(totalAkhirText)) {
            e.preventDefault();
            alert('Jumlah dibayar kurang dari total akhir.');
            return;
        }
    }

    // VALIDASI: diskon tipe member tapi belum pilih member
    let belumLengkap = diskonTerpilih.find(d => d.tipe === 'member' && !d.member_id);
    if (belumLengkap) {
        e.preventDefault();
        alert('Pilih member terlebih dahulu untuk diskon "' + belumLengkap.nama + '"');
        return;
    }

    // HAPUS hidden input lama (jaga-jaga kalau submit gagal & dicoba lagi)
    form.querySelectorAll('input[name="diskon_ids[]"], input[name="member_id"]').forEach(el => el.remove());

    // TAMBAHIN hidden input diskon_ids[]
    diskonTerpilih.forEach(function (d) {
        let hidden = document.createElement('input');
        hidden.type = 'hidden';
        hidden.name = 'diskon_ids[]';
        hidden.value = d.diskon_id;
        form.appendChild(hidden);
    });

    // TAMBAHIN hidden input member_id (ambil dari diskon tipe member yang kepilih, kalau ada)
    let diskonMember = diskonTerpilih.find(d => d.tipe === 'member');
    if (diskonMember) {
        let hiddenMember = document.createElement('input');
        hiddenMember.type = 'hidden';
        hiddenMember.name = 'member_id';
        hiddenMember.value = diskonMember.member_id;
        form.appendChild(hiddenMember);
    }
});

document.addEventListener('DOMContentLoaded', function () {
    hitungUlang();
    refreshBarangOptions();
});
</script>

@endsection