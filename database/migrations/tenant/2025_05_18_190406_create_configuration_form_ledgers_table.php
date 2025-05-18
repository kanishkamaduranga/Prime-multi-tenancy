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
        Schema::create('configuration_form_ledgers', function (Blueprint $table) {
            $table->id();
            $table->string('configuration_type');
            $table->foreignId('department_id')->constrained('departments');
            $table->foreignId('debit_ledger_id')->constrained('ledgers');
            $table->foreignId('credit_ledger_id')->constrained('ledgers');
            $table->timestamps();

            // Add index for frequently queried fields
            $table->index('configuration_type');
            $table->index('department_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuration_form_ledgers');
    }
};
