<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\Supplier;
use App\Models\Barang;
use App\Models\DetailPembelian;
use App\Models\Stok;

class PembelianController extends Controller
{
    // =========================
    // TAMPIL RIWAYAT PEMBELIAN
    // =========================
    public function index()
    {
        $pembelian = Pembelian::with('supplier')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pembelian.index', compact('pembelian'));
    }

    // =========================
    // FORM TAMBAH PEMBELIAN
    // =========================
    public function create()
    {
        $supplier = Supplier::all();
        $barang = Barang::all();

        return view('pembelian.create', compact('supplier', 'barang'));
    }

    // =========================
    // SIMPAN PEMBELIAN
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'nullable|exists:suppliers,id',
            'tanggal' => 'required|date',
            'barang_id' => 'required|array',
            'barang_id.*' => 'required|exists:barangs,id',
            'qty' => 'required|array',
            'qty.*' => 'required|numeric|min:1',
            'harga_beli' => 'required|array',
            'harga_beli.*' => 'required|numeric|min:0',
        ]);

        $total = 0;

        foreach ($request->barang_id as $key => $barangId) {
            $qty = $request->qty[$key];
            $hargaBeli = $request->harga_beli[$key];
            $total += $qty * $hargaBeli;
        }

        $pembelian = Pembelian::create([
            'supplier_id' => $request->supplier_id,
            'tanggal' => $request->tanggal,
            'total' => $total,
        ]);

        foreach ($request->barang_id as $key => $barangId) {
            $barang = Barang::findOrFail($barangId);
            $qty = $request->qty[$key];
            $hargaBeli = $request->harga_beli[$key];
            $subtotal = $qty * $hargaBeli;

            DetailPembelian::create([
                'pembelian_id' => $pembelian->id,
                'barang_id' => $barangId,
                'qty' => $qty,
                'harga_beli' => $hargaBeli,
                'subtotal' => $subtotal,
            ]);

            // TAMBAH STOK
            $stokSebelum = $barang->stokTerkini();
            $stokSesudah = $stokSebelum + $qty;

            Stok::create([
                'barang_id' => $barang->id,
                'jumlah' => $qty,
                'jenis' => 'masuk',
                'stok_sebelum' => $stokSebelum,
                'stok_sesudah' => $stokSesudah,
                'referensi_type' => Pembelian::class,
                'referensi_id' => $pembelian->id,
            ]);
        }

        return redirect()->route('pembelian.index')
            ->with('success', 'Pembelian berhasil disimpan.');
    }
    // =========================
    // DETAIL PEMBELIAN
    // =========================
    public function detail($id)
    {
        $pembelian = Pembelian::with('supplier')->findOrFail($id);

        $detail = DetailPembelian::with('barang')
                    ->where('pembelian_id', $id)
                    ->get();

        return view('pembelian.detail', compact('pembelian', 'detail'));
    }
}
