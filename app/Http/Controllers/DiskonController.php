<?php

namespace App\Http\Controllers;

use App\Models\Diskon;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class DiskonController extends Controller
{
    public function index()
    {
        $diskon = Diskon::orderBy('created_at', 'asc')->get();

        return view('diskon.index', compact('diskon'));
    }

    public function create()
    {
        return view('diskon.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_diskon' => 'required|string|max:255',
            'tipe' => 'required|in:umum,member',
            'syarat_minimal' => 'required|numeric|min:0',
            'persentase' => 'required|numeric|min:0|max:100',
            'berlaku_mulai' => 'nullable|date|after_or_equal:today',
            'berlaku_sampai' => 'nullable|date|after_or_equal:berlaku_mulai',
            'aktif' => 'required|in:0,1',
        ]);

        Diskon::create([
            'nama_diskon' => $request->nama_diskon,
            'tipe' => $request->tipe,
            'syarat_minimal' => $request->syarat_minimal,
            'persentase' => $request->persentase,
            'berlaku_mulai' => $request->berlaku_mulai,
            'berlaku_sampai' => $request->berlaku_sampai,
            'aktif' => $request->aktif,
        ]);

        return redirect()->route('diskon.index')
            ->with('success', 'Diskon berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $diskon = Diskon::findOrFail($id);

        return view('diskon.edit', compact('diskon'));
    }

    public function update(Request $request, $id)
    {
        $diskon = Diskon::findOrFail($id);
        $request->validate([
            'nama_diskon' => 'required|string|max:255',
            'tipe' => 'required|in:umum,member',
            'syarat_minimal' => 'required|numeric|min:0',
            'persentase' => 'required|numeric|min:0|max:100',
            'berlaku_mulai' => 'nullable|date|after_or_equal:today',
            'berlaku_sampai' => 'nullable|date|after_or_equal:berlaku_mulai',
            'aktif' => 'required|in:0,1',
        ]);

        $diskon->update([
            'nama_diskon' => $request->nama_diskon,
            'tipe' => $request->tipe,
            'syarat_minimal' => $request->syarat_minimal,
            'persentase' => $request->persentase,
            'berlaku_mulai' => $request->berlaku_mulai,
            'berlaku_sampai' => $request->berlaku_sampai,
            'aktif' => $request->aktif,
        ]);

        return redirect()->route('diskon.index')
            ->with('success', 'Diskon berhasil diupdate.');
    }

    public function destroy($id)
    {
        $diskon = Diskon::findOrFail($id);
        // cek apakah diskon pernah terpakai di transaksi
        $terpakai = Transaksi::where('diskon_member_id', $id)
            ->orWhere('diskon_umum_id', $id)
            ->exists();

        if ($terpakai) {
            return back()->with('error',
                'Diskon ini sudah pernah dipakai di transaksi, tidak bisa dihapus.'
            );
        }

        $diskon->delete();

        return redirect()->route('diskon.index')
            ->with('success', 'Diskon berhasil dihapus.');
    }
}