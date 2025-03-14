<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tenant>
 */
class TenantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->company();
        $domain = strtolower(str_replace(' ', '-', $name)) . '.example.com';
        $database = 'tenant_' . strtolower(str_replace([' ', '-'], '_', $name));

        return [
            'name' => $name,
            'domain' => $domain,
            'database' => $database,
            'settings' => [
                'timezone' => 'America/Sao_Paulo',
                'language' => 'pt-BR',
                'theme' => 'light',
                'notifications_enabled' => true,
            ],
            'status' => 'active',
        ];
    }

    /**
     * Indicate that the tenant is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'inactive',
        ]);
    }

    /**
     * Indicate that the tenant has dark theme enabled.
     */
    public function darkTheme(): static
    {
        return $this->state(fn (array $attributes) => [
            'settings' => array_merge($attributes['settings'] ?? [], [
                'theme' => 'dark',
            ]),
        ]);
    }

    /**
     * Indicate that the tenant has notifications disabled.
     */
    public function withoutNotifications(): static
    {
        return $this->state(fn (array $attributes) => [
            'settings' => array_merge($attributes['settings'] ?? [], [
                'notifications_enabled' => false,
            ]),
        ]);
    }
}
