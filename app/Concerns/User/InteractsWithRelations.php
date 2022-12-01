<?php

namespace App\Concerns\User;

use App\Models\Skill;
use App\Models\Member;
use App\Models\School;
use App\Models\Article;
use App\Models\Project;
use App\Models\Workplace;
use App\Models\Invitation;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait InteractsWithRelations
{
    /**
     * Retrieve the articles associated with the user.
     *
     */
    public function articles() : HasMany
    {
        return $this->hasMany(Article::class);
    }

    /**
     * Retrieve the invitations associated with the user.
     *
     */
    public function invitations() : HasMany
    {
        return $this->hasMany(Invitation::class);
    }

    /**
     * Retrieve the member associated with the user.
     *
     */
    public function member() : HasOne
    {
        return $this->hasOne(Member::class);
    }

    /**
     * Retrieve the projects associated with the user.
     *
     */
    public function projects() : HasMany
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Retrieve the schools associated with the user.
     *
     */
    public function schools() : HasMany
    {
        return $this->hasMany(School::class);
    }

    /**
     * Retrieve the skills associated with the user.
     *
     */
    public function skills() : HasMany
    {
        return $this->hasMany(Skill::class);
    }

    /**
     * Retrieve the workplaces associated with the user.
     *
     */
    public function workplaces() : HasMany
    {
        return $this->hasMany(Workplace::class);
    }
}
