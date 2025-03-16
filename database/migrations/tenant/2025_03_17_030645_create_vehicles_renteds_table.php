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
        Schema::create('vehicles_renteds', function (Blueprint $table) {
            $table->id();

            $table->year('year')->default(date('Y')); // Default to current year
            $table->string('month')->default(date('F')); // Default to current month
            $table->string('vehicle_number', 20); // Vehicle number
            $table->string('payment_method', 20); // Payment method
            $table->decimal('price', 10, 2); // Price

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles_renteds');
    }
};
