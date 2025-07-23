<?php

namespace Database\Seeders;

use App\Models\ImportantParameter;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class F5CreditorsSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            "f5_creaditor-payments_create",
            "f5_creaditor-payments_approve",
            "f5_creaditor-payments_cheque_number_issue",
            "f5_creaditor-payments_cheque_issue",
            "f5_creaditor-payments_cheque_print",
        ];

        foreach ($permissions as $permission) {

                Permission::firstOrCreate([
                    'name' => $permission ,
                    'guard_name' => 'web'
                ]);
        }
        /*****************************************************************/
        ImportantParameter::create([
            'key' => 'cheques_valid_dates',
            'slug' => '30_days_valid',
            'label_si' => 'දින 30ක් පමණක් වලංගුවේ',
            'label_ta' => '30 நாட்களுக்கு மட்டுமே செல்லுபடியாகும்.',
            'label_en' => 'Valid for 30 days only',
        ]);
        ImportantParameter::create([
            'key' => 'cheques_valid_dates',
            'slug' => '45_days_valid',
            'label_si' => 'දින 45ක් පමණක් වලංගුවේ',
            'label_ta' => '45 நாட்களுக்கு மட்டுமே செல்லுபடியாகும்.',
            'label_en' => 'Valid for 45 days only',
        ]);
        ImportantParameter::create([
            'key' => 'cheques_valid_dates',
            'slug' => '60_days_valid',
            'label_si' => 'දින 60ක් පමණක් වලංගුවේ',
            'label_ta' => '60 நாட்களுக்கு மட்டுமே செல்லுபடியாகும்.',
            'label_en' => 'Valid for 60 days only',
        ]);
        ImportantParameter::create([
            'key' => 'cheques_valid_dates',
            'slug' => '90_days_valid',
            'label_si' => 'දින 90ක් පමණක් වලංගුවේ',
            'label_ta' => '90 நாட்களுக்கு மட்டுமே செல்லுபடியாகும்.',
            'label_en' => 'Valid for 90 days only',
        ]);

/*****************************************************************************/

        ImportantParameter::create([
            'key' => 'cheques_permissions',
            'slug' => 'only_subscriber_account',
            'label_si' => 'දායකයාගේ ගිණුමට පමණි',
            'label_ta' =>  'சந்தாதாரரின் கணக்கிற்கு மட்டும்',
            'label_en' => 'Only to the subscriber\'s account',
        ]);
        ImportantParameter::create([
            'key' => 'cheques_permissions',
            'slug' => 'transactions_not_possible.',
            'label_si' => 'ගනුදෙනු කළ නොහැක',
            'label_ta' =>  'பரிவர்த்தனைகள் சாத்தியமில்லை',
            'label_en' => 'Transactions are not possible',
        ]);

        /**************************************************************************/

        ImportantParameter::create([
            'key' => 'cheques_signatures',
            'slug' => 'president',
            'label_si' => 'සභාපති',
            'label_ta' => 'தலைவர்',
            'label_en' => 'President',
        ]);
        ImportantParameter::create([
            'key' => 'cheques_signatures',
            'slug' => 'vice_president',
            'label_si' => 'උප සභාපති',
            'label_ta' => 'துணைத் தலைவர்',
            'label_en' => 'Vice President',
        ]);
        ImportantParameter::create([
            'key' => 'cheques_signatures',
            'slug' => 'general_manager',
            'label_si' => 'සාමාන්‍යාධිකාරී',
            'label_ta' => 'பொது மேலாளர்',
            'label_en' => 'General Manager',
        ]);
        ImportantParameter::create([
            'key' => 'cheques_signatures',
            'slug' => 'accountant',
            'label_si' => 'ගණකාධිකාරී',
            'label_ta' => 'கணக்காளர்',
            'label_en' => 'Accountant',
        ]);
        ImportantParameter::create([
            'key' => 'cheques_signatures',
            'slug' => 'hr',
            'label_si' => 'මානව සම්පත් කළමනාකරු',
            'label_ta' => 'மனிதவள மேலாளர்',
            'label_en' => 'Human Resources Manager',
        ]);
        ImportantParameter::create([
            'key' => 'cheques_signatures',
            'slug' => 'secretary',
            'label_si' => 'ලේකම්',
            'label_ta' => 'செயலாளர்',
            'label_en' => 'Secretary',
        ]);
        ImportantParameter::create([
            'key' => 'cheques_signatures',
            'slug' => 'commercial_resource_manager',
            'label_si' => 'වාණිජ සම්පත් කළමනාකරු ',
            'label_ta' => 'வணிக வள மேலாளர்',
            'label_en' => 'Commercial Resource Manager',
        ]);
        ImportantParameter::create([
            'key' => 'cheques_signatures',
            'slug' => 'bank_service_manager',
            'label_si' => 'බැංකු සේවා කළමනාකරු ',
            'label_ta' => 'வங்கி சேவைகள் மேலாளர்',
            'label_en' => 'Banking Services Manager',
        ]);

    }
}
