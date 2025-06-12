<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi');
            $table->enum('kategori', ['Pendidikan', 'Kesehatan', 'Bencana', 'Sosial']);
            $table->decimal('target_donasi', 15, 2);
            $table->decimal('total_terkumpul', 15, 2)->default(0);
            $table->datetime('tanggal_berakhir');
            $table->string('gambar')->nullable();
            $table->enum('status', ['aktif', 'selesai'])->default('aktif');
            $table->text('laporan_html')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
