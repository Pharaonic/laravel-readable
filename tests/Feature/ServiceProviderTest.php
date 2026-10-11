<?php

use Illuminate\Support\Facades\Blade;
use Pharaonic\Laravel\Readable\Readable;

test('it registers every directive', function () {
    expect(array_keys(Blade::getCustomDirectives()))->toContain(
        'readableNumber', 'readableCompactNumber', 'readableNumberInWords', 'readableDecimal', 'readableDecimalOrInteger',
        'readableDate', 'readableTime', 'readableDateTime', 'readableRelativeDateTime', 'readableDuration',
        'readableDateTimeLength', 'readableFileSize',
        'ReadableNumber', 'ReadableHumanNumber', 'ReadableNumberToString', 'ReadableDecimal', 'ReadableDecInt',
        'ReadableDate', 'ReadableTime', 'ReadableDateTime', 'ReadableDiffDateTime', 'ReadableTimeLength',
        'ReadableDateTimeLength', 'ReadableSize',
    );
});

test('Readable alias points at the static class', function () {
    expect(\Readable::getNumber(10203040))->toBe('10,203,040')
        ->and(new \Readable)->toBeInstanceOf(Readable::class);
});

test('composer declares the provider and alias for discovery', function () {
    $composer = json_decode((string) file_get_contents(__DIR__.'/../../composer.json'), true);

    expect($composer['extra']['laravel']['providers'])->toBe(['Pharaonic\\Laravel\\Readable\\ReadableServiceProvider'])
        ->and($composer['extra']['laravel']['aliases'])->toBe(['Readable' => 'Pharaonic\\Laravel\\Readable\\Readable']);
});
