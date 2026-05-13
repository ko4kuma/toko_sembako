<?php

namespace App\Models;
use App\Models\Transaksi;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $fillable = ['metode','jumlah','transaksi_id'];

    public function transaksi() {
        return $this->belongsTo(Transaksi::class);
    }
}
