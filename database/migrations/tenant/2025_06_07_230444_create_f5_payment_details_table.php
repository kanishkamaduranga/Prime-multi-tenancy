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
        Schema::create('f5_payment_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reference_id');
            $table->string('reference_table');
            $table->text('details');
            $table->double('price', 15, 2);
            $table->foreignId('place_id')->constrained('branches');
            $table->timestamps();

            $table->index(['reference_id', 'reference_table']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('f5_payment_details');
    }
};
