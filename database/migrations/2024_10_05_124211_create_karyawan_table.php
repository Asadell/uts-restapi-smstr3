<?php

use App\Enum\KaryawanStatus;
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
        Schema::create('karyawan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap', 100);
            $table->string('email', 100)->unique();
            $table->string('password');
            $table->string('nomor_telepon', 15)->unique();
            $table->date('tanggal_lahir');
            $table->text('alamat');
            $table->date('tanggal_masuk');
            $table->foreignId('departemen_id')->constrained(
                table: 'departemen', indexName: 'karyawan_departemen_id'
            )->onDelete('cascade');
            $table->foreignId('jabatan_id')->constrained(
                table: 'jabatan', indexName: 'karyawan_jabatan_id'
            )->onDelete('cascade');
            $table->enum('status', ['aktif', 'nonaktif'])->default(KaryawanStatus::NONAKTIF->value);
            $table->rememberToken()->nullable();
            $table->timestamps();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('karyawan', function (Blueprint $table) {
            $table->dropForeign('karyawan_departemen_id');
            $table->dropForeign('karyawan_jabatan_id');
        });
        Schema::dropIfExists('karyawan');
        Schema::dropIfExists('sessions');
    }
};
