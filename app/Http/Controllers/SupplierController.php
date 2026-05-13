<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::orderBy('nama_supplier', 'asc')->get();
        return view('supplier.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

        'nama_supplier' => 'required|string|max:255',
        'alamat' => 'required|string|max:255',
        'no_hp' => 'required|string|max:15',
        ]);

        Supplier::create($validated);

        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil ditambahkan');
 
    }

    /**
     * Display the specified resource.
     */

    public function edit(string $id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('supplier.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([

        'nama_supplier' => 'required|string|max:255',
        'alamat' => 'required|string|max:255',
        'no_hp' => 'required|string|max:15',

        ]);
        $supplier = Supplier::findOrFail($id);

        $supplier->update($validated);
        
        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil diupdate');
        }
        
        /**
         * Remove the specified resource from storage.
        */
    public function destroy(string $id)
    {
        $supplier = Supplier::findOrFail($id);
    
        $supplier->delete();
    
        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil dihapus');
        //
    }
}
