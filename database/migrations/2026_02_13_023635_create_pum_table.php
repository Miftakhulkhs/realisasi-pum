<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pum', function (Blueprint $table) {
            $table->string('id_pum', 50)->primary();
            $table->string('nopum', 50)->unique();
            $table->string('nama_kegiatan', 200);
            $table->enum('jenis', ['PUM', 'SPP']);
            $table->decimal('total_pum_spp', 15, 2);
            $table->decimal('realisasi', 15, 2)->default(0);
            $table->decimal('total_biaya', 15, 2);
            $table->date('tanggal_pum');
            $table->date('tanggal_lpj')->nullable();
            $table->string('id_anggaran', 50);
            $table->string('id_user', 50);
            $table->timestamps();
            
            $table->foreign('id_anggaran')->references('id_anggaran')->on('anggaran')->onDelete('restrict');
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pum');
    }
};
