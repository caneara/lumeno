<?php

namespace App\Models;

use App\Types\Model;
use App\Concerns\Shared\InteractsWithUuid;
use App\Concerns\Article\InteractsWithImages;
use App\Concerns\Article\InteractsWithRelations;

class Article extends Model
{
    use InteractsWithUuid;
    use InteractsWithImages;
    use InteractsWithRelations;

    /**
     * The attributes that should be cast to specific types.
     *
     */
    protected $casts = [
        'id'         => 'string',
        'user_id'    => 'string',
        'title'      => 'string',
        'slug'       => 'string',
        'summary'    => 'string',
        'content'    => 'string',
        'banner'     => 'string',
        'first_tag'  => 'string',
        'second_tag' => 'string',
        'third_tag'  => 'string',
        'fourth_tag' => 'string',
    ];
}
