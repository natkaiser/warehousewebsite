<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminCreateUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_user(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->post(route('users.store'), [
            'name' => 'User Baru',
            'email' => 'userbaru@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'user',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'name' => 'User Baru',
            'email' => 'userbaru@example.com',
            'role' => 'user',
        ]);

        $createdUser = User::where('email', 'userbaru@example.com')->firstOrFail();
        $this->assertTrue(Hash::check('password123', $createdUser->password));
    }

    public function test_non_admin_cannot_create_user(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->post(route('users.store'), [
            'name' => 'User Tidak Boleh',
            'email' => 'forbidden@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'user',
        ]);

        $response->assertForbidden();
        $this->assertDatabaseMissing('users', [
            'email' => 'forbidden@example.com',
        ]);
    }
}
