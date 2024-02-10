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
            $table->string('url');
            $table->string('invoice_name');
            $table->string('s_company_name');
            $table->string('s_company_address');
            $table->string('s_phone_number');
            $table->string('s_email');
            $table->string('d_company_name');
            $table->string('d_company_address');
            $table->string('d_phone_number');
            $table->string('d_email');
            $table->text('note');
            $table->integer('subtotal');
            $table->integer('discount');
            $table->integer('tax');
            $table->integer('total');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('invoice');
    }
};
