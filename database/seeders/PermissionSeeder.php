<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            "AccountSegment",
            "Bank",
            "BankAccount",
            "Branch",
            "BranchManager",
            "BranchType",
            "ControlAccount",
            "Creditor",
            "Debtor",
            "Department",
            "DepartmentCategory",
            "Employee",
            "ExternalPerson",
            "Journal",
            "Ledger",
            "LedgerController",
            "Manager",
            "PaymentAnalysis",
            "Region",
            "SubAccountSegment",
            "Vehicle",
            "VehiclesRented",
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
