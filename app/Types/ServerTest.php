<?php

namespace App\Types;

use App\Support\Test;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class ServerTest extends TestCase
{
    use Test;
    use RefreshDatabase;
}
