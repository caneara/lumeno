<?php

namespace App\Models;

use Spark\Billable;
use App\Types\Model;
use App\Casts\ReadOnlyJsonCast;
use Illuminate\Notifications\Notifiable;
use App\Concerns\Shared\InteractsWithUuid;
use App\Concerns\Organization\InteractsWithBilling;
use App\Concerns\Organization\InteractsWithRelations;
use Propaganistas\LaravelPhone\Casts\E164PhoneNumberCast;

class Organization extends Model
{
    use Billable;
    use Notifiable;
    use InteractsWithUuid;
    use InteractsWithBilling;
    use InteractsWithRelations;

    /**
     * The attributes that should be cast to specific types.
     *
     */
    protected $casts = [
        'id'      => 'string',
        'name'    => 'string',
        'email'   => 'string',
        'phone'   => E164PhoneNumberCast::class,
        'website' => 'string',
        'metrics' => ReadOnlyJsonCast::class,
    ];

    /**
     * Retrieve the email address associated with the Paddle customer.
     *
     */
    public function paddleEmail() : string
    {
        return $this->email;
    }
}
