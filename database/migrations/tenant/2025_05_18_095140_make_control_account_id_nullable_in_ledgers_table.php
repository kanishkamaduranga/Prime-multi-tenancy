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
        DB::statement('ALTER TABLE ledgers MODIFY control_account_id BIGINT UNSIGNED NULL');
        DB::statement('ALTER TABLE ledgers ADD CONSTRAINT ledgers_control_account_id_foreign FOREIGN KEY (control_account_id) REFERENCES control_accounts(id) ON DELETE CASCADE');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
