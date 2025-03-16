<?php

namespace Database\Seeders;

use App\Models\ImportantParameter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FuelTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ImportantParameter::create([
            'key' => 'fuel_types',
            'slug' => 'petrol',
            'label_si' => 'පෙට්‍රල්',
            'label_ta' => 'பெட்ரோல்',
            'label_en' => 'Petrol',
        ]);
        ImportantParameter::create([
            'key' => 'fuel_types',
            'slug' => 'diesel',
            'label_si' => 'ඩීසල්',
            'label_ta' => 'டீசல்',
            'label_en' => 'Diesel',
        ]);
        ImportantParameter::create([
            'key' => 'fuel_types',
            'slug' => 'hybrid',
            'label_si' => 'දෙමුහුන්',
            'label_ta' => 'கலப்பினம்',
            'label_en' => 'Hybrid',
        ]);
        ImportantParameter::create([
            'key' => 'fuel_types',
            'slug' => 'electric',
            'label_si' => 'විදුලි',
            'label_ta' => 'மின்சாரம்',
            'label_en' => 'Electric',
        ]);
        ImportantParameter::create([
            'key' => 'fuel_types',
            'slug' => 'hydrogen',
            'label_si' => 'හයිඩ්‍රජන්',
            'label_ta' => 'ஹைட்ரஜன்',
            'label_en' => 'Hydrogen',
        ]);
    }
}
