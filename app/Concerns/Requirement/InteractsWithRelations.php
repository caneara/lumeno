<?php

namespace App\Concerns\Requirement;

use App\Models\Tool;
use App\Models\Vacancy;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait InteractsWithRelations
{
    /**
     * Retrieve the organization associated with the requirement.
     *
     */
    public function organization() : BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Retrieve the tool associated with the requirement.
     *
     */
    public function tool() : BelongsTo
    {
        return $this->belongsTo(Tool::class);
    }

    /**
     * Retrieve the vacancy associated with the requirement.
     *
     */
    public function vacancy() : BelongsTo
    {
        return $this->belongsTo(Vacancy::class);
    }
}
