<?php

namespace Pharaonic\Laravel\Readable\Tests;

use Carbon\Carbon;
use Orchestra\Testbench\TestCase as Orchestra;
use Pharaonic\Laravel\Readable\Readable;
use Pharaonic\Laravel\Readable\ReadableServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        date_default_timezone_set('UTC');
        Carbon::setTestNow('2026-01-15 12:00:00');
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();

        parent::tearDown();
    }

    protected function getPackageProviders($app)
    {
        return [ReadableServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return ['Readable' => Readable::class];
    }

    protected function requiresIntl(): void
    {
        if (! extension_loaded('intl')) {
            $this->markTestSkipped('The intl extension is not loaded.');
        }
    }
}
