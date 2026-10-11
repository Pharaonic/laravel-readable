<?php

// Legacy (1.x) global helpers.

test('number helpers', function () {
    expect(ReadableNumber(10203040))->toBe('10,203,040')
        ->and(ReadableNumber(1234, ' '))->toBe('1 234')
        ->and(ReadableHumanNumber(77700))->toBe('77K')
        ->and(ReadableHumanNumber(77749, true, 2))->toBe('77.75K')
        ->and(ReadableDecimal(60708.54))->toBe('60,708.54')
        ->and(ReadableDecimal(1234.5678, 3, ',', '.'))->toBe('1.234,568')
        ->and(ReadableDecInt(70.0))->toBe('70')
        ->and(ReadableDecInt(70.07))->toBe('70.07');
});

test('number to string helper', function () {
    $this->requiresIntl();

    expect(ReadableNumberToString(7721))->toBe('seven thousand seven hundred twenty-one')
        ->and(ReadableNumberToString(21, 'ar'))->toBe('واحد وعشرون');
});

test('number helpers keep their type checks', function () {
    ReadableDecimal('7');
})->throws(TypeError::class, 'Wrong Input Type.');

test('date helpers', function () {
    expect(ReadableDate('24-04-2020'))->toBe('24 April 2020')
        ->and(ReadableDate('2020-04-24 23:30:00', 'Asia/Riyadh'))->toBe('25 April 2020')
        ->and(ReadableTime('15:20:22'))->toBe('15:20')
        ->and(ReadableTime('15:20:22', true, true))->toBe('03:20:22 PM')
        ->and(ReadableTime('2020-01-01 15:20', false, false, 'Africa/Cairo'))->toBe('17:20')
        ->and(ReadableDateTime('24-04-2020 17:20:30', true, true))->toBe('Friday, April 24, 2020 05:20:30 PM')
        ->and(ReadableDiffDateTime('01-02-1993 19:00:00', '01-02-2022 19:00:00'))->toBe('29 years before')
        ->and(ReadableDiffDateTime('2026-01-15 11:00:00'))->toBe('1 hour before')
        ->and(ReadableTimeLength(7777777))->toBe('3 months 29 minutes 37 seconds')
        ->and(ReadableTimeLength(7777777, ' ', true))->toBe('3mos 29m 37s')
        ->and(ReadableDateTimeLength('1993-01-02 19:00:00', '2022-03-05 20:07:07', true, ' - '))
        ->toBe('29 years - 2 months - 3 days - 1 hour - 7 minutes - 7 seconds before');
});

test('size helper', function () {
    expect(ReadableSize(1500))->toBe('1.5 KB')
        ->and(ReadableSize(7168, false))->toBe('7 KiB')
        ->and(ReadableSize(-1))->toBeNull();
});
