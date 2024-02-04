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
        Schema::create('formulir_assets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('formulir_id');
            $table->integer('index');
            $table->string('path');
            $table->timestamps();
            $table->foreign('formulir_id')
            ->on('formulirs')
            ->references('id')
            ->onDelete('Cascade')->onUpdate('Cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formulir_assets');
    }
};
