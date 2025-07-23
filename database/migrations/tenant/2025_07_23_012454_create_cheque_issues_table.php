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
        Schema::create('cheque_issues', function (Blueprint $table) {
            $table->id();
            $table->string('reference_table');
            $table->foreignId('reference_id');
            $table->string('cheque_number', 100);
            $table->text('note_cheque_number_issue')->nullable();
            $table->foreignId('cheque_number_issue_by')->constrained('users');
            $table->timestamp('check_number_issued_time');
            $table->boolean('cooperative_stamp')->default(false);
            $table->string('valid_date', 50);
            $table->string('permissions', 50);
            $table->json('need_to_signature');
            $table->foreignId('cheque_issue_by')->constrained('users');
            $table->timestamp('cheque_issue_time');
            $table->integer('cheque_printed_time')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cheque_issues');
    }
};
