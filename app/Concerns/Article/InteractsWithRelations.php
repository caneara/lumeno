<?php

namespace App\Concerns\Article;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait InteractsWithRelations
{
    /**
     * Retrieve the user associated with the article.
     *
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
