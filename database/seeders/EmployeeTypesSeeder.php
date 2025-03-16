<?php

namespace Database\Seeders;

use App\Models\ImportantParameter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ImportantParameter::create([
            'key' => 'employee_types',
            'slug' => 'co-op_workers',
            'label_si' => 'සමුපකාර සමිති සේවකයන්',
            'label_ta' => 'கூட்டுறவு ஊழியர்கள்',
            'label_en' => 'Co-op workers',
        ]);
        ImportantParameter::create([
            'key' => 'employee_types',
            'slug' => 'external_workers',
            'label_si' => 'භාහිර සේවකයන්',
            'label_ta' => 'வெளிப்புற தொழிலாளர்கள்',
            'label_en' => 'External workers',
        ]);
    }
}
