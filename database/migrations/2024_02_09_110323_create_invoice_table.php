<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->string('no_invoice');
            $table->string('status');
            $table->dateTime('transaction_date');
            $table->dateTime('due_date');
            $table->string('file_path');
            $table->string('s_company_name')->nullable();
            $table->string('s_company_address')->nullable();
            $table->string('s_phone_number')->nullable();
            $table->string('s_email')->nullable();
            $table->string('d_company_name')->nullable();
            $table->string('d_company_address')->nullable();
            $table->string('d_phone_number')->nullable();
            $table->string('d_email')->nullable();
            $table->text('note')->nullable();
            $table->decimal('subtotal',16,2)->default(0);
            $table->decimal('discount',16,2)->default(0);
            $table->decimal('tax',16,2)->default(0);
            $table->decimal('total',16,2)->default(0);
            $table->timestamps();
            $table->foreign('client_id')
            ->on('users')->references('id')->onDelete('Cascade')->onUpdate('Cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
