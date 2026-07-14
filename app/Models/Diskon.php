<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diskon extends Model
{
    const TIPE = [
        'umum' => 'Umum (berlaku semua pelanggan)',
        'member' => 'Member (khusus pelanggan member)'
    ];
    protected $fillable = ['nama_diskon', 'tipe', 'syarat_minimal',
        'persentase', 'berlaku_mulai', 'berlaku_sampai', 'aktif'];
    
    protected $casts = [
        'aktif' => 'boolean',
        'berlaku_mulai' => 'datetime',
        'berlaku_sampai' => 'datetime',
    ];

    public function scopeAktifSaatIni($query)
    {
        return $query->where('aktif', true)
            ->where(function ($q) {
                $q->whereNull('berlaku_mulai')->orWhere('berlaku_mulai', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('berlaku_sampai')->orWhere('berlaku_sampai', '>=', now());
            });
    }
}
