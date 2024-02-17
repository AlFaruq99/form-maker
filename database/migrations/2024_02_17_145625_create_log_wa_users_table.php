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
        Schema::create('log_wa_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('summary_id');
            $table->string('dest_num');
            $table->boolean('broadcast')->default('false');
            $table->string('message')->nullable();
            $table->integer('status')->nullable();
            $table->string('tipe')->nullable();
            $table->timestamp('tgl_dikirim')->nullable();
            $table->timestamps();
            $table->foreign('summary_id')->on('log_wa_summaries')
            ->references('id')->onDelete('Cascade')->onUpdate('Cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_wa_users');
    }
};
