<?php

namespace Tests\Feature\Auth;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ValidationTest extends TestCase
{
    use RefreshDatabase;

    protected $tenant;

    protected function setUp(): void
    {
        parent::setUp();
        $this->tenant = Tenant::factory()->create();
    }

    public function test_registration_requires_valid_name(): void
    {
        $response = $this->post('/register', [
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'tenant_id' => $this->tenant->id,
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    public function test_registration_requires_valid_email(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'invalid-email',
            'password' => 'password',
            'password_confirmation' => 'password',
            'tenant_id' => $this->tenant->id,
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_registration_requires_unique_email(): void
    {
        User::factory()->forTenant($this->tenant)->create([
            'email' => 'test@example.com',
        ]);

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'tenant_id' => $this->tenant->id,
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_registration_requires_password_minimum_length(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'pwd',
            'password_confirmation' => 'pwd',
            'tenant_id' => $this->tenant->id,
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    public function test_registration_requires_password_confirmation(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'tenant_id' => $this->tenant->id,
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    public function test_login_requires_valid_email(): void
    {
        $response = $this->post('/login', [
            'email' => 'invalid-email',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_login_requires_registered_email(): void
    {
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_password_reset_requires_valid_email(): void
    {
        $response = $this->post('/forgot-password', [
            'email' => 'invalid-email',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_password_reset_requires_registered_email(): void
    {
        $response = $this->post('/forgot-password', [
            'email' => 'test@example.com',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_password_update_requires_current_password(): void
    {
        $user = User::factory()->forTenant($this->tenant)->create();

        $response = $this->actingAs($user)
            ->put('/profile/password', [
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ]);

        $response->assertSessionHasErrors(['current_password']);
    }

    public function test_password_update_requires_new_password_different_from_current(): void
    {
        $user = User::factory()->forTenant($this->tenant)->create([
            'password' => bcrypt('current-password'),
        ]);

        $response = $this->actingAs($user)
            ->put('/profile/password', [
                'current_password' => 'current-password',
                'password' => 'current-password',
                'password_confirmation' => 'current-password',
            ]);

        $response->assertSessionHasErrors(['password']);
    }

    public function test_registration_requires_valid_tenant(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'tenant_id' => 999,
        ]);

        $response->assertSessionHasErrors(['tenant_id']);
    }
}
