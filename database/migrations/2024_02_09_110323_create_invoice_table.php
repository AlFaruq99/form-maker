<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoice', function (Blueprint $table) {
            $table->id();
            $table->string('no_invoice');
            $table->dateTime('transaction_date');
            $table->dateTime('due_date');
            $table->string('file_path');
            $table->string('invoice_name')->nullable();
            $table->string('s_company_name')->nullable();
            $table->string('s_company_address')->nullable();
            $table->string('s_phone_number')->nullable();
            $table->string('s_email')->nullable();
            $table->unsignedBigInteger('client_id');
            $table->string('d_company_name')->nullable();
            $table->string('d_company_address')->nullable();
            $table->string('d_phone_number')->nullable();
            $table->string('d_email')->nullable();
            $table->text('note')->nullable();
            $table->integer('subtotal');
            $table->integer('discount');
            $table->integer('tax');
            $table->integer('total');
            $table->timestamps();
            $table->foreign('client_id')
            ->on('users')->references('id')->onDelete('Cascade')->onUpdate('Cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('invoice');
    }
};
