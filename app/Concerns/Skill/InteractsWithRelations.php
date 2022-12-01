<?php

namespace App\Concerns\Skill;

use App\Models\Tool;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait InteractsWithRelations
{
    /**
     * Retrieve the tool associated with the skill.
     *
     */
    public function tool() : BelongsTo
    {
        return $this->belongsTo(Tool::class);
    }

    /**
     * Retrieve the user associated with the skill.
     *
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
