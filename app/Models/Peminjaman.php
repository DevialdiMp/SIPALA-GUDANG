<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';

    protected $fillable = [
        'teknisi_id',
        'alat_id',
        'waktu_pinjam',
        'kondisi_pinjam',
        'waktu_kembali',
        'kondisi_kembali',
        'catatan',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'waktu_pinjam' => 'datetime',
            'waktu_kembali' => 'datetime',
        ];
    }

    public function teknisi(): BelongsTo
    {
        return $this->belongsTo(Teknisi::class);
    }

    public function alat(): BelongsTo
    {
        return $this->belongsTo(Alat::class);
    }
}
