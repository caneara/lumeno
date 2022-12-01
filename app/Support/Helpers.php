<?php

use App\Models\User;
use App\Models\Member;
use App\Support\Carbon;
use Illuminate\Support\Str;
use App\Models\Organization;
use Illuminate\Support\Facades\DB;

/**
 * Attempt to perform the given database task.
 *
 */
function attempt(Closure $action, bool $transaction = true, int $times = 40, int $delay = 250) : mixed
{
    $closure = $transaction ? fn() => DB::transaction($action, 10) : $action;

    return retry($times, $closure, $delay);
}

/**
 * Retrieve the current member.
 *
 */
function member() : Member | null
{
    return user()?->member;
}

/**
 * Create a new Carbon instance for the current date and time.
 *
 */
function now(DateTimeZone | string | null $zone = null) : Carbon
{
    return Carbon::now($zone);
}

/**
 * Retrieve the current organization.
 *
 */
function organization() : Organization | null
{
    return member()?->organization;
}

/**
 * Generate an ordered version 4 UUID.
 *
 */
function uuid() : string
{
    return Str::orderedUuid()->toString();
}

/**
 * Retrieve the current user.
 *
 */
function user() : User | null
{
    return auth()->user();
}

/**
 * Execute the given action if the given condition is positive.
 *
 */
function when(mixed $condition, Closure $action, mixed $default = null) : mixed
{
    return $condition ? $action() : $default;
}
