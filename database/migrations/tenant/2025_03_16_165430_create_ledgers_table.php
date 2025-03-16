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
        Schema::create('ledgers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade');
            $table->string('basic_account', 50); // Basic account from dropdown
            $table->foreignId('account_segment_id')->constrained('account_segments')->onDelete('cascade');
            $table->foreignId('sub_account_segment_id')->constrained('sub_account_segments')->onDelete('cascade');
            $table->string('ledger_number', 50); // Ledger number
            $table->string('ledger_name'); // Ledger name
            $table->foreignId('control_account_id')->constrained('control_accounts')->onDelete('cascade');
            $table->json('basic_ledger'); // Store selected basic ledger options as JSON
            $table->boolean('f8_number')->default(false); // F8 number (boolean)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ledgers');
    }
};
