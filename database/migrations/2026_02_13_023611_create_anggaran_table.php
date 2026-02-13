<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anggaran', function (Blueprint $table) {
            $table->string('id_anggaran', 50)->primary();
            $table->decimal('anggaran', 15, 2);
            $table->year('tahun');
            $table->decimal('sum_total', 15, 2)->default(0);
            $table->decimal('sisa_anggaran', 15, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->unique('tahun');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggaran');
    }
};
