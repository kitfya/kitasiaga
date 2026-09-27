<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Logistik extends Model
{
    protected $fillable = [
        'name',
        'tipe',
        'jumlah',
        'posko_id',
    ];

    public function posko(): BelongsTo
    {
        return $this->belongsTo(Posko::class);
    }
}
