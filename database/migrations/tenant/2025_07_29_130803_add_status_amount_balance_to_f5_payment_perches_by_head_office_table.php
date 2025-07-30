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
            $table->string('status', 20)->default('pending')->after('id');
            $table->double('total_amount')->nullable()->after('bank_account_id');
            $table->double('existing_account_balance')->nullable()->after('total_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('f5_payment_perches_by_head_office', function (Blueprint $table) {
            $table->dropColumn(['status', 'total_amount', 'existing_account_balance']);
        });
    }
};
