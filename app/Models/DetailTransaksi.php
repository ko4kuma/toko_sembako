<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use app\Models\Barang;
use app\Models\Transaksi;

class DetailTransaksi extends Model
{
    protected $fillable = ['barang_id', 'jumlah', 'harga_satuan'];

    public function barang(){
        return $this->belongsTo(Barang::class);
    }
    public function transaksi(){
        return $this->belongsTo(Transaksi::class);
    }
}
