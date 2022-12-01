<?php

namespace App\Concerns\Member;

use App\Models\User;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait InteractsWithRelations
{
    /**
     * Retrieve the organization associated with the member.
     *
     */
    public function organization() : BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Retrieve the user associated with the member.
     *
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
