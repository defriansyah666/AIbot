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
        Schema::create('stock_fg', function (Blueprint $table) {
            $table->id();
            $table->string('kode_part');
            $table->integer('qty_fg')->default(0);
            $table->timestamps();

            $table->foreign('kode_part')->references('kode_part')->on('master_data')->onDelete('cascade');
            $table->unique('kode_part');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_fg');
    }
};

