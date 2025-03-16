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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('department_id')->constrained('departments'); // FK to departments table
            $table->string('vehicle_number', 30)->unique(); // Vehicle number (unique)
            $table->string('fuel_quality_level', 10)->nullable(); // Fuel quality level (nullable)
            $table->string('fuel_type', 20); // Fuel type

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
