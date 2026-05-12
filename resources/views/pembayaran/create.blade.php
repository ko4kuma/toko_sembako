@extends('layout.index')

@section('content')

<div class="container py-4">

    <div class="card border-1">

        <div class="card-header bg-success text-white text-center">
            <h5 class="mb-0 fw-bold">
                Tambah Pembayaran
            </h5>
        </div>

        <div class="card-body">

            <form action="{{ route('pembayaran.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Transaksi</label>

                    <select name="transaksi_id" id="transaksi_id" class="form-select" required>
                        <option value="">Pilih Transaksi</option>

                        @foreach($transaksi as $t)

                            @php
                                $member = $t->member;
                                $diskon = ($member && $member->diskon)
                                    ? $member->diskon->persentase
                                    : 0;
                            @endphp

                            <option value="{{ $t->id }}"
                                    data-total="{{ $t->total }}"
                                    data-diskon="{{ $diskon }}">

                                @if($member)
                                    {{ $member->nama_member }} (MEMBER)
                                @else
                                    Non Member
                                @endif

                                - Rp {{ number_format($t->total, 0, ',', '.') }}

                            </option>

                        @endforeach

                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Metode Pembayaran</label>

                    <select name="metode" class="form-select" required>
                        <option value="">Pilih Metode</option>
                        <option value="Cash">Cash</option>
                        <option value="Transfer">Transfer</option>
                        <option value="QRIS">QRIS</option>
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
                    <input type="text" id="total_display" class="form-control fw-bold" readonly>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">

                    <a href="{{ route('pembayaran.index') }}" class="btn btn-secondary px-4">
                        Kembali
                    </a>

                    <button type="submit" class="btn btn-success px-4">
                        Simpan
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<script>
document.getElementById('transaksi_id').addEventListener('change', function () {

    let selected = this.options[this.selectedIndex];

    let total = parseFloat(selected.getAttribute('data-total')) || 0;
    let diskon = parseFloat(selected.getAttribute('data-diskon')) || 0;

    let potongan = (total * diskon) / 100;
    let grandTotal = total - potongan;

    let format = new Intl.NumberFormat('id-ID');

    document.getElementById('total_kotor').value =
        'Rp ' + format.format(total);

    document.getElementById('diskon_display').value =
        diskon + '% (-Rp ' + format.format(potongan) + ')';

    document.getElementById('total_display').value =
        'Rp ' + format.format(grandTotal);
});
</script>

@endsection