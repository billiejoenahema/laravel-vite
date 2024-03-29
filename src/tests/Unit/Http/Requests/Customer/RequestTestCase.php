<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Requests\Customer;

use Tests\TestCase;

abstract class RequestTestCase extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->createApplication();
    }
}
