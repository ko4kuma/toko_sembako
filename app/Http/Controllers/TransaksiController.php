<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Member;
use App\Models\Barang;

class TransaksiController extends Controller
{
    // =========================
    // TAMPIL DATA TRANSAKSI
    // =========================
    public function index()
    {
        $transaksi = Transaksi::with('member')->get();

        return view('transaksi.index', compact('transaksi'));
    }

    // =========================
    // FORM TAMBAH TRANSAKSI
    // =========================
    public function create()
    {
        $member = Member::all();
        $barang = Barang::all();

        return view('transaksi.create', compact('member','barang'));
    }

    // =========================
    // SIMPAN TRANSAKSI (SUDAH REQUIRED)
    // =========================
    public function store(Request $request)
    {
        // VALIDASI
        $request->validate([
            'member_id' => 'required',
            'tanggal' => 'required|date',
            'barang_id' => 'required|array',
            'barang_id.*' => 'required',
            'qty' => 'required|array',
            'qty.*' => 'required|numeric|min:1',
        ]);

        $total = 0;

        // HITUNG TOTAL + CEK STOK
        foreach($request->barang_id as $key => $barangId)
        {
            $barang = Barang::findOrFail($barangId);
            $qty = $request->qty[$key];

            if($qty <= 0) continue;

            if($barang->stok < $qty)
            {
                return back()->with('error',
                    'Stok '.$barang->nama_barang.' tidak cukup!'
                );
            }

            $total += $barang->harga * $qty;
        }

        // SIMPAN TRANSAKSI
        $transaksi = Transaksi::create([
            'member_id' => $request->member_id,
            'tanggal' => $request->tanggal,
            'total' => $total
        ]);

        // SIMPAN DETAIL
        foreach($request->barang_id as $key => $barangId)
        {
            $barang = Barang::findOrFail($barangId);
            $qty = $request->qty[$key];

            if($qty >= 0) continue;

            DetailTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'barang_id' => $barangId,
                'qty' => $qty,
                'subtotal' => $barang->harga * $qty
            ]);

            // KURANGI STOK
            $barang->stok -= $qty;
            $barang->save();
        }

        return redirect()->route('transaksi.index')
            ->with('success','Transaksi berhasil ditambahkan');
    }

    // =========================
    // FORM EDIT (SUDAH FIX MULTI)
    // =========================
    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $member = Member::all();
        $barang = Barang::all();

        // FIX: HARUS GET (bukan first)
        $detail = DetailTransaksi::where('transaksi_id',$id)->get();

        return view('transaksi.edit', compact('transaksi','member','barang','detail'));
    }

    // =========================
    // UPDATE TRANSAKSI (SUDAH FIX MULTI + STOK AMAN)
    // =========================
    public function update(Request $request, $id)
    {
        $request->validate([
            'member_id' => 'required',
            'tanggal' => 'required|date',
            'barang_id' => 'required|array',
            'qty' => 'required|array',
        ]);

        $transaksi = Transaksi::findOrFail($id);

        // AMBIL DETAIL LAMA (UNTUK BALIK STOK)
        $detailLama = DetailTransaksi::where('transaksi_id',$id)->get();

        // BALIK STOK LAMA
        foreach($detailLama as $d)
        {
            $barang = Barang::find($d->barang_id);
            $barang->stok += $d->qty;
            $barang->save();
        }

        // HAPUS DETAIL LAMA
        DetailTransaksi::where('transaksi_id',$id)->delete();

        $total = 0;

        // SIMPAN ULANG DETAIL BARU
        foreach($request->barang_id as $key => $barangId)
        {
            $barang = Barang::findOrFail($barangId);
            $qty = $request->qty[$key];

            if($qty <= 0) continue;

            if($barang->stok < $qty)
            {
                return back()->with('error',
                    'Stok '.$barang->nama_barang.' tidak cukup!'
                );
            }

            $subtotal = $barang->harga * $qty;
            $total += $subtotal;

            DetailTransaksi::create([
                'transaksi_id' => $id,
                'barang_id' => $barangId,
                'qty' => $qty,
                'subtotal' => $subtotal
            ]);

            // KURANGI STOK BARU
            $barang->stok -= $qty;
            $barang->save();
        }

        // UPDATE TRANSAKSI
        $transaksi->update([
            'member_id' => $request->member_id,
            'tanggal' => $request->tanggal,
            'total' => $total
        ]);

        return redirect()->route('transaksi.index')
            ->with('success','Transaksi berhasil diupdate');
    }

    // =========================
    // HAPUS TRANSAKSI
    // =========================
    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        // BALIK STOK SEBELUM HAPUS
        $detail = DetailTransaksi::where('transaksi_id',$id)->get();

        foreach($detail as $d)
        {
            $barang = Barang::find($d->barang_id);
            $barang->stok += $d->qty;
            $barang->save();
        }

        DetailTransaksi::where('transaksi_id',$id)->delete();

        $transaksi->delete();

        return redirect()->route('transaksi.index')
            ->with('success','Transaksi berhasil dihapus');
    }

    // =========================
    // DETAIL
    // =========================
    public function detail($id)
    {
        $transaksi = Transaksi::with('member')->findOrFail($id);

        $detail = DetailTransaksi::with('barang')
                    ->where('transaksi_id',$id)
                    ->get();

        return view('transaksi.detail', compact('transaksi','detail'));
    }

    // =========================
    // STRUK
    // =========================
    public function struk($id)
    {
        $transaksi = Transaksi::with('member')
                        ->findOrFail($id);

        $detail = DetailTransaksi::with('barang')
                    ->where('transaksi_id', $id)
                    ->get();

        return view('transaksi.struk', compact('transaksi','detail'));
    }
}