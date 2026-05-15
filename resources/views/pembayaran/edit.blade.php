@extends('layout.index')

@section('content')

<div class="container py-4">

    <div class="card border-1">

        <div class="card-header bg-success text-white text-center">
            <h5 class="mb-0 fw-bold">
                Edit Pembayaran
            </h5>
        </div>

        <div class="card-body">

            <form action="{{ route('pembayaran.update', $pembayaran->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">Transaksi</label>

                    <select name="transaksi_id" id="transaksi_id" class="form-select" required>
                        <option value="">Pilih Transaksi</option>

                        @foreach($transaksi as $t)
                            <option value="{{ $t->id }}"
                                    data-total="{{ $t->total }}"
                                    data-diskon="{{ $t->member->diskon->persentase ?? 0 }}"
                                    {{ $pembayaran->transaksi_id == $t->id ? 'selected' : '' }}>
                                #{{ $t->id }} - {{ $t->member->nama_member ?? 'Non Member' }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Metode Pembayaran</label>

                    <select name="metode" class="form-select" required>
                        <option value="Cash" {{ $pembayaran->metode == 'Cash' ? 'selected' : '' }}>Cash</option>
                        <option value="Transfer" {{ $pembayaran->metode == 'Transfer' ? 'selected' : '' }}>Transfer</option>
                        <option value="QRIS" {{ $pembayaran->metode == 'QRIS' ? 'selected' : '' }}>QRIS</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Total Sebelum Diskon</label>
                    <input type="text" id="total_kotor" class="form-control" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Diskon</label>
                    <input type="text" id="diskon_display" class="form-control" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Total Bayar</label>
                    <input type="text" id="total_display" class="form-control" readonly>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">

                    <a href="{{ route('pembayaran.index') }}" class="btn btn-secondary px-4">
                        Kembali
                    </a>

                    <button type="submit" class="btn btn-success px-4">
                        Update
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<script>
function hitung() {
    let select = document.getElementById('transaksi_id');
    let option = select.options[select.selectedIndex];

    if (!option) return;

    let total = parseFloat(option.getAttribute('data-total')) || 0;
    let diskon = parseFloat(option.getAttribute('data-diskon')) || 0;

    let potongan = (total * diskon) / 100;
    let grandTotal = total - potongan;

    let format = new Intl.NumberFormat('id-ID');

    document.getElementById('total_kotor').value = 'Rp ' + format.format(total);
    document.getElementById('diskon_display').value = diskon + '% (-Rp ' + format.format(potongan) + ')';
    document.getElementById('total_display').value = 'Rp ' + format.format(grandTotal);
}

document.getElementById('transaksi_id').addEventListener('change', hitung);

// auto trigger saat pertama load (edit mode)
window.onload = hitung;
</script>

@endsection