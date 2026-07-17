<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Models\Stok;
use App\Models\Barang;

class PembayaranController extends Controller
{
    public function index()
    {
        $pembayaran = Pembayaran::with('transaksi.member')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('pembayaran.index', compact('pembayaran'));
    }

    public function create()
    {
        $transaksi = Transaksi::with('member.diskon', 'detailTransaksi')
            ->get();

        foreach ($transaksi as $t) {
            $t->total = $this->hitungTotal($t);
        }

        return view('pembayaran.create', compact('transaksi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaksi_id' => 'required|exists:transaksis,id',
            'metode'       => 'required|string|max:50',
        ]);

        $transaksi = Transaksi::with('member.diskon', 'detailTransaksi')
            ->findOrFail($request->transaksi_id);

        $total = $this->hitungTotal($transaksi);

        $diskon = $this->hitungDiskon($transaksi, $total);

        $grandTotal = $total - $diskon;

        Pembayaran::create([
            'transaksi_id' => $request->transaksi_id,
            'metode'       => $request->metode,
            'jumlah'       => $grandTotal,
        ]);

        foreach ($transaksi->detailTransaksi as $detail) {

        $barang = $detail->barang;

        $stokSebelum = $barang->stokTerkini();

        $stokSesudah = $stokSebelum - $detail->jumlah;

        Stok::create([
            'barang_id'       => $barang->id,
            'jumlah'          => $detail->jumlah,
            'jenis'           => 'keluar',
            'stok_sebelum'    => $stokSebelum,
            'stok_sesudah'    => $stokSesudah,
            'referensi_type'  => Transaksi::class,
            'referensi_id'    => $transaksi->id,
            'keterangan'      => 'Penjualan',
        ]);

    }
        $transaksi->update([
            'status' => 'lunas'
        ]);

        return redirect()->route('pembayaran.index')
            ->with('success', 'Pembayaran berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);

        $transaksi = Transaksi::with('member.diskon', 'detailTransaksi')
            ->get();

        foreach ($transaksi as $t) {
            $t->total = $this->hitungTotal($t);
        }

        return view('pembayaran.edit', compact('pembayaran', 'transaksi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'transaksi_id' => 'required|exists:transaksis,id',
            'metode'       => 'required|string|max:50',
        ]);

        $pembayaran = Pembayaran::findOrFail($id);

        $transaksi = Transaksi::with('member.diskon', 'detailTransaksi')
            ->findOrFail($request->transaksi_id);

        $total = $this->hitungTotal($transaksi);

        $diskon = $this->hitungDiskon($transaksi, $total);

        $grandTotal = $total - $diskon;

        $pembayaran->update([
            'transaksi_id' => $request->transaksi_id,
            'metode'       => $request->metode,
            'jumlah'       => $grandTotal,
        ]);

        return redirect()->route('pembayaran.index')
            ->with('success', 'Pembayaran berhasil diupdate.');
    }

    public function destroy($id)
    {
        Pembayaran::findOrFail($id)->delete();

        return redirect()->route('pembayaran.index')
            ->with('success', 'Pembayaran berhasil dihapus.');
    }


    private function hitungTotal($transaksi)
    {
        return $transaksi->detailTransaksi->sum(function ($item) {
            return $item->jumlah * $item->harga_satuan;
        });
    }

    private function hitungDiskon($transaksi, $total)
    {
        if ($transaksi->member && $transaksi->member->diskon) {
            return ($total * $transaksi->member->diskon->persentase) / 100;
        }

        return 0;
    }
}