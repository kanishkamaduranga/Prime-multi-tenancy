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
        Schema::create('control_accounts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade');
            $table->string('basic_account', 50); // Basic account from dropdown
            $table->foreignId('account_segment_id')->constrained('account_segments')->onDelete('cascade');
            $table->foreignId('sub_account_segment_id')->constrained('sub_account_segments')->onDelete('cascade');
            $table->string('account_number', 50); // Account number
            $table->string('account_name'); // Account name
            $table->json('basic_ledger')->nullable(); // Store selected basic ledger options

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('control_accounts');
    }
};
