<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Pembelian;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $dari = $request->query('dari');
        $sampai = $request->query('sampai');

        $omset = 0;
        $modal = 0;
        $labaKotor = 0;
        $sudahFilter = false;

        $daftarTransaksi = collect();
        $daftarPembelian = collect();

        if ($dari && $sampai) {
            $sudahFilter = true;

            $omset = Transaksi::whereBetween('tanggal', [$dari, $sampai])->sum('total_akhir');
            $modal = Pembelian::whereBetween('tanggal', [$dari, $sampai])->sum('total');
            $labaKotor = $omset - $modal;

            $daftarTransaksi = Transaksi::with(['member', 'user'])
                ->whereBetween('tanggal', [$dari, $sampai])
                ->orderBy('tanggal')
                ->get();

            $daftarPembelian = Pembelian::with(['supplier', 'user'])
                ->whereBetween('tanggal', [$dari, $sampai])
                ->orderBy('tanggal')
                ->get();
        }
        return view('laporan.index', compact('dari', 'sampai', 'omset', 'modal', 'labaKotor', 'sudahFilter', 'daftarTransaksi', 'daftarPembelian'));
    }
    
    public function print(Request $request)
    {
    $dari = $request->query('dari');
    $sampai = $request->query('sampai');

    $omset = Transaksi::whereBetween('tanggal', [$dari, $sampai])->sum('total_akhir');
    $modal = Pembelian::whereBetween('tanggal', [$dari, $sampai])->sum('total');
    $labaKotor = $omset - $modal;

    $daftarTransaksi = Transaksi::with(['member', 'user'])
        ->whereBetween('tanggal', [$dari, $sampai])
        ->orderBy('tanggal')
        ->get();

    $daftarPembelian = Pembelian::with(['supplier', 'user'])
        ->whereBetween('tanggal', [$dari, $sampai])
        ->orderBy('tanggal')
        ->get();

    return view('laporan.print', compact('dari', 'sampai', 'omset', 'modal', 'labaKotor', 'daftarTransaksi', 'daftarPembelian'));
    }
}