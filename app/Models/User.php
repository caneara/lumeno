<?php

namespace App\Models;

use App\Types\Model;
use App\Casts\HashCast;
use App\Casts\ReadOnlyJsonCast;
use App\Casts\LatitudeLongitudeCast;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use App\Concerns\User\InteractsWithType;
use Illuminate\Notifications\Notifiable;
use App\Concerns\Shared\InteractsWithUuid;
use App\Concerns\User\InteractsWithRelations;
use Illuminate\Auth\Passwords\CanResetPassword;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract, MustVerifyEmailContract
{
    use Notifiable;
    use Authorizable;
    use Authenticatable;
    use MustVerifyEmail;
    use CanResetPassword;
    use InteractsWithType;
    use InteractsWithUuid;
    use InteractsWithRelations;

    /**
     * The commute distance options.
     *
     */
    public const COMMUTE_KILOMETERS_ZERO = 0;
    public const COMMUTE_KILOMETERS_5    = 5;
    public const COMMUTE_KILOMETERS_10   = 10;
    public const COMMUTE_KILOMETERS_15   = 15;
    public const COMMUTE_KILOMETERS_20   = 20;
    public const COMMUTE_KILOMETERS_25   = 25;
    public const COMMUTE_KILOMETERS_30   = 30;
    public const COMMUTE_KILOMETERS_40   = 40;
    public const COMMUTE_KILOMETERS_50   = 50;
    public const COMMUTE_KILOMETERS_75   = 75;
    public const COMMUTE_KILOMETERS_100  = 100;


    /**
     * The account types.
     *
     */
    public const TYPE_CUSTOMER = 1;
    public const TYPE_EMPLOYEE = 2;

    /**
     * The remote working options.
     *
     */
    public const REMOTE_NO   = 1;
    public const REMOTE_YES  = 2;
    public const REMOTE_ONLY = 3;

    /**
     * The attributes that should be hidden for arrays.
     *
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to specific types.
     *
     */
    protected $casts = [
        'id'                => 'string',
        'type'              => 'integer',
        'name'              => 'string',
        'handle'            => 'string',
        'email'             => 'string',
        'password'          => HashCast::class,
        'avatar'            => 'string',
        'available'         => 'boolean',
        'country'           => 'integer',
        'area'              => 'string',
        'coordinates'       => LatitudeLongitudeCast::class,
        'time_zone'         => 'integer',
        'full_time'         => 'boolean',
        'part_time'         => 'boolean',
        'contract'          => 'boolean',
        'first_language'    => 'integer',
        'second_language'   => 'integer',
        'third_language'    => 'integer',
        'emigrate'          => 'boolean',
        'remote'            => 'integer',
        'commute'           => 'integer',
        'currency'          => 'integer',
        'remuneration'      => 'integer',
        'github'            => 'string',
        'twitter'           => 'string',
        'linkedin'          => 'string',
        'youtube'           => 'string',
        'facebook'          => 'string',
        'instagram'         => 'string',
        'statement'         => 'string',
        'email_verified_at' => 'datetime',
        'remember_token'    => 'string',
        'metrics'           => ReadOnlyJsonCast::class,
    ];

    /**
     * Send the password reset notification.
     *
     */
    public function sendPasswordResetNotification($token) : void
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
