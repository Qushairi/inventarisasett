<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiAset extends Model
{
    use HasFactory;

    protected $table = 'lokasi_aset';

    protected $fillable = [
        'nama',
        'kode',
        'alamat',
        'keterangan',
    ];

    public function aset()
    {
        return $this->hasMany(Aset::class, 'lokasi_aset_id');
    }
}
