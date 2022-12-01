<?php

namespace App\Concerns\Project;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait InteractsWithRelations
{
    /**
     * Retrieve the user associated with the project.
     *
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
