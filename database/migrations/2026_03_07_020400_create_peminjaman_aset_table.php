<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjaman_aset', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aset_id')->constrained('aset');
            $table->foreignId('pegawai_id')->constrained('users');
            $table->date('tanggal_pinjam');
            $table->date('tanggal_rencana_kembali')->nullable();
            $table->text('keterangan')->nullable();
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak', 'dipinjam', 'selesai'])->default('menunggu');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamp('approved_at')->nullable();
            $table->text('alasan_penolakan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman_aset');
    }
};
