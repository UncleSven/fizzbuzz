<?php

declare(strict_types = 1);

namespace Tests;

use Illuminate\Foundation\Testing\TestCase;

abstract class IntegrationTestCase extends TestCase
{
    use CreatesApplication;
}
