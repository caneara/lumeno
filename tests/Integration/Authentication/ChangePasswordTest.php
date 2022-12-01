<?php

namespace Tests\Integration\Authentication;

use App\Models\User;
use App\Types\ServerTest;
use Illuminate\Support\Facades\Hash;

class ChangePasswordTest extends ServerTest
{
    /** @test */
    public function a_user_can_change_their_password_when_they_supply_their_correct_password() : void
    {
        $user = User::factory()->create();

        $payload = [
            'old_password'              => 'Q5p@4xFvw9w#',
            'new_password'              => 'R5p@4xFvw9w#',
            'new_password_confirmation' => 'R5p@4xFvw9w#',
        ];

        $this->actingAs($user)
            ->postJson(route('password.update'), $payload)
            ->assertRedirect(route('account.edit'))
            ->assertNotification('Your password has been updated');

        $this->assertTrue(Hash::check('R5p@4xFvw9w#', $user->fresh()->password));
    }

    /** @test */
    public function a_user_cannot_change_their_password_if_they_supply_an_incorrect_password() : void
    {
        $user = User::factory()->create();

        $payload = [
            'old_password'              => 'old password',
            'new_password'              => 'new password',
            'new_password_confirmation' => 'new password',
        ];

        $this->actingAs($user)
            ->postJson(route('password.update'), $payload)
            ->assertInvalid('old_password');
    }
}
