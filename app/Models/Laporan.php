<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Laporan extends Model
{
    protected $fillable = [
        'name',
        'kode',
        'tipe',
        'description',
        'bukti',
        'latitude',
        'longitude',
        'is_valid',
        'created_at',
    ];

    public function korban(): HasMany
    {
        return $this->hasMany(Korban::class);
    }
}
