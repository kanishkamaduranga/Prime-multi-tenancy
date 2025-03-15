<?php

namespace Database\Seeders;

use App\Models\ImportantParameter;
use Illuminate\Database\Seeder;

class BasicAccounts extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ImportantParameter::create([
            'key' => 'basic_accounts',
            'slug' => 'other',
            'label_si' => 'වෙනත්',
            'label_ta' => 'மற்றவை',
            'label_en' => 'Other',
        ]);
        ImportantParameter::create([
            'key' => 'basic_accounts',
            'slug' => 'stock',
            'label_si' => 'ස්කන්ධය',
            'label_ta' => 'பங்கு',
            'label_en' => 'Stock',
        ]);
        ImportantParameter::create([
            'key' => 'basic_accounts',
            'slug' => 'revenue',
            'label_si' => 'ආදායම්',
            'label_ta' => 'வருவாய்',
            'label_en' => 'Revenue',
        ]);
        ImportantParameter::create([
            'key' => 'basic_accounts',
            'slug' => 'capital',
            'label_si' => 'ප්‍රාග්ධනය',
            'label_ta' => 'மூலதனம்',
            'label_en' => 'Capital',
        ]);
        ImportantParameter::create([
            'key' => 'basic_accounts',
            'slug' => 'assets',
            'label_si' => 'වත්කම්',
            'label_ta' => 'சொத்துக்கள்',
            'label_en' => 'Assets',
        ]);
        ImportantParameter::create([
            'key' => 'basic_accounts',
            'slug' => 'control_accounts',
            'label_si' => 'පාලන ගිණුම්',
            'label_ta' => 'கணக்குகளைக் கட்டுப்படுத்து',
            'label_en' => 'Control Accounts',
        ]);
    }
}
