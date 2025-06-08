<?php

namespace Database\Seeders;

use App\Models\ImportantParameter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ImportantParameter::create([
            'key' => 'payment_types',
            'slug' => 'cash',
            'label_si' => 'මුදල්',
            'label_ta' => 'Cash',
            'label_en' => 'Cash',
        ]);
        ImportantParameter::create([
            'key' => 'payment_types',
            'slug' => 'cheque',
            'label_si' => 'චෙක්පත',
            'label_ta' => 'Cheque',
            'label_en' => 'Cheque',
        ]);
    }
}
