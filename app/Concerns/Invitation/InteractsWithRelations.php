<?php

namespace App\Concerns\Invitation;

use App\Models\User;
use App\Models\Vacancy;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait InteractsWithRelations
{
    /**
     * Retrieve the organization associated with the invitation.
     *
     */
    public function organization() : BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Retrieve the user associated with the invitation.
     *
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Retrieve the vacancy associated with the invitation.
     *
     */
    public function vacancy() : BelongsTo
    {
        return $this->belongsTo(Vacancy::class);
    }
}
