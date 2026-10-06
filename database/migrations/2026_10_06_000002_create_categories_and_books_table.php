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
        if (!Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $table) {
                $table->id();
                $table->string('nama');
                $table->string('slug')->unique();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('books')) {
            Schema::create('books', function (Blueprint $table) {
                $table->id();
                $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
                $table->string('judul');
                $table->string('pengarang');
                $table->string('penerbit')->nullable();
                $table->string('tahun_terbit')->nullable();
                $table->string('isbn')->nullable();
                $table->integer('stok')->default(0);
                $table->string('lokasi_rak')->nullable();
                $table->string('sampul')->nullable();
                $table->text('sinopsis')->nullable();
                $table->integer('jumlah_halaman')->nullable();
                $table->timestamps();
            });
        } else {
            Schema::table('books', function (Blueprint $table) {
                if (!Schema::hasColumn('books', 'category_id')) {
                    $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
                }
                if (!Schema::hasColumn('books', 'isbn')) {
                    $table->string('isbn')->nullable();
                }
                if (!Schema::hasColumn('books', 'stok')) {
                    $table->integer('stok')->default(0);
                }
                if (!Schema::hasColumn('books', 'sampul')) {
                    $table->string('sampul')->nullable();
                }
                if (!Schema::hasColumn('books', 'sinopsis')) {
                    $table->text('sinopsis')->nullable();
                }
                if (!Schema::hasColumn('books', 'jumlah_halaman')) {
                    $table->integer('jumlah_halaman')->nullable();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
        Schema::dropIfExists('categories');
    }
};
