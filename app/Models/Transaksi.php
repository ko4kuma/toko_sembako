<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Member;
use App\Models\DetailTransaksi;
use App\Models\Pembayaran;
use App\Models\TransaksiDiskon;
use App\Models\User;

class Transaksi extends Model
{
     protected $fillable = [
        'user_id',
        'member_id',
        'tanggal',
        'total',
        'diskon',
        'total_akhir',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function member(){
        return $this->belongsTo(Member::class);
    }
    public function detailTransaksi(){
        return $this->hasMany(DetailTransaksi::class);
    }
    public function pembayaran(){
        return $this->hasOne(Pembayaran::class);
    }
    public function transaksiDiskon(){
        return $this->hasMany(TransaksiDiskon::class);
    }
}
