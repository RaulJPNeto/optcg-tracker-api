<?php

namespace Tests\Feature\Set;

use App\Models\CardSet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SetTest extends TestCase
{
    use RefreshDatabase;

    public function test_anyone_can_list_sets(): void
    {
        CardSet::factory()->count(3)->create();

        $response = $this->getJson('/api/sets');

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
    }

    public function test_can_filter_sets_by_search(): void
    {
        CardSet::factory()->create(['name' => 'Adventure on Kami Island']);
        CardSet::factory()->create(['name' => 'Wings of the Captain']);

        $response = $this->getJson('/api/sets?search=Adventure');

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
        $response->assertJsonFragment(['name' => 'Adventure on Kami Island']);
    }

    public function test_anyone_can_view_a_set(): void
    {
        $set = CardSet::factory()->create();

        $response = $this->getJson("/api/sets/{$set->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment(['code' => $set->code]);
    }

    public function test_returns_404_for_nonexistent_set(): void
    {
        $response = $this->getJson('/api/sets/999');

        $response->assertStatus(404);
    }

    public function test_admin_can_create_set(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)
            ->postJson('/api/sets', [
                'code' => 'OP15',
                'name' => 'Adventure on Kami Island',
                'release_date_jp' => '2026-03-01',
                'total_cards' => 120,
            ]);

        $response->assertStatus(201);
        $response->assertJsonFragment(['code' => 'OP15']);
        $this->assertDatabaseHas('sets', ['code' => 'OP15']);
    }

    public function test_editor_can_create_set(): void
    {
        $editor = User::factory()->editor()->create();

        $response = $this->actingAs($editor)
            ->postJson('/api/sets', [
                'code' => 'OP16',
                'name' => 'New Set',
            ]);

        $response->assertStatus(201);
    }

    public function test_viewer_cannot_create_set(): void
    {
        $viewer = User::factory()->viewer()->create();

        $response = $this->actingAs($viewer)
            ->postJson('/api/sets', [
                'code' => 'OP15',
                'name' => 'Adventure on Kami Island',
            ]);

        $response->assertStatus(403);
    }

    public function test_unauthenticated_user_cannot_create_set(): void
    {
        $response = $this->postJson('/api/sets', [
            'code' => 'OP15',
            'name' => 'Adventure on Kami Island',
        ]);

        $response->assertStatus(401);
    }

    public function test_cannot_create_set_with_duplicate_code(): void
    {
        $admin = User::factory()->admin()->create();
        CardSet::factory()->create(['code' => 'OP15']);

        $response = $this->actingAs($admin)
            ->postJson('/api/sets', [
                'code' => 'OP15',
                'name' => 'Outro Set',
            ]);

        $response->assertStatus(422);
    }

    public function test_admin_can_update_set(): void
    {
        $admin = User::factory()->admin()->create();
        $set = CardSet::factory()->create();

        $response = $this->actingAs($admin)
            ->putJson("/api/sets/{$set->id}", [
                'name' => 'Updated Name',
            ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => 'Updated Name']);
    }

    public function test_viewer_cannot_update_set(): void
    {
        $viewer = User::factory()->viewer()->create();
        $set = CardSet::factory()->create();

        $response = $this->actingAs($viewer)
            ->putJson("/api/sets/{$set->id}", [
                'name' => 'Updated Name',
            ]);

        $response->assertStatus(403);
    }

    public function test_admin_can_delete_set(): void
    {
        $admin = User::factory()->admin()->create();
        $set = CardSet::factory()->create();

        $response = $this->actingAs($admin)
            ->deleteJson("/api/sets/{$set->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('sets', ['id' => $set->id]);
    }

    public function test_editor_cannot_delete_set(): void
    {
        $editor = User::factory()->editor()->create();
        $set = CardSet::factory()->create();

        $response = $this->actingAs($editor)
            ->deleteJson("/api/sets/{$set->id}");

        $response->assertStatus(403);
    }

    public function test_viewer_cannot_delete_set(): void
    {
        $viewer = User::factory()->viewer()->create();
        $set = CardSet::factory()->create();

        $response = $this->actingAs($viewer)
            ->deleteJson("/api/sets/{$set->id}");

        $response->assertStatus(403);
    }
}
