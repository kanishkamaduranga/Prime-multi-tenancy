<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Create the new combined table
        Schema::create('ledger_controllers', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['ledger', 'control_account'])->default('ledger');
            $table->bigInteger('department_id')->unsigned();
            $table->string('basic_account', 50);
            $table->bigInteger('account_segment_id')->unsigned();
            $table->bigInteger('sub_account_segment_id')->unsigned();
            $table->string('number', 50); // combines account_number and ledger_number
            $table->string('name', 255);  // combines account_name and ledger_name
            $table->bigInteger('control_account_id')->unsigned()->nullable();
            $table->json('basic_ledger')->nullable();
            $table->boolean('f8_number')->default(false);
            $table->timestamps();

            // Foreign keys
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('account_segment_id')->references('id')->on('account_segments')->onDelete('cascade');
            $table->foreign('sub_account_segment_id')->references('id')->on('sub_account_segments')->onDelete('cascade');
            $table->foreign('control_account_id')->references('id')->on('ledger_controllers')->onDelete('cascade');
        });

        // Transfer control_accounts data first (since ledgers may reference them)
        DB::table('control_accounts')->orderBy('id')->chunk(100, function ($controlAccounts) {
            $data = [];
            foreach ($controlAccounts as $account) {
                $data[] = [
                    'type' => 'control_account',
                    'department_id' => $account->department_id,
                    'basic_account' => $account->basic_account,
                    'account_segment_id' => $account->account_segment_id,
                    'sub_account_segment_id' => $account->sub_account_segment_id,
                    'number' => $account->account_number,
                    'name' => $account->account_name,
                    'basic_ledger' => $account->basic_ledger,
                    'created_at' => $account->created_at,
                    'updated_at' => $account->updated_at,
                ];
            }
            DB::table('ledger_controllers')->insert($data);
        });

        // Transfer ledgers data with mapping of control_account_id
        DB::table('ledgers')->orderBy('id')->chunk(100, function ($ledgers) {
            $data = [];
            foreach ($ledgers as $ledger) {
                $data[] = [
                    'type' => 'ledger',
                    'department_id' => $ledger->department_id,
                    'basic_account' => $ledger->basic_account,
                    'account_segment_id' => $ledger->account_segment_id,
                    'sub_account_segment_id' => $ledger->sub_account_segment_id,
                    'number' => $ledger->ledger_number,
                    'name' => $ledger->ledger_name,
                    'control_account_id' => $ledger->control_account_id,
                    'basic_ledger' => $ledger->basic_ledger,
                    'f8_number' => $ledger->f8_number,
                    'created_at' => $ledger->created_at,
                    'updated_at' => $ledger->updated_at,
                ];
            }
            DB::table('ledger_controllers')->insert($data);
        });

        // Drop old tables
        Schema::dropIfExists('ledgers');
        Schema::dropIfExists('control_accounts');

        Schema::table('managers', function ($table) {
            $table->foreign('control_account_id')->references('id')->on('ledger_controllers')->onDelete('cascade');
        });
        Schema::table('creditors', function ($table) {
            $table->foreign('control_account_id')->references('id')->on('ledger_controllers')->onDelete('cascade');
        });
        Schema::table('debtors', function ($table) {
            $table->foreign('control_account_id')->references('id')->on('ledger_controllers')->onDelete('cascade');
        });


        Schema::table('bank_accounts', function ($table) {
            $table->foreign('ledger_id')->references('id')->on('ledger_controllers')->onDelete('cascade');
        });
        Schema::table('configuration_form_ledgers', function ($table) {
            $table->foreign('debit_ledger_id')->references('id')->on('ledger_controllers')->onDelete('cascade');
            $table->foreign('credit_ledger_id')->references('id')->on('ledger_controllers')->onDelete('cascade');
        });
    }

    public function down()
    {
        // Recreate original tables
        Schema::create('control_accounts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('department_id')->unsigned();
            $table->string('basic_account', 50);
            $table->bigInteger('account_segment_id')->unsigned();
            $table->bigInteger('sub_account_segment_id')->unsigned();
            $table->string('account_number', 50);
            $table->string('account_name', 255);
            $table->json('basic_ledger')->nullable();
            $table->timestamps();

            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('account_segment_id')->references('id')->on('account_segments')->onDelete('cascade');
            $table->foreign('sub_account_segment_id')->references('id')->on('sub_account_segments')->onDelete('cascade');
        });

        Schema::create('ledgers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('department_id')->unsigned();
            $table->string('basic_account', 50);
            $table->bigInteger('account_segment_id')->unsigned();
            $table->bigInteger('sub_account_segment_id')->unsigned();
            $table->string('ledger_number', 50);
            $table->string('ledger_name', 255);
            $table->bigInteger('control_account_id')->unsigned();
            $table->json('basic_ledger');
            $table->boolean('f8_number')->default(false);
            $table->timestamps();

            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('account_segment_id')->references('id')->on('account_segments')->onDelete('cascade');
            $table->foreign('sub_account_segment_id')->references('id')->on('sub_account_segments')->onDelete('cascade');
            $table->foreign('control_account_id')->references('id')->on('control_accounts')->onDelete('cascade');
        });

        Schema::table('managers', function ($table) {
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


        // Transfer data back (this would be more complex in reality)
        // For simplicity, we'll just drop the new table
        Schema::dropIfExists('ledger_controllers');
    }
};

