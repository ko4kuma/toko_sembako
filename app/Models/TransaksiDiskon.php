<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Transaksi;
use App\Models\Diskon;

class TransaksiDiskon extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'transaksi_id',
        'diskon_id',
        'nominal_diskon',
    ];
    public function transaksi(){
        return $this->belongsTo(Transaksi::class);
    }
    public function diskon(){
        return $this->belongsTo(Diskon::class);
    }
}
