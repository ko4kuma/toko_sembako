<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PegawaiController extends Controller
{
    // =========================
    // TAMPIL DAFTAR PEGAWAI
    // =========================
    public function index()
    {
        $pegawai = Pegawai::with('user')->orderBy('tanggal_masuk', 'desc')->get();

        return view('pegawai.index', compact('pegawai'));
    }

    // =========================
    // FORM TAMBAH PEGAWAI
    // =========================
    public function create()
    {
        return view('pegawai.create');
    }

    // =========================
    // SIMPAN PEGAWAI BARU (SEKALIGUS BIKIN AKUN USER)
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'tanggal_masuk' => 'nullable|date',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,kasir,gudang,purchasing',
        ]);

        $user = User::create([
            'name' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        Pegawai::create([
            'user_id' => $user->id,
            'nama_lengkap' => $request->nama_lengkap,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'tanggal_masuk' => $request->tanggal_masuk,
        ]);

        return redirect()->route('pegawai.index')
            ->with('success', 'Pegawai berhasil ditambahkan.');
    }

    // =========================
    // FORM EDIT PEGAWAI
    // =========================
    public function edit($id)
    {
        $pegawai = Pegawai::with('user')->findOrFail($id);

        return view('pegawai.edit', compact('pegawai'));
    }

    // =========================
    // UPDATE PEGAWAI
    // =========================
    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::with('user')->findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'tanggal_masuk' => 'nullable|date',
            'email' => 'required|email|unique:users,email,'.$pegawai->user_id,
            'role' => 'required|in:admin,kasir,gudang,purchasing',
            'password' => 'nullable|min:6',
        ]);

        $pegawai->update([
            'nama_lengkap' => $request->nama_lengkap,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'tanggal_masuk' => $request->tanggal_masuk,
        ]);

        $dataUser = [
            'name' => $request->nama_lengkap,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $dataUser['password'] = Hash::make($request->password);
        }

        $pegawai->user->update($dataUser);

        return redirect()->route('pegawai.index')
            ->with('success', 'Pegawai berhasil diupdate.');
    }

    // =========================
    // HAPUS PEGAWAI (SEKALIGUS AKUN USER-NYA)
    // =========================
    public function destroy($id)
    {
        $pegawai = Pegawai::with('user')->findOrFail($id);

        // Hapus user otomatis ikut hapus pegawai (cascadeOnDelete)
        $pegawai->user->delete();

        return redirect()->route('pegawai.index')
            ->with('success', 'Pegawai berhasil dihapus.');
    }
}