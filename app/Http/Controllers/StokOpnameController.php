<?php

namespace App\Http\Controllers;
use App\Models\StokOpname;
use App\Models\StokOpnameDetail;
use App\Models\Barang;
use App\Models\Stok;
use Illuminate\Http\Request;

class StokOpnameController extends Controller
{
    // tampil data sesi opname
    public function index()
    {
        $query = StokOpname::with('user');

        if (auth()->user()->role !== 'admin') {
            $query->where('user_id', auth()->id());
        }

        $stokOpname = $query->orderBy('created_at', 'desc')->get();

        return view('stok-opname.index', compact('stokOpname'));
    }

    // form sesi baru
    public function create() {
    
        if (auth()->user()->role !== 'gudang') {
            abort(403, 'Hanya Gudang yang dapat membuat sesi opname.');
        }
        return view('stok-opname.create');
    }

    // simpan sesi baru
    public function store(Request $request)
    {
        $adaOpnameAktif = StokOpname::where('user_id', auth()->id())
            ->whereIn('status', ['draft', 'menunggu_approval'])
            ->exists();

        if ($adaOpnameAktif) {
            return back()->with('error', 'Anda masih punya sesi opname yang belum selesai atau menunggu approval.');
        }
        if (auth()->user()->role !== 'gudang') {
            abort(403, 'Hanya Gudang yang dapat membuat sesi opname.');
        }

        $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $stokOpname = StokOpname::create([
            'user_id' => auth()->id(),
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
            'status' => 'draft',
        ]);

        return redirect()->route('stok-opname.isi', $stokOpname->id)
            ->with('success', 'Sesi opname berhasil dibuat, silakan isi data barang.');
    }
    public function destroy($id) 
    {
        $stokOpname = StokOpname::findOrFail($id);
        $this->authorize('delete', $stokOpname);

        if ($stokOpname->status !== 'draft') {
            return back()->with('error', 'Sesi opname yang sudah diajukan/disetujui tidak bisa dihapus.');
        }

        $stokOpname->delete();

        return redirect()->route('stok-opname.index')
            ->with('success', 'Sesi opname berhasil dihapus.');
    }

    // isi detail barang
    public function isiDetail($id)
    {
        $stokOpname = StokOpname::with(['detail.barang', 'user'])->findOrFail($id);
        $this->authorize('view', $stokOpname);
        $barang = Barang::all();

        return view('stok-opname.isi', compact('stokOpname', 'barang'));
    }

    // simpan detail barang
    public function simpanDetail(Request $request, $id)
    {
        $stokOpname = StokOpname::findOrFail($id);
        $this->authorize('edit', $stokOpname);

        $this->simpanDataBarang($request, $stokOpname);

        return redirect()->route('stok-opname.isi', $stokOpname->id)
            ->with('success', 'Data opname berhasil disimpan sebagai draft.');
    }

    //finalisasi sesi opname
    public function ajukan(Request $request, $id)
    {
        $stokOpname = StokOpname::findOrFail($id);
        $this->authorize('ajukan', $stokOpname);

        if ($stokOpname->status !== 'draft') {
            return back()->with('error', 'Sesi opname ini sudah diajukan/diproses sebelumnya.');
        }

        $this->simpanDataBarang($request, $stokOpname);

        $stokOpname->update([
            'status' => 'menunggu_approval',
            'catatan_approval' => null,
        ]);

        return redirect()->route('stok-opname.index')
            ->with('success', 'Opname berhasil diajukan, menunggu approval admin.');
    }
    
    // SETUJUI OPNAME (ADMIN) - INSERT KE STOKS
    public function approve(Request $request, $id)
    {
        $stokOpname = StokOpname::with('detail')->findOrFail($id);
        $this->authorize('approve', $stokOpname);

        if ($stokOpname->status !== 'menunggu_approval') {
            return back()->with('error', 'Opname ini tidak dalam status menunggu approval.');
        }

        $barangIds = $stokOpname->detail->pluck('barang_id');

        $adaOpnameLainOverlap = StokOpnameDetail::whereIn('barang_id', $barangIds)
            ->whereHas('stokOpname', function ($q) use ($stokOpname) {
                $q->where('status', 'menunggu_approval')
                ->where('id', '!=', $stokOpname->id);
            })
            ->exists();

        if ($adaOpnameLainOverlap && !$request->has('konfirmasi_overlap')) {
            return back()->with('warning', 'Ada opname lain yang menunggu approval dengan barang yang sama. Approve opname ini akan mengabaikan perhitungan opname lainnya untuk barang tersebut. Klik "Setujui" sekali lagi untuk tetap lanjutkan.');
        }

        foreach ($stokOpname->detail as $d) {
            if ($d->selisih == 0) continue;

            $barang = Barang::findOrFail($d->barang_id);
            $stokSebelum = $barang->stokTerkini();
            $stokSesudah = $stokSebelum + $d->selisih;

            Stok::create([
                'barang_id' => $barang->id,
                'jumlah' => abs($d->selisih),
                'jenis' => 'penyesuaian',
                'stok_sebelum' => $stokSebelum,
                'stok_sesudah' => $stokSesudah,
                'referensi_type' => StokOpname::class,
                'referensi_id' => $stokOpname->id,
                'keterangan' => $d->catatan,
            ]);
        }

        $stokOpname->update(['status' => 'disetujui']);

        return redirect()->route('stok-opname.index')
            ->with('success', 'Opname berhasil disetujui, stok telah disesuaikan.');
    }
    // TOLAK OPNAME (ADMIN) - BALIK KE DRAFT
    public function reject(Request $request, $id)
    {
        $stokOpname = StokOpname::findOrFail($id);
        $this->authorize('approve', $stokOpname);

        if ($stokOpname->status !== 'menunggu_approval') {
            return back()->with('error', 'Opname ini tidak dalam status menunggu approval.');
        }
        $request->validate([
            'catatan_approval' => 'required|string',
        ]);

        $stokOpname->update([
            'status' => 'draft',
            'catatan_approval' => $request->catatan_approval,
        ]);

        return redirect()->route('stok-opname.index')
            ->with('success', 'Opname ditolak dan dikembalikan ke Gudang untuk revisi.');
    }
    private function simpanDataBarang(Request $request, StokOpname $stokOpname)
    {
        $request->validate([
            'barang_id' => 'required|array|min:1',
            'barang_id.*' => 'required|exists:barangs,id',
            'stok_fisik' => 'required|array',
            'stok_fisik.*' => 'required|numeric|min:0',
        ]);

        \DB::transaction(function () use ($request, $stokOpname) {
            StokOpnameDetail::where('stok_opname_id', $stokOpname->id)->delete();

            foreach ($request->barang_id as $key => $barangId) {
                $barang = Barang::findOrFail($barangId);
                $stokSistem = $barang->stokTerkini();
                $stokFisik = $request->stok_fisik[$key];
                $selisih = $stokFisik - $stokSistem;

                StokOpnameDetail::create([
                    'stok_opname_id' => $stokOpname->id,
                    'barang_id' => $barangId,
                    'stok_sistem' => $stokSistem,
                    'stok_fisik' => $stokFisik,
                    'selisih' => $selisih,
                    'catatan' => $request->catatan[$key] ?? null,
                ]);
            }
        });
    }
}