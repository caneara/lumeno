<?php

namespace App\Models;

use Laravel\Paddle\Subscription as Model;
use App\Concerns\Shared\InteractsWithUuid;
use App\Concerns\Shared\InteractsWithFactories;
use App\Concerns\Subscription\InteractsWithRelations;

class Subscription extends Model
{
    use InteractsWithUuid;
    use InteractsWithFactories;
    use InteractsWithRelations;
}
