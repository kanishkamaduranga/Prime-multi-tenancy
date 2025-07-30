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
        Schema::table('f5_payment_perches_by_head_office', function (Blueprint $table) {
            $table->foreignId('approved_or_rej_by')->nullable()->constrained('users')->after('created_by');
            $table->timestamp('approved_or_rej_at')->nullable()->after('approved_or_rej_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('f5_payment_perches_by_head_office', function (Blueprint $table) {
            $table->dropForeign(['approved_or_rej_by']);
            $table->dropColumn(['approved_or_rej_by', 'approved_or_rej_at']);
        });
    }
};
