<?php

namespace Tests\Feature;

use App\Models\Password;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PasswordFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_create_a_password_record()
    {
        $password = Password::factory()->create();

        $this->assertDatabaseHas('passwords', [
            'uuid' => $password->uuid,
        ]);
    }

    public function test_it_creates_a_password_with_encrypted_value()
    {
        $password = Password::factory()->create(['password' => 'plain-text']);

        $this->assertDatabaseHas('passwords', [
            'uuid' => $password->uuid,
        ]);

        $raw = $password->getRawOriginal('password');

        $this->assertNotEquals('plain-text', $raw);
        $this->assertEquals('plain-text', $password->password);
    }

    public function test_expired_password_is_deleted_by_scheduled_command()
    {
        $password = Password::factory()->create([
            'expires_at' => now()->subMinute(),
        ]);

        $this->assertDatabaseHas('passwords', [
            'uuid' => $password->uuid,
        ]);

        $this->artisan('passwords:delete-expired')->assertSuccessful();

        $this->assertDatabaseMissing('passwords', [
            'uuid' => $password->uuid,
        ]);
    }

    public function test_password_is_not_deleted_by_scheduled_command()
    {
        $password = Password::factory()->create();

        $this->artisan('passwords:delete-expired')->assertSuccessful();

        $this->assertDatabaseHas('passwords', [
            'uuid' => $password->uuid,
        ]);
    }
}
