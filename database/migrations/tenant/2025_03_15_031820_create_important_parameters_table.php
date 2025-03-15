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
        Schema::create('important_parameters', function (Blueprint $table) {
            $table->id();

            $table->string('key', 50);
            $table->string('slug', 100)->unique();
            $table->string('label_si');
            $table->string('label_ta');
            $table->string('label_en');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('important_parameters');
    }
};
