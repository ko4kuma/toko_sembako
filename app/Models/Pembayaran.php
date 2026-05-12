<?php

namespace App\Models;
use app\Models\Transaksi;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    public function transaksi() {
        return $this->belongsTo(Transaksi::class);
    }
}
