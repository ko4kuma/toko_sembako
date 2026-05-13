<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategoris = Kategori::orderBy('nama_kategori', 'asc')->get();
        return view('kategori.index', compact('kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
        'nama_kategori' => 'required|string|max:255'
        ]);

        Kategori::create($validated);

        return redirect()->route('kategori.index')->with('success', 'Kategori Barang berhasil ditambahkan');
 
    }

    /**
     * Display the specified resource.
     */

    public function edit(string $id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
        'nama_kategori' => 'required|string|max:255'
        ]);

        $kategori = Kategori::findOrFail($id);

        $kategori->update($validated);
        
        return redirect()->route('kategori.index')->with('success', 'Kategori Barang berhasil diupdate');
        }
        
        /**
         * Remove the specified resource from storage.
        */
    public function destroy(string $id)
    {
        $kategori = Kategori::findOrFail($id);
    
        $kategori->delete();
    
        return redirect()->route('kategori.index')->with('success', 'Kategori barang berhasil dihapus');
        //
    }
}
