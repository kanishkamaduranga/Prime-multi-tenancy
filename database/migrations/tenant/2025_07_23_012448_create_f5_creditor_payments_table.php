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
        Schema::create('f5_creditor_payments', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_number', 50)->unique();
            $table->string('coupon_number', 50)->nullable();
            $table->foreignId('department_id')->constrained('departments');
            $table->foreignId('supplier_id')->constrained('creditors');
            $table->date('date_of_paid');
            $table->foreignId('bank_account_id')->constrained('bank_accounts');
            $table->string('cheque_receiver', 200);
            $table->text('note')->nullable();
            $table->double('total_amount');
            $table->json('payment_details')->nullable();
            $table->string('payment_type', 20);
            $table->foreignId('payment_created_by')->constrained('users');
            $table->string('status', 20)->default('pending');
            $table->text('note_approved_or_rejected')->nullable();
            $table->foreignId('approved_or_rejected_by')->nullable()->constrained('users');
            $table->timestamp('approved_or_rejected_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('f5_creditor_payments');
    }
};
