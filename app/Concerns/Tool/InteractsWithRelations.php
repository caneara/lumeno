<?php

namespace App\Concerns\Tool;

use App\Models\Skill;
use App\Models\Category;
use App\Models\Requirement;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait InteractsWithRelations
{
    /**
     * Retrieve the category associated with the tool.
     *
     */
    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Retrieve the requirements associated with the tool.
     *
     */
    public function requirements() : HasMany
    {
        return $this->hasMany(Requirement::class);
    }

    /**
     * Retrieve the skills associated with the tool.
     *
     */
    public function skills() : HasMany
    {
        return $this->hasMany(Skill::class);
    }
}
