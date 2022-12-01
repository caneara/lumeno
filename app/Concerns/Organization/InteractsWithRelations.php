<?php

namespace App\Concerns\Organization;

use App\Models\Member;
use App\Models\Vacancy;
use App\Models\Invitation;
use App\Models\Requirement;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait InteractsWithRelations
{
    /**
     * Retrieve the invitations associated with the organization.
     *
     */
    public function invitations() : HasMany
    {
        return $this->hasMany(Invitation::class);
    }

    /**
     * Retrieve the members associated with the organization.
     *
     */
    public function members() : HasMany
    {
        return $this->hasMany(Member::class);
    }

    /**
     * Retrieve the requirements associated with the organization.
     *
     */
    public function requirements() : HasMany
    {
        return $this->hasMany(Requirement::class);
    }

    /**
     * Retrieve the vacancies associated with the organization.
     *
     */
    public function vacancies() : HasMany
    {
        return $this->hasMany(Vacancy::class);
    }
}
