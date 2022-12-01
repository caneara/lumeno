<?php

namespace App\Concerns\School;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait InteractsWithRelations
{
    /**
     * Retrieve the user associated with the school.
     *
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
