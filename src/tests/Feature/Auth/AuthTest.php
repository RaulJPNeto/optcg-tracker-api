<?php

namespace Tests\Feature\Auth;

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_with_valid_invitation(): void
    {
        $admin = User::factory()->admin()->create();

        $invitation = Invitation::factory()->valid()->create([
            'invited_by' => $admin->id,
        ]);

        $response = $this->postJson('/api/auth/register', [
            'name'                  => 'João Silva',
            'email'                 => $invitation->email,
            'password'              => 'password123',
            'password_confirmation' => 'password123',
            'invitation_token'      => $invitation->token,
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure(['token', 'user']);

        $this->assertDatabaseHas('users', [
            'email' => $invitation->email,
        ]);

        $this->assertDatabaseHas('invitations', [
            'token'  => $invitation->token,
        ]);
        $this->assertNotNull(
            Invitation::where('token', $invitation->token)->first()->used_at
        );
    }

    public function test_user_cannot_register_with_expired_invitation(): void
    {
        $invitation = Invitation::factory()->expired()->create();

        $response = $this->postJson('/api/auth/register', [
            'name'                  => 'João Silva',
            'email'                 => $invitation->email,
            'password'              => 'password123',
            'password_confirmation' => 'password123',
            'invitation_token'      => $invitation->token,
        ]);

        $response->assertStatus(422);
    }

    public function test_user_cannot_register_with_used_invitation(): void
    {
        $invitation = Invitation::factory()->used()->create();

        $response = $this->postJson('/api/auth/register', [
            'name'                  => 'João Silva',
            'email'                 => $invitation->email,
            'password'              => 'password123',
            'password_confirmation' => 'password123',
            'invitation_token'      => $invitation->token,
        ]);

        $response->assertStatus(422);
    }

    public function test_user_cannot_register_with_invalid_data(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name'  => '',
            'email' => 'email-invalido',
        ]);

        $response->assertStatus(422);
    }

    public function test_user_can_login(): void
    {
        $user = User::factory()->create([
            'email'    => 'joao@test.com',
            'password' => 'password123',
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email'    => 'joao@test.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['token', 'user']);
    }

    public function test_user_cannot_login_with_wrong_password(): void
    {
        $user = User::factory()->create([
            'email' => 'joao@test.com',
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email'    => 'joao@test.com',
            'password' => 'senha-errada',
        ]);

        $response->assertStatus(422);
    }

    public function test_user_cannot_login_with_nonexistent_email(): void
    {
        $response = $this->postJson('/api/auth/login', [
            'email'    => 'naoexiste@test.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(422);
    }

    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson('/api/auth/logout');

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Logout realizado com sucesso!']);
    }

    public function test_unauthenticated_user_cannot_logout(): void
    {
        $response = $this->postJson('/api/auth/logout');

        $response->assertStatus(401);
    }

    public function test_authenticated_user_can_get_own_data(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->getJson('/api/auth/me');

        $response->assertStatus(200);
        $response->assertJsonFragment(['email' => $user->email]);
    }

    public function test_unauthenticated_user_cannot_access_me(): void
    {
        $response = $this->getJson('/api/auth/me');

        $response->assertStatus(401);
    }

}
