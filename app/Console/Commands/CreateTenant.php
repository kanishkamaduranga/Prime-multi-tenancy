<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateTenant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:create
                            {id : The ID of the tenant}
                            {domain : The domain for the tenant}
                            {--email= : The email of the super admin user}
                            {--password= : The password of the super admin user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new tenant with a super admin user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tenantId = $this->argument('id');
        $domain = $this->argument('domain');
        $email = $this->option('email');
        $password = $this->option('password');

        if (!$email || !$password) {
            $this->error('Email and password are required to create a super admin user.');
            return;
        }

        // Create the tenant
        $tenant = Tenant::create(['id' => $tenantId]);

        // Create the domain for the tenant
        $tenant->domains()->create(['domain' => $domain]);

        // Create a super admin user for the tenant
        if ($email && $password) {
            $this->createSuperAdminUser($tenant, $email, $password);
        }

        $this->info("Tenant '{$tenantId}' with domain '{$domain}' created successfully.");
    }

    /**
     * Create a super admin user for the tenant.
     *
     * @param Tenant $tenant
     * @param string $email
     * @param string $password
     */
    protected function createSuperAdminUser(Tenant $tenant, string $email, string $password)
    {
        tenancy()->initialize($tenant);

        User::create([
            'name' => 'Super Admin',
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'super_admin', // Assuming you have a 'role' column
        ]);

        tenancy()->end();

        $this->info("Super admin user created with email '{$email}'.");
    }
}
