<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teknisi extends Model
{
    protected $table = 'teknisi';

    protected $fillable = [
        'nama_teknisi',
        'no_hp',
        'alamat',
    ];

    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class);
    }
}
