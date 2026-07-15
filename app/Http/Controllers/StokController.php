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

        $barang = Barang::findOrFail($request->barang_id);
        $stokSebelum = $barang->stokTerkini();
        $stokSesudah = $stokSebelum + $request->jumlah;

        Stok::create([
            'barang_id' => $barang->id,
            'jumlah' => $request->jumlah,
            'jenis' => 'masuk',
            'stok_sebelum' => $stokSebelum,
            'stok_sesudah' => $stokSesudah,
            'keterangan' => $request->keterangan ?? null,
]);

        return redirect()->route('stok.index')
            ->with('success', 'Stok berhasil ditambahkan.');
    }
}