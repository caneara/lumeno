<?php

namespace App\Support;

use Carbon\CarbonImmutable;
use Carbon\Carbon as BaseCarbon;
use Illuminate\Support\Facades\Date;

class Carbon extends CarbonImmutable
{
    /**
     * Format the instance as a human-friendly date.
     *
     */
    public function date() : string
    {
        return $this->format('M j, Y');
    }

    /**
     * Format the instance as a human-friendly date and time.
     *
     */
    public function dateTime() : string
    {
        return $this->format('M j, Y - H:i');
    }

    /**
     * Lock the current date and time.
     *
     */
    public static function freeze() : void
    {
        parent::setTestNow(now()->startOfSecond());
        BaseCarbon::setTestNow(now()->startOfSecond());
    }

    /**
     * Ensure that Laravel always uses an immutable Carbon instance.
     *
     */
    public static function useImmutable() : void
    {
        Date::use(static::class);
    }

    /**
     * Format the instance as a human-friendly time.
     *
     */
    public function time() : string
    {
        return $this->format('H:i');
    }
}
