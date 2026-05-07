<?php

namespace Tests\Feature\Invitation;

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvitationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_list_invitations(): void
    {
        $admin = User::factory()->admin()->create();
        Invitation::factory()->count(3)->create(['invited_by' => $admin->id]);

        $response = $this->actingAs($admin)
            ->getJson('/api/invitations');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    public function test_editor_cannot_list_invitations(): void
    {
        $editor = User::factory()->editor()->create();

        $response = $this->actingAs($editor)
            ->getJson('/api/invitations');

        $response->assertStatus(403);
    }

    public function test_unauthenticated_user_cannot_list_invitations(): void
    {
        $response = $this->getJson('/api/invitations');

        $response->assertStatus(401);
    }

    public function test_admin_can_send_invitation(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)
            ->postJson('/api/invitations', [
                'email' => 'novo@test.com',
            ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('invitations', [
            'email' => 'novo@test.com',
            'invited_by' => $admin->id,
        ]);
    }

    public function test_admin_cannot_send_invitation_to_existing_user(): void
    {
        $admin = User::factory()->admin()->create();
        User::factory()->create(['email' => 'jaexiste@test.com']);

        $response = $this->actingAs($admin)
            ->postJson('/api/invitations', [
                'email' => 'jaexiste@test.com',
            ]);

        $response->assertStatus(422);
    }

    public function test_admin_cannot_send_duplicate_invitation(): void
    {
        $admin = User::factory()->admin()->create();
        Invitation::factory()->create([
            'email' => 'pendente@test.com',
            'invited_by' => $admin->id,
        ]);

        $response = $this->actingAs($admin)
            ->postJson('/api/invitations', [
                'email' => 'pendente@test.com',
            ]);

        $response->assertStatus(422);
    }

    public function test_editor_cannot_send_invitation(): void
    {
        $editor = User::factory()->editor()->create();

        $response = $this->actingAs($editor)
            ->postJson('/api/invitations', [
                'email' => 'novo@test.com',
            ]);

        $response->assertStatus(403);
    }

    public function test_anyone_can_validate_a_valid_invitation(): void
    {
        $invitation = Invitation::factory()->valid()->create();

        $response = $this->getJson("/api/invitations/{$invitation->token}");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'email' => $invitation->email,
            'is_valid' => true,
        ]);
    }

    public function test_expired_invitation_returns_is_valid_false(): void
    {
        $invitation = Invitation::factory()->expired()->create();

        $response = $this->getJson("/api/invitations/{$invitation->token}");

        $response->assertStatus(200);
        $response->assertJsonFragment(['is_valid' => false]);
    }

    public function test_used_invitation_returns_is_valid_false(): void
    {
        $invitation = Invitation::factory()->used()->create();

        $response = $this->getJson("/api/invitations/{$invitation->token}");

        $response->assertStatus(200);
        $response->assertJsonFragment(['is_valid' => false]);
    }

    public function test_nonexistent_token_returns_404(): void
    {
        $response = $this->getJson('/api/invitations/token-que-nao-existe');

        $response->assertStatus(404);
    }
}
