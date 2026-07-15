<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Member;
use App\Models\DetailTransaksi;
use App\Models\Pembayaran;
use App\Models\TransaksiDiskon;

class Transaksi extends Model
{
     protected $fillable = [
        'member_id',
        'tanggal',
        'total',
        'diskon',
        'total_akhir',
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
    public function transaksiDiskon(){
        return $this->hasMany(TransaksiDiskon::class);
    }
}
