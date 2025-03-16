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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();

            $table->string('employee_number', 20)->nullable()->unique(); // Auto-generated employee number
            $table->string('customer_number', 30); // Customer number
            $table->string('employee_name'); // Employee name
            $table->text('address')->nullable(); // Address (nullable)
            $table->date('date_of_birth'); // Date of birth
            $table->string('nic_number', 20)->unique(); // NIC number (unique)
            $table->string('etf_number', 20)->nullable(); // ETF number (nullable)
            $table->string('employee_type'); // Employee type
            $table->boolean('cashier')->default(false); // Cashier (default false)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
