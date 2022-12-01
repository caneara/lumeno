<?php

namespace App\Concerns\Category;

use App\Models\Tool;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait InteractsWithRelations
{
    /**
     * Retrieve the tools associated with the category.
     *
     */
    public function tools() : HasMany
    {
        return $this->hasMany(Tool::class);
    }
}
