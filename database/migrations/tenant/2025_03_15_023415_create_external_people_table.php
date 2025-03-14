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
        Schema::create('external_people', function (Blueprint $table) {
            $table->id();

            $table->string('number', 50)->unique(); // Unique identifier for external people
            $table->string('customer_number', 30)->nullable(); // Optional customer number
            $table->string('name');
            $table->text('address')->nullable(); // Optional address
            $table->string('nic_number', 12); // NIC number (12 digits or 9 digits + 'V' or 'X')
            $table->string('telephone_number', 10); // Telephone number (10 digits starting with 0)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('external_people');
    }
};
