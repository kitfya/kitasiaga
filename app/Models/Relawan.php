<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Relawan extends Model
{
    protected $fillable = [
        'user_id',
        'bidang',
        'instansi',
        'posko_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function posko(): BelongsTo
    {
        return $this->belongsTo(Posko::class, 'posko_id');
    }
}
