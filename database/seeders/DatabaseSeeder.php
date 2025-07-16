<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        /*User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/

        $this->call(ImportantParametersTableSeeder::class);
        $this->call(BasicAccounts::class);
        $this->call(BasicLedgerSeeds::class);
        $this->call(FuelTypesSeeder::class);
        $this->call(EmployeeTypesSeeder::class);
        $this->call(VehiclePaymentTypesSeeder::class);
        $this->call(LedgerConfigSeeder::class);
        $this->call(PaymentTypesSeeder::class);
        $this->call(RolePermissionSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(ControlAccountItemAddSeeder::class);
    }
}
