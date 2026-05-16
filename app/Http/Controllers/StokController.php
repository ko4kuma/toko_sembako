<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Stok;
use Illuminate\Http\Request;

class StokController extends Controller
{
    public function index()
    {
        $stok = Stok::with('barang')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('stok.index', compact('stok'));
    }

    public function create()
    {
        $barang = Barang::all();

        return view('stok.create', compact('barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $stok = new Stok();
        $stok->barang_id = $request->barang_id;
        $stok->jumlah = $request->jumlah;
        $stok->save();

        return redirect()->route('stok.index')
            ->with('success', 'Stok berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $stok = Stok::findOrFail($id);
        $barang = Barang::all();

        return view('stok.edit', compact('stok', 'barang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $stok = Stok::findOrFail($id);
        $stok->barang_id = $request->barang_id;
        $stok->jumlah = $request->jumlah;
        $stok->save();

        return redirect()->route('stok.index')
            ->with('success', 'Stok berhasil diupdate.');
    }

    public function destroy($id)
    {
        $stok = Stok::findOrFail($id);
        $stok->delete();

        return redirect()->route('stok.index')
            ->with('success', 'Stok berhasil dihapus.');
    }
}