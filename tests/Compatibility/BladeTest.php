<?php

use Illuminate\Support\Facades\Blade;

// Deprecated 1.x Blade directives. They compile to the canonical methods and echo the raw (unescaped) result.

test('directive compiles to the canonical static call', function (string $directive, string $method) {
    expect(Blade::compileString("@{$directive}(\$value, 1)"))
        ->toBe("<?php echo Pharaonic\\Laravel\\Readable\\Readable::{$method}(\$value, 1); ?>");
})->with([
    ['ReadableNumber', 'getNumber'],
    ['ReadableHumanNumber', 'getCompactNumber'],
    ['ReadableNumberToString', 'getNumberInWords'],
    ['ReadableDecimal', 'getDecimal'],
    ['ReadableDecInt', 'getDecimalOrInteger'],
    ['ReadableDate', 'getDate'],
    ['ReadableTime', 'getTime'],
    ['ReadableDateTime', 'getDateTime'],
    ['ReadableDiffDateTime', 'getRelativeDateTime'],
    ['ReadableTimeLength', 'getDuration'],
    ['ReadableDateTimeLength', 'getDateTimeLength'],
    ['ReadableSize', 'getFileSize'],
]);

test('directive renders', function (string $expected, string $template, array $data = []) {
    expect(renderBlade($template, $data))->toBe($expected);
})->with([
    'number' => ['10,203,040', '@ReadableNumber(10203040)'],
    'number with delimiter' => ['1 234', "@ReadableNumber(1234, ' ')"],
    'human number' => ['77.7K', '@ReadableHumanNumber(77700, true, 1)'],
    'decimal' => ['60,708.54', '@ReadableDecimal($n)', ['n' => 60708.54]],
    'dec int' => ['70', '@ReadableDecInt(70.0)'],
    'date' => ['24 April 2020', "@ReadableDate('24-04-2020')"],
    'null date is now' => ['15 January 2026', '@ReadableDate(null)'],
    'time' => ['03:20 PM', "@ReadableTime('15:20:22', true)"],
    'date time' => ['Friday, April 24, 2020 05:20:30 PM', "@ReadableDateTime('24-04-2020 17:20:30', true, true)"],
    'diff' => ['29 years before', "@ReadableDiffDateTime('01-02-1993 19:00:00', '01-02-2022 19:00:00')"],
    'time length' => ['3 months 29 minutes 37 seconds', '@ReadableTimeLength(7777777)'],
    'date time length' => ['29 years before', "@ReadableDateTimeLength('01-02-1993 19:00:00', '01-02-2022 19:00:00')"],
    'size' => ['7 KiB', '@ReadableSize(7168, false)'],
    'negative size prints nothing' => ['[]', '[@ReadableSize(-1)]'],
    'output is not escaped' => ['1<b>000', "@ReadableNumber(1000, '<b>')"],
    'inline with text' => ['Size: 1.5 KB.', 'Size: @ReadableSize(1500).'],
]);

test('number to string directive renders', function () {
    $this->requiresIntl();

    expect(renderBlade('@ReadableNumberToString(7721)'))->toBe('seven thousand seven hundred twenty-one');
});

test('directive without arguments compiles to an empty call', function () {
    expect(Blade::compileString('@ReadableDate'))
        ->toBe('<?php echo Pharaonic\Laravel\Readable\Readable::getDate(); ?>');
});
