<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\StokOpnameDetail;

class StokOpname extends Model
{
    protected $fillable = [
        'tanggal',
        'keterangan',
        'status',
    ];

    public function detail()
    {
        return $this->hasMany(StokOpnameDetail::class);
    }
}
