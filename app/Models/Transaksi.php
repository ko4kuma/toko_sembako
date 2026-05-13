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

    // relasi ke member
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    // relasi ke detail transaksi
    public function detail()
    {
        return $this->hasMany(DetailTransaksi::class);
    }
}