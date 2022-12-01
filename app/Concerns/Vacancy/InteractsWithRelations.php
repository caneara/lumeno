<?php

namespace App\Concerns\Vacancy;

use App\Models\Invitation;
use App\Models\Requirement;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait InteractsWithRelations
{
    /**
     * Retrieve the invitations associated with the vacancy.
     *
     */
    public function invitations() : HasMany
    {
        return $this->hasMany(Invitation::class);
    }

    /**
     * Retrieve the organization associated with the vacancy.
     *
     */
    public function organization() : BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Retrieve the requirements associated with the vacancy.
     *
     */
    public function requirements() : HasMany
    {
        return $this->hasMany(Requirement::class);
    }
}
