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
        Schema::create('pemakaian_material', function (Blueprint $table) {
            $table->id();
            $table->string('kode_part');
            $table->string('material');
            $table->integer('jumlah_pakai');
            $table->date('tanggal');
            $table->timestamps();

            $table->foreign('kode_part')->references('kode_part')->on('master_data')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemakaian_material');
    }
};

