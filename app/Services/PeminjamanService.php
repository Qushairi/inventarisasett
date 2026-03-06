<?php

namespace App\Services;

use App\Models\Aset;
use App\Models\PeminjamanAset;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PeminjamanService
{
    public function create(array $data): PeminjamanAset
    {
        return DB::transaction(function () use ($data) {
            $aset = Aset::query()->lockForUpdate()->findOrFail($data['aset_id']);

            if ($aset->status !== 'tersedia') {
                throw ValidationException::withMessages([
                    'aset_id' => 'Aset tidak tersedia untuk dipinjam.',
                ]);
            }

            return PeminjamanAset::query()->create([
                'aset_id' => $aset->id,
                'pegawai_id' => $data['pegawai_id'],
                'tanggal_pinjam' => $data['tanggal_pinjam'],
                'tanggal_rencana_kembali' => $data['tanggal_rencana_kembali'] ?? null,
                'keterangan' => $data['keterangan'] ?? null,
                'status' => 'menunggu',
            ]);
        });
    }

    public function approve(PeminjamanAset $peminjaman, ?int $approvedBy = null): PeminjamanAset
    {
        return DB::transaction(function () use ($peminjaman, $approvedBy) {
            $peminjaman = PeminjamanAset::query()->lockForUpdate()->findOrFail($peminjaman->id);

            if (! in_array($peminjaman->status, ['menunggu', 'disetujui'], true)) {
                throw ValidationException::withMessages([
                    'status' => 'Peminjaman tidak dapat disetujui pada status saat ini.',
                ]);
            }

            $aset = Aset::query()->lockForUpdate()->findOrFail($peminjaman->aset_id);

            if ($aset->status !== 'tersedia') {
                throw ValidationException::withMessages([
                    'aset_id' => 'Aset tidak tersedia untuk dipinjam.',
                ]);
            }

            $aset->update(['status' => 'dipinjam']);

            $peminjaman->update([
                'status' => 'dipinjam',
                'approved_by' => $approvedBy,
                'approved_at' => now(),
                'alasan_penolakan' => null,
            ]);

            return $peminjaman->fresh(['aset', 'pegawai', 'approver']);
        });
    }

    public function reject(PeminjamanAset $peminjaman, string $alasanPenolakan, ?int $approvedBy = null): PeminjamanAset
    {
        if (! in_array($peminjaman->status, ['menunggu', 'disetujui'], true)) {
            throw ValidationException::withMessages([
                'status' => 'Peminjaman tidak dapat ditolak pada status saat ini.',
            ]);
        }

        $peminjaman->update([
            'status' => 'ditolak',
            'approved_by' => $approvedBy,
            'approved_at' => now(),
            'alasan_penolakan' => $alasanPenolakan,
        ]);

        return $peminjaman->fresh(['aset', 'pegawai', 'approver']);
    }
}
