<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Supplier;
use App\Models\DetailPembelian;

class Pembelian extends Model
{
    protected $fillable = [
        'supplier_id',
        'tanggal',
        'total',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function detail()
    {
        return $this->hasMany(DetailPembelian::class);
    }
}
