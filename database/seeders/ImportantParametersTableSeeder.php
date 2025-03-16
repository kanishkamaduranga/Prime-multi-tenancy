<?php

namespace Database\Seeders;

use App\Models\ImportantParameter;
use Illuminate\Database\Seeder;

///use Stancl\Tenancy\Database\Models\Tenant;

class ImportantParametersTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       /* $tenants = Tenant::all();
        $tenants->each(function ($tenant) {
            tenancy()->initialize($tenant);*/
            ImportantParameter::create([
                'key' => 'key1',
                'slug' => 'slug1',
                'label_si' => 'සිංහල ලේබල් 1',
                'label_ta' => 'தமிழ் லேபல் 1',
                'label_en' => 'English Label 1',
            ]);

            ImportantParameter::create([
                'key' => 'key2',
                'slug' => 'slug2',
                'label_si' => 'සිංහල ලේබල් 2',
                'label_ta' => 'தமிழ் லேபல் 2',
                'label_en' => 'English Label 2',
            ]);

            ImportantParameter::create([
                'key' => 'key2',
                'slug' => 'slug22',
                'label_si' => 'සිංහල ලේබල් 22',
                'label_ta' => 'தமிழ் லேபல் 22',
                'label_en' => 'English Label 22',
            ]);
           /* tenancy()->end();
        });*/
    }
}
