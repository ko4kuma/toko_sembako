<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use app\Models\Member;
use app\Models\DetailTransaksi;
use app\Models\Pembayaran;

class Transaksi extends Model
{
    protected $fillable = ['member_id'];

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
