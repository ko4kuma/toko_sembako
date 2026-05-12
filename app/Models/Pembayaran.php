<?php

namespace App\Models;
use app\Models\Transaksi;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $fillable = ['metode'];

    public function transaksi() {
        return $this->belongsTo(Transaksi::class);
    }
}
