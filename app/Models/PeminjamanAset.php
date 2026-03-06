<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanAset extends Model
{
    use HasFactory;

    protected $table = 'peminjaman_aset';

    protected $fillable = [
        'aset_id',
        'pegawai_id',
        'tanggal_pinjam',
        'tanggal_rencana_kembali',
        'keterangan',
        'status',
        'approved_by',
        'approved_at',
        'alasan_penolakan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pinjam' => 'date',
            'tanggal_rencana_kembali' => 'date',
            'approved_at' => 'datetime',
        ];
    }

    public function aset()
    {
        return $this->belongsTo(Aset::class, 'aset_id');
    }

    public function pegawai()
    {
        return $this->belongsTo(User::class, 'pegawai_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function pengembalian()
    {
        return $this->hasOne(PengembalianAset::class, 'peminjaman_aset_id');
    }
}
