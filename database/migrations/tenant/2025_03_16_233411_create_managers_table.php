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
        Schema::create('managers', function (Blueprint $table) {
            $table->id();
            $table->string('manager_number', 20)->nullable()->unique(); // Auto-generated 4-digit number
            $table->string('manager_name'); // Manager name
            $table->foreignId('control_account_id')->constrained('control_accounts'); // FK to control_accounts
            $table->foreignId('department_id')->constrained('departments'); // FK to departments
            $table->foreignId('branch_type_id')->constrained('branch_types'); // FK to branch_types
            $table->timestamps(); // Created at and Updated at timestamps
        });

        // Pivot table for many-to-many relationship between managers and branches
        Schema::create('branch_manager', function (Blueprint $table) {
            $table->id();
            $table->foreignId('manager_id')->constrained()->onDelete('cascade');
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branch_manager'); // Drop pivot table first
        Schema::dropIfExists('managers'); // Drop managers table
    }
};
