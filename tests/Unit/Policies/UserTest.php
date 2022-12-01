<?php

namespace Tests\Unit\Policies;

use App\Models\User;
use App\Types\ServerTest;
use App\Policies\UserPolicy;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserTest extends ServerTest
{
    /** @test */
    public function it_rate_limits_uploads() : void
    {
        $user = User::factory()->create();

        RateLimiter::clear("upload-files:{$user->id}");

        $policy = new UserPolicy();

        for ($i = 0; $i < 10; $i++) {
            $this->assertTrue($policy->uploadFiles($user));
        }

        try {
            $policy->uploadFiles($user);
        } catch (HttpException $ex) {
            $this->assertEquals(Response::HTTP_TOO_MANY_REQUESTS, $ex->getStatusCode());
        }

        RateLimiter::clear("upload-files:{$user->id}");
    }
}
