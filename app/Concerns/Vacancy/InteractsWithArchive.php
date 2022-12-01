<?php

namespace App\Concerns\Vacancy;

trait InteractsWithArchive
{
    /**
     * Determine if the vacancy has been archived.
     *
     */
    public function isArchived() : bool
    {
        return ! ! $this->archived_at;
    }

    /**
     * Determine if the vacancy has not been archived.
     *
     */
    public function isNotArchived() : bool
    {
        return ! $this->isArchived();
    }
}
