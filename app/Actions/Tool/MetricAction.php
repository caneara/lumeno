<?php

namespace App\Actions\Tool;

use App\Models\Tool;
use App\Types\Action;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MetricAction extends Action
{
    /**
     * Retrieve the total number of approved and unapproved tools.
     *
     */
    public static function execute() : Collection
    {
        return Tool::query()
            ->select(['approved', DB::raw('COUNT(*) AS `total`')])
            ->groupBy('approved')
            ->get()
            ->mapWithKeys(function($item) {
                return [$item->approved ? 'approved' : 'unapproved' => $item->total];
            });
    }
}
