<?php

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Support\Carbon as IlluminateCarbon;
use Pharaonic\Laravel\Readable\Readable;

// Legacy (1.x) date and time behavior kept in 6.x. Corrected values live in LegacyFixesTest.
// "Now" is frozen at 2026-01-15 12:00:00 UTC.

test('getDate', function (string $expected, $input, ?string $timezone = null) {
    expect(Readable::getDate($input, $timezone))->toBe($expected);
})->with([
    'readme' => ['24 April 2020', '24-04-2020'],
    'timezone moves the day' => ['25 April 2020', '2020-04-24 23:30:00', 'Asia/Riyadh'],
    'timestamp' => ['24 April 2020', 1587686400],
    'timestamp string' => ['24 April 2020', '@1587686400'],
    'null is now' => ['15 January 2026', null],
    'empty string is now' => ['15 January 2026', ''],
    'native DateTime' => ['24 April 2020', new DateTime('2020-04-24')],
    'immutable Carbon' => ['24 April 2020', CarbonImmutable::parse('2020-04-24')],
    'Illuminate Carbon' => ['24 April 2020', IlluminateCarbon::parse('2020-04-24')],
]);

test('getTime', function (string $expected, array $arguments) {
    expect(Readable::getTime(...$arguments))->toBe($expected);
})->with([
    '24 hours' => ['15:20', ['15:20:22']],
    '24 hours with seconds' => ['15:20:22', ['15:20:22', false, true]],
    'readme' => ['03:20 PM', ['15:20:22', true]],
    '12 hours with seconds' => ['03:20:22 PM', ['15:20:22', true, true]],
    'midnight' => ['12:05 AM', ['00:05:00', true]],
    'truthy is12' => ['03:20 PM', ['15:20:22', 'yes']],
    'timezone' => ['17:20', ['2020-01-01 15:20', false, false, 'Africa/Cairo']],
]);

test('getDateTime', function (string $expected, array $arguments) {
    expect(Readable::getDateTime(...$arguments))->toBe($expected);
})->with([
    '24 hours' => ['Friday, April 24, 2020 17:20', ['24-04-2020 17:20:30']],
    '24 hours with seconds' => ['Friday, April 24, 2020 17:20:30', ['24-04-2020 17:20:30', false, true]],
    '12 hours' => ['Friday, April 24, 2020 05:20 PM', ['24-04-2020 17:20:30', true]],
    'readme' => ['Friday, April 24, 2020 05:20:30 PM', ['24-04-2020 17:20:30', true, true]],
    'timezone' => ['Sunday, April 05, 2020 04:20 PM', ['2020-04-05 07:20:30', true, false, 'Asia/Tokyo']],
]);

test('getDiffDateTime', function (string $expected, array $arguments) {
    expect(Readable::getDiffDateTime(...$arguments))->toBe($expected);
})->with([
    'readme' => ['29 years before', ['01-02-1993 19:00:00', '01-02-2022 19:00:00']],
    'after' => ['29 years after', ['2022-01-01', '1993-01-01']],
    'past against now' => ['1 hour before', ['2026-01-15 11:00:00']],
    'future against now' => ['5 days after', ['2026-01-20 12:00:00']],
]);

test('getTimeLength', function (string $expected, array $arguments) {
    expect(Readable::getTimeLength(...$arguments))->toBe($expected);
})->with([
    'one second' => ['1 second', [1]],
    'seconds' => ['59 seconds', [59]],
    'minute' => ['1 minute', [60]],
    'minute and second' => ['1 minute 1 second', [61]],
    'hour' => ['1 hour', [3600]],
    'hour minute second' => ['1 hour 1 minute 1 second', [3661]],
    'day' => ['1 day', [86400]],
    'readme' => ['3 months 29 minutes 37 seconds', [7777777]],
    'weeks' => ['2 weeks 4 days 1 hour', [1558800]],
    'month is 30 days' => ['1 month', [2592000]],
    'separator' => ['3 months, 29 minutes, 37 seconds', [7777777, ', ']],
    'short' => ['3mos 29m 37s', [7777777, ' ', true]],
    'short weeks' => ['2w 4d 1h', [1558800, ' ', true]],
]);

test('getDateTimeLength', function (string $expected, array $arguments) {
    expect(Readable::getDateTimeLength(...$arguments))->toBe($expected);
})->with([
    'readme' => ['29 years before', ['01-02-1993 19:00:00', '01-02-2022 19:00:00']],
    'full' => ['29 years 2 months 3 days 1 hour 7 minutes 7 seconds before', ['1993-01-02 19:00:00', '2022-03-05 20:07:07', true]],
    'full with separator' => ['29 years - 2 months - 3 days - 1 hour - 7 minutes - 7 seconds before', ['1993-01-02 19:00:00', '2022-03-05 20:07:07', true, ' - ']],
    'separator without full' => ['29 years before', ['1993-01-02 19:00:00', '2022-03-05 20:07:07', false, ' - ']],
    'full against now' => ['1 day 2 hours before', ['2026-01-14 10:00:00', null, true]],
]);

test('prepareDateTime parses by reference', function () {
    $input = '2020-04-24 23:30:00';

    Readable::prepareDateTime($input, 'Asia/Riyadh');

    expect($input)->toBeInstanceOf(Carbon::class)
        ->and($input->toDateTimeString())->toBe('2020-04-25 02:30:00')
        ->and($input->tzName)->toBe('Asia/Riyadh');
});

test('prepareDateTime keeps Carbon instances', function () {
    $input = $original = IlluminateCarbon::parse('2020-04-24');

    Readable::prepareDateTime($input);

    expect($input)->toBe($original);
});
