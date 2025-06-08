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
        Schema::create('f5_payment_perches_by_head_office', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_number')->unique();
            $table->string('cooppen_number')->nullable();
            $table->foreignId('department_id')->constrained('departments');
            $table->foreignId('supplier_id')->constrained('creditors');
            $table->foreignId('bank_account_id')->constrained('bank_accounts');
            $table->string('cheque_receiver');
            $table->text('summary')->nullable();
            $table->string('payment_type');
            $table->string('payment_analysis')->default('payment');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('f5_payment_purchases_by_head_office');
    }
};
