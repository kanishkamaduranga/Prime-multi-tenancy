<?php

namespace Database\Seeders;

use App\Models\ImportantParameter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehiclePaymentTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ImportantParameter::create([
            'key' => 'vehicle_payment_types',
            'slug' => 'km',
            'label_si' => 'KM',
            'label_ta' => 'KM',
            'label_en' => 'KM',
        ]);
        ImportantParameter::create([
            'key' => 'vehicle_payment_types',
            'slug' => 'monthly',
            'label_si' => 'මාසිකව',
            'label_ta' => 'மாதாந்திர',
            'label_en' => 'Monthly',
        ]);
        ImportantParameter::create([
            'key' => 'vehicle_payment_types',
            'slug' => 'package_with_driver',
            'label_si' => 'රියදුරු සහිත පැකේජය',
            'label_ta' => 'டிரைவருடன் தொகுப்பு',
            'label_en' => 'Package with driver',
        ]);
        ImportantParameter::create([
            'key' => 'vehicle_payment_types',
            'slug' => 'package_without_driver',
            'label_si' => 'රියදුරු නොමැති පැකේජය',
            'label_ta' => 'டிரைவர் இல்லாத தொகுப்பு',
            'label_en' => 'Package without driver',
        ]);
    }
}
