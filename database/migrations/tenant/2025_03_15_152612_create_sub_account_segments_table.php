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
        Schema::create('sub_account_segments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade');
            $table->string('basic_account', 50); // Basic account from dropdown
            $table->foreignId('account_segment_id')->constrained('account_segments')->onDelete('cascade');
            $table->string('sub_account_number', 50); // Sub-account number
            $table->string('sub_account_name'); // Sub-account name

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_account_segments');
    }
};
