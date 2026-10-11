<?php

use Illuminate\Support\Facades\Blade;
use Pharaonic\Laravel\Readable\Readable;

// Canonical names, and the deprecated 1.x names that alias them.

test('deprecated method returns the canonical result', function (string $deprecated, string $canonical, array $arguments) {
    expect(Readable::{$deprecated}(...$arguments))->toBe(Readable::{$canonical}(...$arguments));
})->with([
    ['getHumanNumber', 'getCompactNumber', [77749, true, 2]],
    ['getDecInt', 'getDecimalOrInteger', [70.07]],
    ['getDiffDateTime', 'getRelativeDateTime', ['01-02-1993 19:00:00', '01-02-2022 19:00:00']],
    ['getTimeLength', 'getDuration', [7777777, ', ', true]],
    ['getSize', 'getFileSize', [7168, false]],
]);

test('deprecated getNumberToString returns the canonical result', function () {
    expect(Readable::getNumberInWords(21))->toBe('twenty-one')
        ->and(Readable::getNumberToString(21))->toBe(Readable::getNumberInWords(21));
});

test('canonical methods', function () {
    expect(Readable::getCompactNumber(77700))->toBe('77K')
        ->and(Readable::getCompactNumber(999999, true))->toBe('1.0M')
        ->and(Readable::getDecimalOrInteger(69.999))->toBe('70')
        ->and(Readable::getDecimalOrInteger(1234.567, 2, ',', '.'))->toBe('1.234,57')
        ->and(Readable::getRelativeDateTime('01-02-1993 19:00:00', '01-02-2022 19:00:00'))->toBe('29 years before')
        ->and(Readable::getDuration(3661))->toBe('1 hour 1 minute 1 second')
        ->and(Readable::getDuration(3661, ', ', true))->toBe('1h, 1m, 1s')
        ->and(Readable::getFileSize(1500))->toBe('1.5 KB')
        ->and(Readable::getFileSize(-1))->toBeNull();
});

test('canonical methods accept named arguments', function () {
    expect(Readable::getDecimalOrInteger(70.07, decimals: 1))->toBe('70.1')
        ->and(Readable::getDuration(61, separator: '|', short: true))->toBe('1m|1s')
        ->and(Readable::getNumberInWords(21, locale: 'en'))->toBe('twenty-one');
});

test('deprecated methods keep their 1.x parameter names', function () {
    expect(Readable::getDecInt(70.07, decimals_length: 1))->toBe('70.1')
        ->and(Readable::getTimeLength(61, comma: '|', short: true))->toBe('1m|1s')
        ->and(Readable::getNumberToString(21, lang: 'en'))->toBe('twenty-one');
});

test('snake_case helper and deprecated helper match the method', function (string $helper, string $deprecated, string $method, array $arguments) {
    $expected = Readable::{$method}(...$arguments);

    expect($helper(...$arguments))->toBe($expected)
        ->and($deprecated(...$arguments))->toBe($expected);
})->with([
    ['readable_number', 'ReadableNumber', 'getNumber', [1234, ' ']],
    ['readable_compact_number', 'ReadableHumanNumber', 'getCompactNumber', [77749, true, 2]],
    ['readable_number_in_words', 'ReadableNumberToString', 'getNumberInWords', [21]],
    ['readable_decimal', 'ReadableDecimal', 'getDecimal', [1234.5678, 3, ',', '.']],
    ['readable_decimal_or_integer', 'ReadableDecInt', 'getDecimalOrInteger', [70.07]],
    ['readable_date', 'ReadableDate', 'getDate', ['24-04-2020']],
    ['readable_time', 'ReadableTime', 'getTime', ['15:20:22', true, true]],
    ['readable_date_time', 'ReadableDateTime', 'getDateTime', ['24-04-2020 17:20:30', true]],
    ['readable_relative_date_time', 'ReadableDiffDateTime', 'getRelativeDateTime', ['01-02-1993 19:00:00', '01-02-2022 19:00:00']],
    ['readable_duration', 'ReadableTimeLength', 'getDuration', [7777777]],
    ['readable_date_time_length', 'ReadableDateTimeLength', 'getDateTimeLength', ['01-02-1993 19:00:00', '01-02-2022 19:00:00', true]],
    ['readable_file_size', 'ReadableSize', 'getFileSize', [7168, false]],
]);

test('canonical directive compiles to the canonical static call', function (string $directive, string $method) {
    expect(Blade::compileString("@{$directive}(\$value, 1)"))
        ->toBe("<?php echo Pharaonic\\Laravel\\Readable\\Readable::{$method}(\$value, 1); ?>");
})->with([
    ['readableNumber', 'getNumber'],
    ['readableCompactNumber', 'getCompactNumber'],
    ['readableNumberInWords', 'getNumberInWords'],
    ['readableDecimal', 'getDecimal'],
    ['readableDecimalOrInteger', 'getDecimalOrInteger'],
    ['readableDate', 'getDate'],
    ['readableTime', 'getTime'],
    ['readableDateTime', 'getDateTime'],
    ['readableRelativeDateTime', 'getRelativeDateTime'],
    ['readableDuration', 'getDuration'],
    ['readableDateTimeLength', 'getDateTimeLength'],
    ['readableFileSize', 'getFileSize'],
]);

test('canonical directive renders the same as the deprecated one', function () {
    expect(renderBlade('@readableCompactNumber(77700, true, 1)'))->toBe('77.7K')
        ->and(renderBlade('@ReadableHumanNumber(77700, true, 1)'))->toBe(renderBlade('@readableCompactNumber(77700, true, 1)'));
});
