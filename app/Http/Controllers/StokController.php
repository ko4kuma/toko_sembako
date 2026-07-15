<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Stok;
use Illuminate\Http\Request;

class StokController extends Controller
{
    public function index()
    {
        $stok = Stok::with('barang')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('stok.index', compact('stok'));
    }

}