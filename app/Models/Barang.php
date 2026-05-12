<?php

namespace App\Models;
use app\Models\Stok;
use app\Models\Kategori;
use app\Models\Supplier;
use app\Models\DetailTransaksi;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
   public function stok() {
    return $this->hasOne(Stok::class);
   }
   public function kategori() {
    return $this->belongsToMany(Kategori::class);
   }
   public function supplier() {
    return $this->belongsTo(Supplier::class);
   }
   public function detailTransaksi() {
    return $this->hasMany(DetailTransaksi::class);
   }
}
