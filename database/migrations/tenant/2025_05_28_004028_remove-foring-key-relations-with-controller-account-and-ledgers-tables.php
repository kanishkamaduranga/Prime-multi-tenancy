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
        Schema::table('managers', function ($table) {
            $table->dropForeign(['control_account_id']);
        });
        Schema::table('ledgers', function ($table) {
            $table->dropForeign(['control_account_id']);
        });
        Schema::table('creditors', function ($table) {
            $table->dropForeign(['control_account_id']);
        });
        Schema::table('debtors', function ($table) {
            $table->dropForeign(['control_account_id']);
        });


        Schema::table('bank_accounts', function ($table) {
            $table->dropForeign(['ledger_id']);
        });
        Schema::table('configuration_form_ledgers', function ($table) {
            $table->dropForeign(['debit_ledger_id']);
            $table->dropForeign(['credit_ledger_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('managers', function ($table) {
            $table->foreign('control_account_id')->references('id')->on('control_accounts')->onDelete('cascade');
        });
        Schema::table('ledgers', function ($table) {
            $table->foreign('control_account_id')->references('id')->on('control_accounts')->onDelete('cascade');
        });
        Schema::table('creditors', function ($table) {
            $table->foreign('control_account_id')->references('id')->on('control_accounts')->onDelete('cascade');
        });
        Schema::table('debtors', function ($table) {
            $table->foreign('control_account_id')->references('id')->on('control_accounts')->onDelete('cascade');
        });


        Schema::table('bank_accounts', function ($table) {
            $table->foreign('ledger_id')->references('id')->on('ledgers')->onDelete('cascade');
        });
        Schema::table('configuration_form_ledgers', function ($table) {
            $table->foreign('debit_ledger_id')->references('id')->on('ledgers')->onDelete('cascade');
            $table->foreign('credit_ledger_id')->references('id')->on('ledgers')->onDelete('cascade');
        });
    }
};
