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
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('bank_id')->constrained('banks')->onDelete('cascade');
            $table->string('bank_account_number', 50); // Bank account number
            $table->string('bank_account_name'); // Bank account name
            $table->date('balance_start_date'); // Balance start date
            $table->decimal('start_balance', 15, 2); // Start balance (cash value)
            $table->string('debit_or_credit', 10); // Debit or credit
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade');
            $table->string('basic_account', 50); // Basic account from dropdown
            $table->foreignId('account_segment_id')->constrained('account_segments')->onDelete('cascade');
            $table->foreignId('sub_account_segment_id')->constrained('sub_account_segments')->onDelete('cascade');
            $table->foreignId('ledger_id')->constrained('ledgers')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
};
