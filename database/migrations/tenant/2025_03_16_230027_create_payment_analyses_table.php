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
        Schema::create('payment_analyses', function (Blueprint $table) {
            $table->id();

            $table->string('analysis_number', 20); // Analysis number field
            $table->string('payment_analysis');   // Payment Analysis field

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_analyses');
    }
};
