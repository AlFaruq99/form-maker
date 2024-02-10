<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoice_assets', function (Blueprint $table) {
            $table->id();
            $table->string('no_invoice');
            $table->text('description');
            $table->integer('qty');
            $table->string('unit');
            $table->integer('price');
            $table->decimal('discount');
            $table->decimal('tax');
            $table->integer('total');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('invoice_assets');
    }
};
