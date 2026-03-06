<?php

namespace App\Services;

use App\Models\Aset;
use App\Models\BeritaAcara;
use App\Models\PengembalianAset;
use App\Models\PeminjamanAset;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PengembalianService
{
    public function create(array $data): PengembalianAset
    {
        return DB::transaction(function () use ($data) {
            $peminjaman = PeminjamanAset::query()->lockForUpdate()->findOrFail($data['peminjaman_aset_id']);

            if ($peminjaman->status !== 'dipinjam') {
                throw ValidationException::withMessages([
                    'peminjaman_aset_id' => 'Peminjaman belum berstatus dipinjam.',
                ]);
            }

            $existing = PengembalianAset::query()
                ->where('peminjaman_aset_id', $peminjaman->id)
                ->whereIn('status', ['menunggu_verifikasi', 'terverifikasi'])
                ->exists();

            if ($existing) {
                throw ValidationException::withMessages([
                    'peminjaman_aset_id' => 'Pengembalian untuk peminjaman ini sudah diajukan.',
                ]);
            }

            return PengembalianAset::query()->create([
                'peminjaman_aset_id' => $peminjaman->id,
                'tanggal_kembali' => $data['tanggal_kembali'],
                'kondisi_saat_kembali' => $data['kondisi_saat_kembali'],
                'catatan' => $data['catatan'] ?? null,
                'status' => 'menunggu_verifikasi',
            ]);
        });
    }

    public function verify(PengembalianAset $pengembalian, ?int $verifiedBy = null, ?string $ditandatanganiOleh = null): PengembalianAset
    {
        return DB::transaction(function () use ($pengembalian, $verifiedBy, $ditandatanganiOleh) {
            $pengembalian = PengembalianAset::query()->lockForUpdate()->findOrFail($pengembalian->id);

            if ($pengembalian->status !== 'menunggu_verifikasi') {
                throw ValidationException::withMessages([
                    'status' => 'Pengembalian sudah diverifikasi sebelumnya.',
                ]);
            }

            $peminjaman = PeminjamanAset::query()->lockForUpdate()->findOrFail($pengembalian->peminjaman_aset_id);
            $aset = Aset::query()->lockForUpdate()->findOrFail($peminjaman->aset_id);

            $pengembalian->update([
                'status' => 'terverifikasi',
                'diverifikasi_by' => $verifiedBy,
                'diverifikasi_at' => now(),
            ]);

            $peminjaman->update(['status' => 'selesai']);
            $aset->update(['status' => 'tersedia']);

            BeritaAcara::query()->updateOrCreate(
                ['pengembalian_aset_id' => $pengembalian->id],
                [
                    'nomor_ba' => $this->generateNomorBa($pengembalian->id),
                    'isi' => $this->generateIsiBeritaAcara($pengembalian, $peminjaman, $aset),
                    'ditandatangani_oleh' => $ditandatanganiOleh,
                    'tanggal_ba' => now()->toDateString(),
                ]
            );

            return $pengembalian->fresh(['peminjaman.aset', 'beritaAcara', 'verifier']);
        });
    }

    private function generateNomorBa(int $pengembalianId): string
    {
        return sprintf('BA-%s-%04d', now()->format('YmdHis'), $pengembalianId);
    }

    private function generateIsiBeritaAcara(PengembalianAset $pengembalian, PeminjamanAset $peminjaman, Aset $aset): string
    {
        return sprintf(
            'Pada tanggal %s telah dilakukan pengembalian aset %s (%s) oleh pegawai ID %d dengan kondisi %s.',
            $pengembalian->tanggal_kembali->format('Y-m-d'),
            $aset->nama,
            $aset->kode_aset,
            $peminjaman->pegawai_id,
            $pengembalian->kondisi_saat_kembali
        );
    }
}
