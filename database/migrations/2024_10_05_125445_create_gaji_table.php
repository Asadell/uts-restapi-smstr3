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
        Schema::create('gaji', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')->constrained(
                    table: 'karyawan', indexName: 'gaji_karyawan_id'
                )->onDelete('cascade');
            $table->string('bulan', 15);
            $table->decimal('gaji_pokok', 10, 2);
            $table->decimal('tunjangan', 10, 2);
            $table->decimal('potongan', 10, 2);
            $table->decimal('total_gaji', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gaji', function (Blueprint $table) {
            $table->dropForeign('gaji_karyawan_id');
        });
        Schema::dropIfExists('gaji');
    }
};
