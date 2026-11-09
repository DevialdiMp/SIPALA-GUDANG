<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();

            $table->foreignId('teknisi_id')
                ->constrained('teknisi')
                ->restrictOnDelete();
            $table->foreignId('alat_id')
                ->constrained('alat')
                ->restrictOnDelete();
            $table->dateTime('waktu_pinjam');
            $table->enum('kondisi_pinjam', ['baik', 'rusak','perlu_perhatian'])
                ->default('baik');
            $table->dateTime('waktu_kembali')->nullable();
            $table->enum('kondisi_kembali', ['baik', 'rusak','perlu_perhatian'])
                ->nullable();
            $table->text('catatan')->nullable();
            $table->enum('status', ['dipinjam', 'dikembalikan'])
                ->default('dipinjam');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
