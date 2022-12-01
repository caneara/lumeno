<?php

namespace Tests\Integration\General;

use App\Models\User;
use App\Storage\Image;
use App\Types\ServerTest;
use Illuminate\Support\Facades\Storage;

class ImageTest extends ServerTest
{
    /** @test */
    public function a_user_can_store_an_image() : void
    {
        $user = User::factory()->create();

        $payload = ['uuid' => $uuid = uuid()];

        Image::fake($uuid);

        Storage::move("images/{$uuid}.jpg", "tmp/{$uuid}");

        $id = $this->actingAs($user)
            ->postJson(route('images.store'), $payload)
            ->assertSuccessful()
            ->json('id');

        Image::assertExists($id);

        Storage::assertMissing("tmp/{$uuid}");
    }
}
