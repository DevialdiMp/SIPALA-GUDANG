<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Alat extends Model
{
    protected $table = 'alat';

    protected $fillable = [
        'kode',
        'nama_alat',
        'kondisi',
        'status',
    ];

    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class);
    }
}
