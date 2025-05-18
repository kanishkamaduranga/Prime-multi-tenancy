<?php

namespace Database\Seeders;

use App\Models\ImportantParameter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class LedgerConfigSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = database_path('seeders/configl.csv');

        if (!File::exists($csvFile)) {
            $this->command->error("CSV file not found: {$csvFile}");
            return;
        }

        // Read CSV file
        $csvData = array_map('str_getcsv', file($csvFile));

        // Remove header if exists
        $header = array_shift($csvData);

        foreach ($csvData as $row) {

            $en = preg_replace('/(?<!\ )[A-Z]/', ' $0', (str_replace("frm", "", $row[0])));

            ImportantParameter::create([
                'key' => 'configuration_forms_ledgers',
                'slug' => $row[0],
                'label_si' => $row[1],
                'label_ta' => $row[0],
                'label_en' => $en,
            ]);
        }

        $this->command->info("Seeded ".count($csvData)." records from CSV");
    }
}
