<?php

namespace Database\Seeders;

use App\Models\ImportantParameter;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class ControlAccountItemAddSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            "Control_Account_Item_view",
            "Control_Account_Item_view_create",
            "Control_Account_Item_view_edit",
            "Control_Account_Item_view_delete",

        ];

        foreach ($permissions as $permission) {
                Permission::firstOrCreate([
                    'name' => $permission,
                    'guard_name' => 'web'
                ]);
        }


        ImportantParameter::firstOrCreate([
            'key' => 'items_for_control_accounts',
            'slug' => 'manager',
            'label_si' => 'කළමනාකරු',
            'label_ta' => 'மேலாளர்',
            'label_en' => 'Manager',
        ]);
        ImportantParameter::firstOrCreate([
            'key' => 'items_for_control_accounts',
            'slug' => 'debitors',
            'label_si' => 'ණයගැතියන්',
            'label_ta' => 'பற்றுதாரர்கள்',
            'label_en' => 'Debitors',
        ]);
        ImportantParameter::firstOrCreate([
            'key' => 'items_for_control_accounts',
            'slug' => 'creditors',
            'label_si' => 'ණයහිමියන්',
            'label_ta' => 'கடன் வழங்குபவர்கள்',
            'label_en' => 'Creditors',
        ]);
        ImportantParameter::firstOrCreate([
            'key' => 'items_for_control_accounts',
            'slug' => 'employees',
            'label_si' => 'සේවකයින්',
            'label_ta' => 'ஊழியர்கள்',
            'label_en' => 'Employees',
        ]);
        ImportantParameter::firstOrCreate([
            'key' => 'items_for_control_accounts',
            'slug' => 'external_persons',
            'label_si' => 'බාහිර පුද්ගලයින්',
            'label_ta' => 'வெளி நபர்கள்',
            'label_en' => 'External Persons',
        ]);
        ImportantParameter::firstOrCreate([
            'key' => 'items_for_control_accounts',
            'slug' => 'other',
            'label_si' => 'වෙනත්',
            'label_ta' => 'மற்றவை',
            'label_en' => 'Other',
        ]);


    }
}
