<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengembalianAset extends Model
{
    use HasFactory;

    protected $table = 'pengembalian_aset';

    protected $fillable = [
        'peminjaman_aset_id',
        'tanggal_kembali',
        'kondisi_saat_kembali',
        'catatan',
        'status',
        'diverifikasi_by',
        'diverifikasi_at',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_kembali' => 'date',
            'diverifikasi_at' => 'datetime',
        ];
    }

    public function peminjaman()
    {
        return $this->belongsTo(PeminjamanAset::class, 'peminjaman_aset_id');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'diverifikasi_by');
    }

    public function beritaAcara()
    {
        return $this->hasOne(BeritaAcara::class, 'pengembalian_aset_id');
    }
}
