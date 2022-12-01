<?php

namespace App\Models;

use App\Types\Model;
use App\Concerns\Shared\InteractsWithUuid;
use App\Concerns\Project\InteractsWithRelations;

class Project extends Model
{
    use InteractsWithUuid;
    use InteractsWithRelations;

    /**
     * The project types.
     *
     */
    public const TYPE_OPEN_SOURCE                         = 1;
    public const TYPE_DESKTOP_MOBILE_APPLICATION          = 2;
    public const TYPE_WEB_APPLICATION                     = 3;
    public const TYPE_PROTOTYPE                           = 4;
    public const TYPE_DESIGN_UI_UX                        = 5;
    public const TYPE_HARDWARE                            = 6;
    public const TYPE_SYSTEM_ARCHITECTURAL_INFRASTRUCTURE = 7;
    public const TYPE_PERSONAL                            = 8;
    public const TYPE_EDUCATIONAL                         = 9;
    public const TYPE_OTHER                               = 10;
    public const TYPE_WEB_APPLICATION_SAAS                = 11;
    public const TYPE_WEB_APPLICATION_MARKETPLACE         = 12;
    public const TYPE_WEB_APPLICATION_ECOMMERCE           = 13;
    public const TYPE_CRYPTO_CURRENCY                     = 14;
    public const TYPE_WEB_PLATFORM_PLUGIN                 = 15;
    public const TYPE_DESKTOP_MOBILE_PLUGIN               = 16;

    /**
     * The attributes that should be cast to specific types.
     *
     */
    protected $casts = [
        'id'           => 'string',
        'user_id'      => 'string',
        'type'         => 'integer',
        'logo'         => 'string',
        'title'        => 'string',
        'summary'      => 'string',
        'url'          => 'string',
        'first_tag'    => 'string',
        'second_tag'   => 'string',
        'third_tag'    => 'string',
        'fourth_tag'   => 'string',
        'first_image'  => 'string',
        'second_image' => 'string',
        'third_image'  => 'string',
    ];
}
