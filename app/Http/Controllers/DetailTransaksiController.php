<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Barang;

class DetailTransaksiController extends Controller
{
    public function index()
    {
        $detail = DetailTransaksi::with('barang','transaksi')->get();

        return view('detail-transaksi.index',
            compact('detail'));
    }

    public function create()
    {
        $transaksi = Transaksi::all();
        $barang = Barang::all();

        return view('detail-transaksi.create', compact('transaksi','barang'));
    }

    public function store(Request $request)
    {
        DetailTransaksi::create($request->all());

        return redirect()->route('detail-transaksi.index');
    }

    public function edit($id)
    {
        $detail = DetailTransaksi::findOrFail($id);

        $transaksi = Transaksi::all();
        $barang = Barang::all();

        return view('detail-transaksi.edit',
            compact('detail','transaksi','barang'));
    }

    public function update(Request $request, $id)
    {
        $detail = DetailTransaksi::findOrFail($id);

        $detail->update($request->all());

        return redirect()->route('detail-transaksi.index');
    }

    public function destroy($id)
    {
        $detail = DetailTransaksi::findOrFail($id);

        $detail->delete();

        return redirect()->route('detail-transaksi.index');
    }
}