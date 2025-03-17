<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Tenant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $mainTenant = Tenant::where('name', 'DeepCenter')->first();

        // Create admin user for main tenant
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@deepcenter.com',
            'password' => Hash::make('password'),
            'tenant_id' => $mainTenant->id,
            'email_verified_at' => now(),
        ]);

        // Create demo users for each tenant
        Tenant::all()->each(function ($tenant) {
            // Create a manager for each tenant
            User::factory()->create([
                'name' => "Manager {$tenant->name}",
                'email' => "manager@{$tenant->domain}",
                'password' => Hash::make('password'),
                'tenant_id' => $tenant->id,
                'email_verified_at' => now(),
            ]);

            // Create regular users for each tenant
            User::factory()
                ->count(5)
                ->create([
                    'tenant_id' => $tenant->id,
                    'email_verified_at' => now(),
                ]);
        });
    }
}
