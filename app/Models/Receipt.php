<?php

namespace App\Models;

use Laravel\Paddle\Receipt as Model;
use App\Concerns\Shared\InteractsWithUuid;

class Receipt extends Model
{
    use InteractsWithUuid;
}
