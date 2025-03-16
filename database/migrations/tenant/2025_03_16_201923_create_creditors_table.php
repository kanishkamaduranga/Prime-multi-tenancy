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
        Schema::create('creditors', function (Blueprint $table) {
            $table->id();

            $table->string('creditors_number', 12)->unique(); // Auto-generated creditors number
            $table->string('customer_number', 20); // Customer number
            $table->string('creditor_name'); // Creditor name
            $table->text('address')->nullable(); // Address (optional)
            $table->string('telephone_number', 20); // Telephone number
            $table->foreignId('control_account_id')->constrained('control_accounts')->onDelete('cascade'); // Control account FK
            $table->decimal('price', 15, 2); // Price
            $table->integer('year'); // Year
            $table->integer('month'); // Month

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('creditors');
    }
};
