<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Barang;
use App\Models\Transaksi;

class DetailTransaksi extends Model
{
    protected $fillable = [
        'transaksi_id',
        'barang_id',
        'qty',
        'subtotal'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}
