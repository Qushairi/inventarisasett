<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeritaAcara extends Model
{
    use HasFactory;

    protected $table = 'berita_acara';

    protected $fillable = [
        'pengembalian_aset_id',
        'nomor_ba',
        'isi',
        'file_path',
        'ditandatangani_oleh',
        'tanggal_ba',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_ba' => 'date',
        ];
    }

    public function pengembalian()
    {
        return $this->belongsTo(PengembalianAset::class, 'pengembalian_aset_id');
    }
}
