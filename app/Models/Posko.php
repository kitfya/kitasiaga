<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Posko extends Model
{
    protected $fillable = [
        'name',
        'alamat',
        'kapasitas',
        'jumlah_pengungsi',
        'latitude',
        'longitude',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function logistik(): HasMany
    {
        return $this->hasMany(Logistik::class);
    }

    public function relawan(): HasMany
    {
        return $this->hasMany(Relawan::class);
    }

    public function korban(): HasMany
    {
        return $this->hasMany(Korban::class);
    }
}
