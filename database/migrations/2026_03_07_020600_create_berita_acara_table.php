<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berita_acara', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengembalian_aset_id')->constrained('pengembalian_aset');
            $table->string('nomor_ba')->unique();
            $table->longText('isi');
            $table->string('file_path')->nullable();
            $table->string('ditandatangani_oleh')->nullable();
            $table->date('tanggal_ba');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berita_acara');
    }
};
