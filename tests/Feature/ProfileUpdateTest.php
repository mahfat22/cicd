<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_the_profile_form(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('profile.edit'));

        $response->assertOk();
        $response->assertSee('Update Profile');
    }

    public function test_authenticated_user_can_update_profile_details(): void
    {
        $user = User::factory()->create([
            'name' => 'Old Name',
            'email' => 'old@example.com',
        ]);

        $response = $this->actingAs($user)->patch(route('profile.update'), [
            'name' => 'New Name',
            'email' => 'new@example.com',
        ]);

        $response->assertRedirect(route('profile.edit'));
        $response->assertSessionHas('status', 'Profile updated successfully.');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'New Name',
            'email' => 'new@example.com',
        ]);
    }

    public function test_guest_user_is_redirected_when_visiting_profile_routes(): void
    {
        $this->get(route('profile.edit'))->assertRedirect('/');

        $this->patch(route('profile.update'), [
            'name' => 'Guest Name',
            'email' => 'guest@example.com',
        ])->assertRedirect('/');
    }
}
