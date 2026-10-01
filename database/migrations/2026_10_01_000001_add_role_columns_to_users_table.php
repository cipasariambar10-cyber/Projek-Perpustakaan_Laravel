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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'anggota'])->default('anggota')->after('name');
            $table->string('nis_nip', 30)->nullable()->after('role');
            $table->string('kelas', 20)->nullable()->after('nis_nip');
            $table->string('no_hp', 20)->nullable()->after('kelas');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif')->after('no_hp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'nis_nip', 'kelas', 'no_hp', 'status']);
        });
    }
};
