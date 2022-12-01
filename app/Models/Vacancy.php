<?php

namespace App\Models;

use App\Types\Model;
use App\Casts\ReadOnlyJsonCast;
use App\Casts\LatitudeLongitudeCast;
use App\Concerns\Shared\InteractsWithUuid;
use App\Concerns\Vacancy\InteractsWithArchive;
use App\Concerns\Vacancy\InteractsWithRelations;
use App\Concerns\Vacancy\InteractsWithInvitations;
use App\Concerns\Vacancy\InteractsWithRequirements;
use Propaganistas\LaravelPhone\Casts\E164PhoneNumberCast;

class Vacancy extends Model
{
    use InteractsWithUuid;
    use InteractsWithArchive;
    use InteractsWithRelations;
    use InteractsWithInvitations;
    use InteractsWithRequirements;

    /**
     * The commitment options.
     *
     */
    public const COMMITMENT_CONTRACT  = 1;
    public const COMMITMENT_PART_TIME = 2;
    public const COMMITMENT_FULL_TIME = 3;

    /**
     * The attributes that should be cast to specific types.
     *
     */
    protected $casts = [
        'id'              => 'string',
        'organization_id' => 'string',
        'role'            => 'string',
        'summary'         => 'string',
        'commitment'      => 'integer',
        'months'          => 'integer',
        'currency'        => 'integer',
        'remuneration'    => 'integer',
        'area'            => 'string',
        'country'         => 'integer',
        'coordinates'     => LatitudeLongitudeCast::class,
        'first_language'  => 'integer',
        'second_language' => 'integer',
        'third_language'  => 'integer',
        'remote'          => 'boolean',
        'emigrate'        => 'boolean',
        'degree'          => 'boolean',
        'email'           => 'string',
        'phone'           => E164PhoneNumberCast::class,
        'website'         => 'string',
        'archived_at'     => 'datetime',
        'metrics'         => ReadOnlyJsonCast::class,
    ];
}
