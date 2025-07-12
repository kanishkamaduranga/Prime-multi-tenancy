<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            "AccountSegments",
            "Banks",
            "BankAccounts",
            "Branches",
            "BranchManager",
            "BranchTypes",
            "ControlAccounts",
            "Creditors",
            "Debtors",
            "Departments",
            "DepartmentCategory",
            "Employees",
            "ExternalPeople",
            "Journals",
            "Ledgers",
            "LedgerController",
            "Managers",
            "PaymentAnalyses",
            "Regions",
            "SubAccountSegments",
            "Vehicles",
            "VehiclesRenteds",
            "UserManagement",
        ];

        $action_list = [  'view', 'create', 'edit', 'delete'  ];

        foreach ($permissions as $permission) {
            foreach ($action_list as $action) {
                Permission::firstOrCreate([
                    'name' => $permission . "_" . $action,
                    'guard_name' => 'web'
                ]);
            }
        }
    }
}
