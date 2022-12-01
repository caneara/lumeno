<?php

namespace App\Concerns\Subscription;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait InteractsWithRelations
{
    /**
     * Retrieve the organization associated with the subscription.
     *
     */
    public function organization() : BelongsTo
    {
        return $this->belongsTo(Organization::class, 'billable_id')
            ->where('billable_type', Organization::class);
    }
}
