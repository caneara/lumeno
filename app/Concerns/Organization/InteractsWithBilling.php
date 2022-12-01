<?php

namespace App\Concerns\Organization;

use App\Support\Carbon;
use Illuminate\Support\Facades\DB;

trait InteractsWithBilling
{
    /**
     * Retrieve the relevant billing details for the organization.
     *
     */
    public function billing() : static
    {
        $subscription = $this->subscription()->paddleInfo();

        $period = [
            $this->last_payment_date = Carbon::make($subscription['last_payment']['date'])->startOfDay(),
            $this->next_payment_date = Carbon::make($subscription['next_payment']['date'])->endOfDay(),
        ];

        $this->usage_this_cycle = $this->invitations()
            ->whereBetween('invitations.created_at', $period)
            ->value(DB::raw('COUNT(*)'));

        return $this;
    }
}
