<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Supplier;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barangs = Barang::with(['kategori', 'supplier'])->orderBy('nama_barang', 'asc')->get();
        return view('barang.index', compact('barangs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::all();
        $suppliers = Supplier::all();
        return view('barang.create', compact(['kategoris', 'suppliers']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
        'nama_barang' => 'required|string|max:255',
        'harga' => 'required|numeric|min:0',
        'kategori_id' => 'required|exists:kategoris,id',
        'supplier_id' => 'required|exists:suppliers,id',
        ]);

        Barang::create($validated);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan');
 
    }

    /**
     * Display the specified resource.
     */

    public function edit(string $id)
    {
        $barang = Barang::findOrFail($id);

        $kategoris = Kategori::all();
        $suppliers = Supplier::all();

        return view('barang.edit', compact(
            'barang',
            'kategoris',
            'suppliers'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
        'nama_barang' => 'required|string|max:255',
        'harga' => 'required|numeric|min:0',
        'kategori_id' => 'required|exists:kategoris,id',
        'supplier_id' => 'required|exists:suppliers,id',
        ]);

        $barang = Barang::findOrFail($id);

        $barang->update($validated);
        
        return redirect()->route('barang.index')->with('success', 'Barang berhasil diupdate');
        }
        
        /**
         * Remove the specified resource from storage.
        */
    public function destroy(string $id)
    {
        $barang = Barang::findOrFail($id);
    
        $barang->delete();
    
        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus');
        //
    }
}
