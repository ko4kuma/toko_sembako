<?php

namespace App\Models;
use App\Models\Barang;

use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    protected $fillable = [
        'jumlah',
        'barang_id',
        'jenis',
        'stok_sebelum',
        'stok_sesudah',
        'referensi_type',
        'referensi_id',
        'keterangan',];

    public function barang() {
        return $this->belongsTo(Barang::class);
    }

    public function referensi() {
        return $this->morphTo();
    }
}
