<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aset extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'aset';

    protected $fillable = [
        'kode_aset',
        'nama',
        'kategori_aset_id',
        'lokasi_aset_id',
        'kondisi',
        'status',
        'tanggal_perolehan',
        'nilai_perolehan',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_perolehan' => 'date',
            'nilai_perolehan' => 'decimal:2',
        ];
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriAset::class, 'kategori_aset_id');
    }

    public function lokasi()
    {
        return $this->belongsTo(LokasiAset::class, 'lokasi_aset_id');
    }

    public function peminjaman()
    {
        return $this->hasMany(PeminjamanAset::class, 'aset_id');
    }
}
