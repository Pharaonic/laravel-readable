<?php

use Carbon\Carbon;
use Pharaonic\Laravel\Readable\Readable;

// Values 1.x got wrong, and the value 6.x returns instead. Each case notes the 1.x output.

test('getNumber keeps integer precision', function () {
    // 1.x: "9,223,372,036,854,775,808" (number_format() goes through float).
    expect(Readable::getNumber(PHP_INT_MAX))->toBe('9,223,372,036,854,775,807')
        ->and(Readable::getNumber(PHP_INT_MIN, ' '))->toBe('-9 223 372 036 854 775 808')
        // 1.x: "9,007,199,254,740,992".
        ->and(Readable::getNumber(9007199254740993))->toBe('9,007,199,254,740,993');
});

test('getHumanNumber', function (string $expected, array $arguments) {
    expect(Readable::getHumanNumber(...$arguments))->toBe($expected);
})->with([
    // 1.x: "1,000.0K".
    'rounding moves to the next unit' => ['1.0M', [999999, true, 1]],
    // 1.x: "1,000.00M".
    'rounding moves to billions' => ['1.00B', [999999999, true, 2]],
    // 1.x: ErrorException "Undefined variable $getFloor".
    'negative' => ['-1K', [-1500]],
    'negative with decimals' => ['-1.5K', [-1500, true]],
    'negative small' => ['-5', [-5]],
    'minimum integer' => ['-9,223,372T', [PHP_INT_MIN]],
]);

test('getDecInt drops decimals that round away', function () {
    // 1.x: "70.00".
    expect(Readable::getDecInt(70.001))->toBe('70')
        ->and(Readable::getDecInt(69.999))->toBe('70')
        ->and(Readable::getDecInt(-69.999))->toBe('-70')
        // 1.x: "100,000,000,000,000,000,000.00".
        ->and(Readable::getDecInt(1e20))->toBe('100,000,000,000,000,000,000');
});

test('getNumberToString needs no intl for English', function () {
    // 1.x: Error "Class NumberFormatter not found" without intl.
    expect(Readable::getNumberToString(7721))->toBe('seven thousand seven hundred twenty-one')
        ->and(Readable::getNumberToString(-1.5))->toBe('minus one point five')
        // 1.x (intl): "9,223,372,036,854,775,807".
        ->and(Readable::getNumberToString(PHP_INT_MAX))->toBe(
            'nine quintillion two hundred twenty-three quadrillion three hundred seventy-two trillion thirty-six billion '
            .'eight hundred fifty-four million seven hundred seventy-five thousand eight hundred seven'
        );
});

test('getNumberToString joins the Arabic conjunction for every Arabic locale', function () {
    $this->requiresIntl();

    // 1.x: "واحد و عشرون".
    expect(Readable::getNumberToString(21, 'ar_EG'))->toBe('واحد وعشرون');
});

test('getTimeLength', function (string $expected, array $arguments) {
    expect(Readable::getTimeLength(...$arguments))->toBe($expected);
})->with([
    // 1.x: "1 second".
    'zero' => ['0 seconds', [0]],
    'short zero' => ['0s', [0, ' ', true]],
    // 1.x: "1 year 5 days" (a year was 360 days).
    'year is 365 days' => ['1 year', [31536000]],
    // 1.x: "1 year".
    '360 days' => ['12 months', [31104000]],
    // 1.x: "3 years 11 months 2 weeks 4 days 21 hours 33 minutes 9 seconds".
    'every unit' => ['3 years 11 months 3 days 21 hours 33 minutes 9 seconds', [123456789]],
    'short every unit' => ['3yrs 11mos 3d 21h 33m 9s', [123456789, ' ', true]],
    // 1.x: "11 months 4 weeks 1 day 23 hours 59 minutes".
    'sign is ignored' => ['1 minute', [-60]],
    'minimum integer' => ['292471208677 years 6 months 2 weeks 1 day 15 hours 30 minutes 8 seconds', [PHP_INT_MIN]],
]);

test('getSize', function (?string $expected, array $arguments) {
    expect(Readable::getSize(...$arguments))->toBe($expected);
})->with([
    // 1.x: null.
    'zero' => ['0 B', [0]],
    // 1.x: "1000 KB", "1024 KiB".
    'rounding moves to the next unit' => ['1 MB', [999999]],
    'binary rounding moves to the next unit' => ['1 MiB', [1048575, false]],
    // 1.x: "4.86 KB" (floating point noise from log()).
    'rounds half up' => ['4.87 KB', [4865]],
    // 1.x: ErrorException "Undefined array key 5".
    'petabyte' => ['1 PB', [1000000000000000]],
    'exabytes' => ['9.22 EB', [PHP_INT_MAX]],
    'binary exbibytes' => ['8 EiB', [PHP_INT_MAX, false]],
    // 1.x: "1000 B".
    'grouped bytes' => ['1,000 B', [1000, false]],
]);

test('dates never change the given Carbon instance', function () {
    $date = Carbon::parse('2020-04-24 23:30:00', 'UTC');

    expect(Readable::getDate($date, 'Asia/Riyadh'))->toBe('25 April 2020')
        ->and(Readable::getTime($date, false, false, 'Asia/Riyadh'))->toBe('02:30')
        ->and(Readable::getDiffDateTime($date, '2020-04-25 05:30:00', 'Asia/Riyadh'))->toBe('6 hours before')
        ->and(Readable::getDateTimeLength($date, '2020-04-25 05:30:00', true, ' ', 'Asia/Riyadh'))->toBe('6 hours before')
        // 1.x: "Asia/Riyadh".
        ->and($date->tzName)->toBe('UTC');
});

test('prepareDateTime returns the prepared instance', function () {
    $input = '2020-04-24 23:30:00';

    expect($input = Readable::prepareDateTime($input, 'Asia/Riyadh'))->toBe($input)
        ->and($input->toDateTimeString())->toBe('2020-04-25 02:30:00');
});
