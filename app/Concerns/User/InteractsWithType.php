<?php

namespace App\Concerns\User;

use App\Models\User;

trait InteractsWithType
{
    /**
     * Determine if the user has the 'customer' type.
     *
     */
    public function isCustomer() : bool
    {
        return $this->type === User::TYPE_CUSTOMER;
    }

    /**
     * Determine if the user has the 'employee' type.
     *
     */
    public function isEmployee() : bool
    {
        return $this->type === User::TYPE_EMPLOYEE;
    }
}
