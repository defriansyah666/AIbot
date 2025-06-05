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
        Schema::create('delivery_data_input', function (Blueprint $table) {
            $table->id();
            $table->string('kode_part');
            $table->integer('qty_delivery');
            $table->date('tanggal_delivery');
            $table->string('customer');
            $table->foreignId('operator_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->foreign('kode_part')->references('kode_part')->on('master_data')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_data_input');
    }
};

