<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Korban extends Model
{
    protected $fillable = [
        'laporan_id',
        'posko_id',
        'name',
        'usia',
        'kondisi',
        'nik',
        'kelompok_rentan',
        'kebutuhan',
    ];

    protected static function booted()
    {
        static::created(function ($korban) {
            if ($korban->posko_id) {
                $korban->posko()->increment('jumlah_pengungsi');
            }
        });

        static::updated(function ($korban) {
            if ($korban->isDirty('posko_id')) {
                $oldPoskoId = $korban->getOriginal('posko_id');
                $newPoskoId = $korban->posko_id;

                // Kurangi posko lama
                if ($oldPoskoId) {
                    Posko::where('id', $oldPoskoId)->decrement('jumlah_pengungsi');
                }

                // Tambah posko baru
                if ($newPoskoId) {
                    Posko::where('id', $newPoskoId)->increment('jumlah_pengungsi');
                }
            }
        });

        static::deleted(function ($korban) {
            if ($korban->posko_id) {
                $korban->posko()->decrement('jumlah_pengungsi');
            }
        });
    }

    public function laporan(): BelongsTo
    {
        return $this->belongsTo(Laporan::class);
    }

    public function posko(): BelongsTo
    {
        return $this->belongsTo(Posko::class);
    }
}
