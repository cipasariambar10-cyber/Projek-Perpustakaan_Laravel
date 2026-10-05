<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel buku (milik Nasya). Kolom `sampul` boleh kosong (tanpa upload foto).
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->restrictOnDelete();
            $table->string('judul');
            $table->string('pengarang');
            $table->string('penerbit');
            $table->unsignedSmallInteger('tahun_terbit');
            $table->string('isbn', 20)->nullable()->unique();
            $table->unsignedInteger('stok')->default(0);
            $table->string('lokasi_rak', 50)->nullable();
            $table->string('sampul')->nullable();
            $table->text('sinopsis')->nullable();
            $table->timestamps();

            $table->index('judul');
            $table->index('pengarang');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
