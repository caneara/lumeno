<?php

namespace Tests\Integration\User;

use App\Models\User;
use App\Storage\Image;
use App\Types\ServerTest;
use Illuminate\Http\UploadedFile;

class AvatarTest extends ServerTest
{
    /** @test */
    public function a_user_can_update_their_avatar() : void
    {
        $user = User::factory()->create();

        Image::fake($original = $user->avatar);

        $payload = UploadedFile::fake()->image('avatar.jpg', 512, 512)->size(1);

        $this->actingAs($user)
            ->patchJson(route('avatar.update'), ['avatar' => $payload])
            ->assertRedirect(route('account.edit'))
            ->assertNotification('Your account has been updated');

        Image::assertMissing($original);
        Image::assertExists($user->fresh()->avatar);
    }
}
