<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Member;
use App\Models\Barang;
use App\Models\Diskon;
use App\Models\TransaksiDiskon;
use App\Models\Stok;
use App\Models\Pembayaran;

class TransaksiController extends Controller
{
    // =========================
    // TAMPIL DATA TRANSAKSI
    // =========================
    public function index()
    {
        $query = Transaksi::with(['member', 'user']);

        if (auth()->user()->role !== 'admin') {
            $query->where('user_id', auth()->id());
        }

        $transaksi = $query->orderBy('created_at', 'desc')->get();

        return view('transaksi.index', compact('transaksi'));
    }

    // =========================
    // FORM TAMBAH TRANSAKSI
    // =========================
    public function create()
    {
        $member = Member::all();
        $barang = Barang::all();

        return view('transaksi.create', compact('member','barang'));
    }

    // =========================
    // SIMPAN TRANSAKSI (SUDAH REQUIRED)
    // =========================
    public function store(Request $request)
    {
        // VALIDASI
        $request->validate([
            'member_id' => 'nullable|exists:members,id',
            'tanggal' => 'required|date',
            'barang_id' => 'required|array',
            'barang_id.*' => 'required',
            'qty' => 'required|array',
            'qty.*' => 'required|numeric|min:1',
            'diskon_ids' => 'nullable|array',
            'diskon_ids.*' => 'exists:diskons,id',
            'metode' => 'required|in:cash,transfer,qris,debit',
            'jumlah' => 'required|numeric|min:0',
        ]);
        $total = 0;
        // HITUNG TOTAL + CEK STOK
        foreach($request->barang_id as $key => $barangId)
        {
            $barang = Barang::findOrFail($barangId);
            $qty = $request->qty[$key];

            if($qty <= 0) continue;

            if($barang->stokTerkini() < $qty)
            {
                return back()->with('error',
                    'Stok '.$barang->nama_barang.' tidak cukup!'
                );
            }

            $total += $barang->harga * $qty;
        }
        // AMBIL & VALIDASI DISKON YANG DIPILIH
        $diskonIds = $request->diskon_ids ?? [];
        $diskonList = Diskon::whereIn('id', $diskonIds)->aktifSaatIni()->get();

        $totalDiskon = 0;
        $adaDiskonMember = false;

        foreach ($diskonList as $d) {
            // CEK APAKAH SYARAT MINIMAL TERPENUHI (validasi ulang di server, jangan percaya frontend)
            if ($total < $d->syarat_minimal) {
                return back()->with('error', 'Total belanja belum memenuhi syarat diskon "'.$d->nama_diskon.'"');
            }

            if ($d->tipe === 'member') {
                $adaDiskonMember = true;
            }

            $totalDiskon += $total * ($d->persentase / 100);
        }

        // KALAU ADA DISKON TIPE MEMBER, MEMBER_ID WAJIB ADA
        if ($adaDiskonMember && !$request->member_id) {
            return back()->with('error', 'Pilih member terlebih dahulu untuk menggunakan diskon member.');
        }

        $totalAkhir = $total - $totalDiskon;
        // SIMPAN TRANSAKSI
        $transaksi = Transaksi::create([
            'user_id' => auth()->id(),
            'member_id' => $request->member_id,
            'tanggal' => $request->tanggal,
            'total' => $total,
            'diskon' => $totalDiskon,
            'total_akhir' => $totalAkhir,
        ]);

        // SIMPAN RINCIAN DISKON YANG DIPAKAI
        foreach ($diskonList as $d) {
            TransaksiDiskon::create([
                'transaksi_id' => $transaksi->id,
                'diskon_id' => $d->id,
                'nominal_diskon' => $total * ($d->persentase / 100),
            ]);
        }
        // SIMPAN DETAIL
        foreach($request->barang_id as $key => $barangId)
        {
            $barang = Barang::findOrFail($barangId);
            $qty = $request->qty[$key];

            if($qty <= 0) continue;

            DetailTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'barang_id' => $barangId,
                'qty' => $qty,
                'harga_satuan' => $barang->harga,
                'subtotal' => $barang->harga * $qty
            ]);

            // KURANGI STOK
            $stokSebelum = $barang->stokTerkini();
            $stokSesudah = $stokSebelum - $qty;

            Stok::create([
                'barang_id' => $barang->id,
                'jumlah' => $qty,
                'jenis' => 'keluar',
                'stok_sebelum' => $stokSebelum,
                'stok_sesudah' => $stokSesudah,
                'referensi_type' => Transaksi::class,
                'referensi_id' => $transaksi->id,
            ]);
        }

        // VALIDASI & SIMPAN PEMBAYARAN
        $jumlahDibayar = $request->jumlah;
        $kembalian = 0;

        if ($request->metode === 'cash') {
            if ($jumlahDibayar < $totalAkhir) {
                return back()->with('error', 'Jumlah dibayar kurang dari total akhir.');
            }
            $kembalian = $jumlahDibayar - $totalAkhir;
        } else {
            // NON-CASH: paksa sama dengan total akhir, gak ada kembalian
            $jumlahDibayar = $totalAkhir;
            $kembalian = 0;
        }

        Pembayaran::create([
            'transaksi_id' => $transaksi->id,
            'metode' => $request->metode,
            'jumlah' => $jumlahDibayar,
            'kembalian' => $kembalian,
        ]);
        
        return redirect()->route('transaksi.create')
            ->with('success','Transaksi berhasil!');
    }

    // =========================
    // FORM EDIT (SUDAH FIX MULTI)
    // =========================
    // public function edit($id)
    // {
    //     $transaksi = Transaksi::findOrFail($id);
    //     $member = Member::all();
    //     $barang = Barang::all();

    //     // FIX: HARUS GET (bukan first)
    //     $detail = DetailTransaksi::where('transaksi_id',$id)->get();

    //     return view('transaksi.edit', compact('transaksi','member','barang','detail'));
    // }

    // =========================
    // UPDATE TRANSAKSI (SUDAH FIX MULTI + STOK AMAN)
    // =========================
    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'member_id' => 'nullable|exists:members,id',
    //         'tanggal' => 'required|date',
    //         'barang_id' => 'required|array',
    //         'qty' => 'required|array',
    //         'diskon_ids' => 'nullable|array',
    //         'diskon_ids.*' => 'exists:diskons,id',
    //     ]);

    //     $transaksi = Transaksi::findOrFail($id);

    //     // AMBIL DETAIL LAMA (UNTUK BALIK STOK)
    //     $detailLama = DetailTransaksi::where('transaksi_id',$id)->get();

    //     // BALIK STOK LAMA
    //     foreach($detailLama as $d)
    //     {
    //         $barang = Barang::find($d->barang_id);
    //         $barang->stok->jumlah += $d->qty;
    //         $barang->stok->save();
    //     }

    //     // HAPUS DETAIL LAMA
    //     DetailTransaksi::where('transaksi_id',$id)->delete();

    //     $total = 0;

    //     // SIMPAN ULANG DETAIL BARU
    //     foreach($request->barang_id as $key => $barangId)
    //     {
    //         $barang = Barang::findOrFail($barangId);
    //         $qty = $request->qty[$key];

    //         if($qty <= 0) continue;

    //         if($barang->stok->jumlah < $qty)
    //         {
    //             return back()->with('error',
    //                 'Stok '.$barang->nama_barang.' tidak cukup!'
    //             );
    //         }

    //         $subtotal = $barang->harga * $qty;
    //         $total += $subtotal;

    //         DetailTransaksi::create([
    //             'transaksi_id' => $id,
    //             'barang_id' => $barangId,
    //             'qty' => $qty,
    //             'subtotal' => $subtotal
    //         ]);

    //         // KURANGI STOK BARU
    //         $barang->stok->jumlah -= $qty;
    //         $barang->stok->save();
    //     }

    //     // UPDATE TRANSAKSI
    //     $transaksi->update([
    //         'member_id' => $request->member_id,
    //         'tanggal' => $request->tanggal,
    //         'total' => $total
    //     ]);

    //     return redirect()->route('transaksi.index')
    //         ->with('success','Transaksi berhasil diupdate');
    // }

    // =========================
    // HAPUS TRANSAKSI
    // =========================
    // public function destroy($id)
    // {
    //     $transaksi = Transaksi::findOrFail($id);

    //     // BALIK STOK SEBELUM HAPUS
    //     $detail = DetailTransaksi::where('transaksi_id',$id)->get();

    //     foreach($detail as $d)
    //     {
    //         $barang = Barang::find($d->barang_id);
    //         $barang->stok->jumlah += $d->qty;
    //         $barang->stok->save();
    //     }

    //     DetailTransaksi::where('transaksi_id',$id)->delete();

    //     $transaksi->delete();

    //     return redirect()->route('transaksi.index')
    //         ->with('success','Transaksi berhasil dihapus');
    // }

    // =========================
    // DETAIL
    // =========================
    public function detail($id)
    {
        $transaksi = Transaksi::with(['member', 'pembayaran', 'user'])->findOrFail($id);

        if (auth()->user()->role !== 'admin' && $transaksi->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke transaksi ini.');
        }

        $detail = DetailTransaksi::with('barang')
                    ->where('transaksi_id',$id)
                    ->get();

        return view('transaksi.detail', compact('transaksi','detail'));
    }

    // =========================
    // STRUK
    // =========================
    public function struk($id)
    {
        $transaksi = Transaksi::with(['member', 'pembayaran'])
                ->findOrFail($id);

        if (auth()->user()->role !== 'admin' && $transaksi->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke transaksi ini.');
        }

        $detail = DetailTransaksi::with('barang')
                    ->where('transaksi_id', $id)
                    ->get();

        return view('transaksi.struk', compact('transaksi','detail'));
    }
}