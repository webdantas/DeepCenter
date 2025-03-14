<?php

namespace Database\Factories;

use App\Models\Profile;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tenant = Tenant::factory()->create();
        $user = User::factory()->create(['tenant_id' => $tenant->id]);

        return [
            'tenant_id' => $tenant->id,
            'user_id' => $user->id,
            'bio' => fake()->paragraphs(2, true),
            'avatar' => null,
            'phone' => fake()->phoneNumber(),
            'address' => fake()->streetAddress(),
            'city' => fake()->city(),
            'state' => fake()->state(),
            'country' => fake()->country(),
            'postal_code' => fake()->postcode(),
            'timezone' => 'America/Sao_Paulo',
            'language' => fake()->randomElement(['en', 'pt-BR', 'es']),
            'theme' => fake()->randomElement(['light', 'dark']),
            'notifications_enabled' => fake()->boolean(),
        ];
    }

    /**
     * Indicate that the profile belongs to a specific tenant.
     */
    public function forTenant(Tenant $tenant): static
    {
        return $this->state(fn (array $attributes) => [
            'tenant_id' => $tenant->id,
            'user_id' => User::factory()->create(['tenant_id' => $tenant->id])->id,
        ]);
    }

    /**
     * Indicate that the profile belongs to a specific user.
     */
    public function forUser(User $user): static
    {
        return $this->state(fn (array $attributes) => [
            'tenant_id' => $user->tenant_id,
            'user_id' => $user->id,
        ]);
    }

    /**
     * Indicate that the profile has an avatar.
     */
    public function withAvatar(): static
    {
        return $this->state(fn (array $attributes) => [
            'avatar' => 'avatars/' . fake()->uuid() . '.jpg',
        ]);
    }

    /**
     * Indicate that notifications are enabled.
     */
    public function withNotifications(): static
    {
        return $this->state(fn (array $attributes) => [
            'notifications_enabled' => true,
        ]);
    }

    /**
     * Indicate that notifications are disabled.
     */
    public function withoutNotifications(): static
    {
        return $this->state(fn (array $attributes) => [
            'notifications_enabled' => false,
        ]);
    }
}
