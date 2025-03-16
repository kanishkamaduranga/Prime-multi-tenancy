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
        Schema::create('account_segments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade');
            $table->string('basic_account', 50); // Basic account from dropdown
            $table->string('account_number', 50); // Account number
            $table->string('account_name'); // Account name

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_segments');
    }
};
