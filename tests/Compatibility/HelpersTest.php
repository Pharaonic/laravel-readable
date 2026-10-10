<?php

namespace Pharaonic\Laravel\Readable\Tests\Compatibility;

use Pharaonic\Laravel\Readable\Tests\TestCase;
use TypeError;

/**
 * Legacy (1.x) global helpers.
 */
class HelpersTest extends TestCase
{
    public function test_number_helpers(): void
    {
        $this->assertSame('10,203,040', ReadableNumber(10203040));
        $this->assertSame('1 234', ReadableNumber(1234, ' '));
        $this->assertSame('77K', ReadableHumanNumber(77700));
        $this->assertSame('77.75K', ReadableHumanNumber(77749, true, 2));
        $this->assertSame('60,708.54', ReadableDecimal(60708.54));
        $this->assertSame('1.234,568', ReadableDecimal(1234.5678, 3, ',', '.'));
        $this->assertSame('70', ReadableDecInt(70.0));
        $this->assertSame('70.07', ReadableDecInt(70.07));
    }

    public function test_number_to_string_helper(): void
    {
        $this->requiresIntl();

        $this->assertSame('seven thousand seven hundred twenty-one', ReadableNumberToString(7721));
        $this->assertSame('واحد وعشرون', ReadableNumberToString(21, 'ar'));
    }

    public function test_number_helpers_keep_their_type_checks(): void
    {
        $this->expectException(TypeError::class);
        $this->expectExceptionMessage('Wrong Input Type.');

        ReadableDecimal('7');
    }

    public function test_date_helpers(): void
    {
        $this->assertSame('24 April 2020', ReadableDate('24-04-2020'));
        $this->assertSame('25 April 2020', ReadableDate('2020-04-24 23:30:00', 'Asia/Riyadh'));
        $this->assertSame('15:20', ReadableTime('15:20:22'));
        $this->assertSame('03:20:22 PM', ReadableTime('15:20:22', true, true));
        $this->assertSame('17:20', ReadableTime('2020-01-01 15:20', false, false, 'Africa/Cairo'));
        $this->assertSame('Friday, April 24, 2020 05:20:30 PM', ReadableDateTime('24-04-2020 17:20:30', true, true));
        $this->assertSame('29 years before', ReadableDiffDateTime('01-02-1993 19:00:00', '01-02-2022 19:00:00'));
        $this->assertSame('1 hour before', ReadableDiffDateTime('2026-01-15 11:00:00'));
        $this->assertSame('3 months 29 minutes 37 seconds', ReadableTimeLength(7777777));
        $this->assertSame('3mos 29m 37s', ReadableTimeLength(7777777, ' ', true));
        $this->assertSame(
            '29 years - 2 months - 3 days - 1 hour - 7 minutes - 7 seconds before',
            ReadableDateTimeLength('1993-01-02 19:00:00', '2022-03-05 20:07:07', true, ' - ')
        );
    }

    public function test_size_helper(): void
    {
        $this->assertSame('1.5 KB', ReadableSize(1500));
        $this->assertSame('7 KiB', ReadableSize(7168, false));
        $this->assertNull(ReadableSize(-1));
    }
}
