<?php

namespace Database\Seeders;

use App\Models\ImportantParameter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BasicLedgerSeeds extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ImportantParameter::create([
            'key' => 'basic_ledger',
            'slug' => 'cash_book_ledger',
            'label_si' => 'මුදල් පොත ලෙජරය',
            'label_ta' => 'ரொக்கப் புத்தகப் பேரேடு',
            'label_en' => 'Cash book ledger',
        ]);

        ImportantParameter::create([
            'key' => 'basic_ledger',
            'slug' => 'stock_ledger',
            'label_si' => 'කොටස් ලෙජරය',
            'label_ta' => 'பங்குப் பேரேடு',
            'label_en' => 'Stock Ledger',
        ]);

        ImportantParameter::create([
            'key' => 'basic_ledger',
            'slug' => 'general_ledger_account',
            'label_si' => 'පොදු ලේජර ගිණුම',
            'label_ta' => 'பொதுப் பேரேடு கணக்கு',
            'label_en' => 'General Ledger Account',
        ]);

        ImportantParameter::create([
            'key' => 'basic_ledger',
            'slug' => 'gl_ledger',
            'label_si' => 'GL ලෙජරය',
            'label_ta' => 'GL பேரேடு',
            'label_en' => 'GL Ledger',
        ]);
    }
}
