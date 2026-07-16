<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Pembelian;
use App\Models\StokOpname;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $hariIni = now()->toDateString();

        $data = [];

        if ($user->role === 'admin') {
            $data['omsetHariIni'] = Transaksi::whereDate('tanggal', $hariIni)->sum('total_akhir');
            $data['modalHariIni'] = Pembelian::whereDate('tanggal', $hariIni)->sum('total');
            $data['labaHariIni'] = $data['omsetHariIni'] - $data['modalHariIni'];

            $data['opnamePending'] = StokOpname::where('status', 'menunggu_approval')->count();

            $data['pieMetode'] = Transaksi::whereDate('tanggal', $hariIni)
                ->join('pembayarans', 'transaksis.id', '=', 'pembayarans.transaksi_id')
                ->selectRaw('pembayarans.metode, SUM(pembayarans.jumlah) as total')
                ->groupBy('pembayarans.metode')
                ->pluck('total', 'metode');
        }

        if ($user->role === 'kasir') {
            $data['jumlahTransaksiHariIni'] = Transaksi::where('user_id', $user->id)
                ->whereDate('tanggal', $hariIni)
                ->count();

            $data['omsetHariIniSaya'] = Transaksi::where('user_id', $user->id)
                ->whereDate('tanggal', $hariIni)
                ->sum('total_akhir');
        }

        if ($user->role === 'gudang') {
            $data['opnameDraft'] = StokOpname::where('user_id', $user->id)
                ->where('status', 'draft')
                ->count();

            $data['opnameMenungguSaya'] = StokOpname::where('user_id', $user->id)
                ->where('status', 'menunggu_approval')
                ->count();

            $data['stokMenipis'] = Barang::all()->filter(function ($b) {
                return $b->stokTerkini() < 10;
            });
        }

        if ($user->role === 'purchasing') {
            $awalBulan = now()->startOfMonth()->toDateString();
            $akhirBulan = now()->endOfMonth()->toDateString();

            $data['jumlahPembelianBulanIni'] = Pembelian::where('user_id', $user->id)
                ->whereBetween('tanggal', [$awalBulan, $akhirBulan])
                ->count();

            $data['totalBelanjaBulanIni'] = Pembelian::where('user_id', $user->id)
                ->whereBetween('tanggal', [$awalBulan, $akhirBulan])
                ->sum('total');
        }

        return view('dashboard.index', $data);
    }
}