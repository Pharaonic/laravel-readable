<?php

namespace Pharaonic\Laravel\Readable\Tests\Feature;

use Illuminate\Support\Facades\Blade;
use Pharaonic\Laravel\Readable\Readable;
use Pharaonic\Laravel\Readable\Tests\TestCase;

class ServiceProviderTest extends TestCase
{
    public function test_it_registers_every_directive(): void
    {
        $directives = array_keys(Blade::getCustomDirectives());

        foreach ([
            'ReadableNumber', 'ReadableHumanNumber', 'ReadableNumberToString', 'ReadableDecimal', 'ReadableDecInt',
            'ReadableDate', 'ReadableTime', 'ReadableDateTime', 'ReadableDiffDateTime', 'ReadableTimeLength',
            'ReadableDateTimeLength', 'ReadableSize',
        ] as $directive) {
            $this->assertContains($directive, $directives);
        }
    }

    public function test_readable_alias_points_at_the_static_class(): void
    {
        $this->assertSame('10,203,040', \Readable::getNumber(10203040));
        $this->assertInstanceOf(Readable::class, new \Readable);
    }

    public function test_composer_declares_the_provider_and_alias_for_discovery(): void
    {
        $composer = json_decode((string) file_get_contents(__DIR__.'/../../composer.json'), true);

        $this->assertSame(['Pharaonic\\Laravel\\Readable\\ReadableServiceProvider'], $composer['extra']['laravel']['providers']);
        $this->assertSame(['Readable' => 'Pharaonic\\Laravel\\Readable\\Readable'], $composer['extra']['laravel']['aliases']);
    }
}
