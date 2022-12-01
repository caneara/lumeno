<?php

namespace App\Models;

use Laravel\Paddle\Customer as Model;
use App\Concerns\Shared\InteractsWithUuid;

class Customer extends Model
{
    use InteractsWithUuid;
}
