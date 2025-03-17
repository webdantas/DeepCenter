<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use App\Models\Tenant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create main tenant
        $tenant = Tenant::create([
            'name' => 'DeepCenter',
            'domain' => 'deepcenter.com',
            'database' => 'deepcenter',
            'active' => true,
        ]);

        // Create admin user
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@deepcenter.com',
            'password' => Hash::make('password'),
            'tenant_id' => $tenant->id,
            'email_verified_at' => now(),
        ]);

        // Create admin profile
        Profile::create([
            'user_id' => $admin->id,
            'name' => $admin->name,
            'email' => $admin->email,
            'tenant_id' => $tenant->id,
        ]);

        // Create demo users with profiles
        for ($i = 1; $i <= 5; $i++) {
            $user = User::create([
                'name' => "User {$i}",
                'email' => "user{$i}@deepcenter.com",
                'password' => Hash::make('password'),
                'tenant_id' => $tenant->id,
                'email_verified_at' => now(),
            ]);

            Profile::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'tenant_id' => $tenant->id,
            ]);
        }
    }
}
