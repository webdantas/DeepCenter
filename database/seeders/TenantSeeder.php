<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create main tenant
        Tenant::factory()->create([
            'name' => 'DeepCenter',
            'domain' => 'deepcenter.com',
            'database' => 'deepcenter',
        ]);

        // Create additional demo tenants
        Tenant::factory()->count(3)->create();
    }
}
