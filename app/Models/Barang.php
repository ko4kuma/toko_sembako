<?php

namespace App\Models;
use App\Models\Stok;
use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\DetailTransaksi;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
   protected $fillable = ['nama_barang', 'harga', 'kategori_id', 'supplier_id'];

   public function stok() {
    return $this->hasOne(Stok::class);
   }
   public function kategori() {
    return $this->belongsTo(Kategori::class);
   }
   public function supplier() {
    return $this->belongsTo(Supplier::class);
   }
   public function detailTransaksi() {
    return $this->hasMany(DetailTransaksi::class);
   }
}
