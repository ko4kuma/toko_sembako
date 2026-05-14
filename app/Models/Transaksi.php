<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Member;
use App\Models\DetailTransaksi;
use App\Models\Pembayaran;

class Transaksi extends Model
{
     protected $fillable = [
        'member_id',
        'tanggal',
        'total'
    ];

    public function member(){
        return $this->belongsTo(Member::class);
    }
    public function detailTransaksi(){
        return $this->hasMany(DetailTransaksi::class);
    }
    public function pembayaran(){
        return $this->hasMany(Pembayaran::class);
    }
}
