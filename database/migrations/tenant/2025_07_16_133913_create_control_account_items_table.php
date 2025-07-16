<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('control_account_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ledger_control_account_id')->constrained('ledger_controllers');
            $table->string('item_type');
            $table->string('item_number');
            $table->text('note')->nullable();
            $table->timestamps();
        });

        DB::statement('
            ALTER TABLE important_parameters
            DROP INDEX important_parameters_slug_unique,
            ADD UNIQUE INDEX important_parameters_slug_key_unique (slug, `key`)
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('control_account_items');

        DB::statement('
            ALTER TABLE important_parameters
            DROP INDEX important_parameters_slug_key_unique,
            ADD UNIQUE INDEX important_parameters_slug_unique (slug)
        ');
    }
};
