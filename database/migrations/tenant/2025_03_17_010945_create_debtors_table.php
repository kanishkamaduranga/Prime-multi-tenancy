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
        Schema::create('debtors', function (Blueprint $table) {
            $table->id();

            $table->string('debtor_number', 20)->nullable()->unique(); // Auto-generated debtor number
            $table->string('customer_number', 20); // Customer number
            $table->string('debtor_name'); // Debtor name
            $table->text('address')->nullable(); // Address (nullable)
            $table->string('telephone_number')->nullable(); // Telephone number (nullable)
            $table->foreignId('control_account_id')->constrained('control_accounts'); // FK to control_accounts
            $table->decimal('saved_amount', 10, 2)->default(0); // Saved amount (price)
            $table->date('date'); // Date

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('debtors');
    }
};
