<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengembalian_aset', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peminjaman_aset_id')->constrained('peminjaman_aset');
            $table->date('tanggal_kembali');
            $table->enum('kondisi_saat_kembali', ['baik', 'rusak_ringan', 'rusak_berat'])->default('baik');
            $table->text('catatan')->nullable();
            $table->enum('status', ['menunggu_verifikasi', 'terverifikasi'])->default('menunggu_verifikasi');
            $table->foreignId('diverifikasi_by')->nullable()->constrained('users');
            $table->timestamp('diverifikasi_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengembalian_aset');
    }
};
