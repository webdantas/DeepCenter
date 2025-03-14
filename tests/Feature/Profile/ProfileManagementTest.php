<?php

namespace Tests\Feature\Profile;

use App\Models\Profile;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileManagementTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $tenant;
    protected $user;
    protected $otherTenant;
    protected $otherUser;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        // Create tenants
        $this->tenant = Tenant::factory()->create([
            'name' => 'Test Tenant',
            'domain' => 'test.example.com',
            'database' => 'test_db',
        ]);

        $this->otherTenant = Tenant::factory()->create([
            'name' => 'Other Tenant',
            'domain' => 'other.example.com',
            'database' => 'other_db',
        ]);

        // Create users
        $this->user = User::factory()->create([
            'tenant_id' => $this->tenant->id,
        ]);

        $this->otherUser = User::factory()->create([
            'tenant_id' => $this->otherTenant->id,
        ]);
    }

    /** @test */
    public function user_can_view_profile_list()
    {
        $profiles = Profile::factory(3)->create([
            'tenant_id' => $this->tenant->id,
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('profile.index'));

        $response->assertStatus(200)
            ->assertViewIs('profile.management.index')
            ->assertViewHas('profiles');

        foreach ($profiles as $profile) {
            $response->assertSee($profile->user->name);
        }
    }

    /** @test */
    public function user_cannot_view_profiles_from_other_tenant()
    {
        $otherProfile = Profile::factory()->create([
            'tenant_id' => $this->otherTenant->id,
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('profile.index'));

        $response->assertStatus(200)
            ->assertDontSee($otherProfile->user->name);
    }

    /** @test */
    public function user_can_create_profile()
    {
        $avatar = UploadedFile::fake()->image('avatar.jpg');
        $profileData = [
            'user_id' => $this->user->id,
            'bio' => $this->faker->paragraph,
            'avatar' => $avatar,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'country' => $this->faker->country,
            'postal_code' => $this->faker->postcode,
            'timezone' => 'America/Sao_Paulo',
            'language' => 'pt-BR',
            'theme' => 'light',
            'notifications_enabled' => true,
        ];

        $response = $this->actingAs($this->user)
            ->post(route('profile.store'), $profileData);

        $response->assertRedirect()
            ->assertSessionHas('success');

        $this->assertDatabaseHas('profiles', [
            'tenant_id' => $this->tenant->id,
            'user_id' => $this->user->id,
            'bio' => $profileData['bio'],
            'phone' => $profileData['phone'],
            'city' => $profileData['city'],
            'state' => $profileData['state'],
            'country' => $profileData['country'],
            'postal_code' => $profileData['postal_code'],
            'timezone' => $profileData['timezone'],
            'language' => $profileData['language'],
            'theme' => $profileData['theme'],
            'notifications_enabled' => $profileData['notifications_enabled'],
        ]);

        Storage::disk('public')->assertExists('avatars/' . $avatar->hashName());
    }

    /** @test */
    public function user_cannot_create_profile_for_user_from_other_tenant()
    {
        $profileData = [
            'user_id' => $this->otherUser->id,
            'bio' => $this->faker->paragraph,
            'timezone' => 'America/Sao_Paulo',
            'language' => 'pt-BR',
            'theme' => 'light',
            'notifications_enabled' => true,
        ];

        $response = $this->actingAs($this->user)
            ->post(route('profile.store'), $profileData);

        $response->assertSessionHasErrors('user_id');

        $this->assertDatabaseMissing('profiles', [
            'user_id' => $this->otherUser->id,
        ]);
    }

    /** @test */
    public function user_can_update_profile()
    {
        $profile = Profile::factory()->create([
            'tenant_id' => $this->tenant->id,
        ]);

        $newAvatar = UploadedFile::fake()->image('new-avatar.jpg');
        $updatedData = [
            'bio' => 'Updated bio',
            'avatar' => $newAvatar,
            'phone' => '1234567890',
            'timezone' => 'America/New_York',
            'language' => 'en',
            'theme' => 'dark',
            'notifications_enabled' => false,
        ];

        $response = $this->actingAs($this->user)
            ->put(route('profile.management.update', $profile), $updatedData);

        $response->assertRedirect()
            ->assertSessionHas('success');

        $this->assertDatabaseHas('profiles', [
            'id' => $profile->id,
            'bio' => 'Updated bio',
            'phone' => '1234567890',
            'timezone' => 'America/New_York',
            'language' => 'en',
            'theme' => 'dark',
            'notifications_enabled' => false,
        ]);

        Storage::disk('public')->assertExists('avatars/' . $newAvatar->hashName());
    }

    /** @test */
    public function user_cannot_update_profile_from_other_tenant()
    {
        $otherProfile = Profile::factory()->create([
            'tenant_id' => $this->otherTenant->id,
        ]);

        $updatedData = [
            'bio' => 'Updated bio',
            'timezone' => 'America/New_York',
            'language' => 'en',
            'theme' => 'dark',
            'notifications_enabled' => false,
        ];

        $response = $this->actingAs($this->user)
            ->put(route('profile.management.update', $otherProfile), $updatedData);

        $response->assertStatus(403);

        $this->assertDatabaseMissing('profiles', [
            'id' => $otherProfile->id,
            'bio' => 'Updated bio',
        ]);
    }

    /** @test */
    public function user_can_delete_profile()
    {
        $profile = Profile::factory()->create([
            'tenant_id' => $this->tenant->id,
            'avatar' => 'avatars/test-avatar.jpg',
        ]);

        Storage::disk('public')->put('avatars/test-avatar.jpg', 'fake avatar content');

        $response = $this->actingAs($this->user)
            ->delete(route('profile.management.destroy', $profile));

        $response->assertRedirect()
            ->assertSessionHas('success');

        $this->assertSoftDeleted('profiles', [
            'id' => $profile->id,
        ]);

        Storage::disk('public')->assertMissing('avatars/test-avatar.jpg');
    }

    /** @test */
    public function user_cannot_delete_profile_from_other_tenant()
    {
        $otherProfile = Profile::factory()->create([
            'tenant_id' => $this->otherTenant->id,
        ]);

        $response = $this->actingAs($this->user)
            ->delete(route('profile.management.destroy', $otherProfile));

        $response->assertStatus(403);

        $this->assertDatabaseHas('profiles', [
            'id' => $otherProfile->id,
            'deleted_at' => null,
        ]);
    }

    /** @test */
    public function validation_fails_with_invalid_data()
    {
        $invalidData = [
            'user_id' => 999999, // Non-existent user
            'bio' => str_repeat('a', 1001), // Bio too long
            'avatar' => UploadedFile::fake()->create('document.pdf'), // Wrong file type
            'phone' => str_repeat('1', 21), // Phone too long
            'timezone' => 'invalid-timezone',
            'language' => 'invalid-language',
            'theme' => 'invalid-theme',
            'notifications_enabled' => 'not-a-boolean',
        ];

        $response = $this->actingAs($this->user)
            ->post(route('profile.store'), $invalidData);

        $response->assertSessionHasErrors([
            'user_id',
            'bio',
            'avatar',
            'phone',
            'timezone',
            'language',
            'theme',
            'notifications_enabled',
        ]);
    }
}
