<?php

namespace Pharaonic\Laravel\Readable\Tests\Unit;

use Carbon\Carbon;
use Pharaonic\Laravel\Readable\Readable;
use Pharaonic\Laravel\Readable\Tests\TestCase;

/**
 * Values 1.x got wrong, and the value 6.x returns instead. Each case notes the 1.x output.
 */
class LegacyFixesTest extends TestCase
{
    public function test_get_number_keeps_integer_precision(): void
    {
        // 1.x: "9,223,372,036,854,775,808" (number_format() goes through float).
        $this->assertSame('9,223,372,036,854,775,807', Readable::getNumber(PHP_INT_MAX));
        $this->assertSame('-9 223 372 036 854 775 808', Readable::getNumber(PHP_INT_MIN, ' '));
        // 1.x: "9,007,199,254,740,992".
        $this->assertSame('9,007,199,254,740,993', Readable::getNumber(9007199254740993));
    }

    /**
     * @dataProvider humanNumbers
     */
    public function test_get_human_number(string $expected, array $arguments): void
    {
        $this->assertSame($expected, Readable::getHumanNumber(...$arguments));
    }

    public static function humanNumbers(): array
    {
        return [
            // 1.x: "1,000.0K".
            'rounding moves to the next unit' => ['1.0M', [999999, true, 1]],
            // 1.x: "1,000.00M".
            'rounding moves to billions' => ['1.00B', [999999999, true, 2]],
            // 1.x: ErrorException "Undefined variable $getFloor".
            'negative' => ['-1K', [-1500]],
            'negative with decimals' => ['-1.5K', [-1500, true]],
            'negative small' => ['-5', [-5]],
            'minimum integer' => ['-9,223,372T', [PHP_INT_MIN]],
        ];
    }

    public function test_get_dec_int_drops_decimals_that_round_away(): void
    {
        // 1.x: "70.00".
        $this->assertSame('70', Readable::getDecInt(70.001));
        $this->assertSame('70', Readable::getDecInt(69.999));
        $this->assertSame('-70', Readable::getDecInt(-69.999));
        // 1.x: "100,000,000,000,000,000,000.00".
        $this->assertSame('100,000,000,000,000,000,000', Readable::getDecInt(1e20));
    }

    public function test_get_number_to_string_needs_no_intl_for_english(): void
    {
        // 1.x: Error "Class NumberFormatter not found" without intl.
        $this->assertSame('seven thousand seven hundred twenty-one', Readable::getNumberToString(7721));
        $this->assertSame('minus one point five', Readable::getNumberToString(-1.5));
        // 1.x (intl): "9,223,372,036,854,775,807".
        $this->assertSame(
            'nine quintillion two hundred twenty-three quadrillion three hundred seventy-two trillion thirty-six billion '
            .'eight hundred fifty-four million seven hundred seventy-five thousand eight hundred seven',
            Readable::getNumberToString(PHP_INT_MAX)
        );
    }

    public function test_get_number_to_string_joins_the_arabic_conjunction_for_every_arabic_locale(): void
    {
        $this->requiresIntl();

        // 1.x: "واحد و عشرون".
        $this->assertSame('واحد وعشرون', Readable::getNumberToString(21, 'ar_EG'));
    }

    /**
     * @dataProvider timeLengths
     */
    public function test_get_time_length(string $expected, array $arguments): void
    {
        $this->assertSame($expected, Readable::getTimeLength(...$arguments));
    }

    public static function timeLengths(): array
    {
        return [
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
        ];
    }

    /**
     * @dataProvider sizes
     */
    public function test_get_size(?string $expected, array $arguments): void
    {
        $this->assertSame($expected, Readable::getSize(...$arguments));
    }

    public static function sizes(): array
    {
        return [
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
        ];
    }

    public function test_dates_never_change_the_given_carbon_instance(): void
    {
        $date = Carbon::parse('2020-04-24 23:30:00', 'UTC');

        $this->assertSame('25 April 2020', Readable::getDate($date, 'Asia/Riyadh'));
        $this->assertSame('02:30', Readable::getTime($date, false, false, 'Asia/Riyadh'));
        $this->assertSame('6 hours before', Readable::getDiffDateTime($date, '2020-04-25 05:30:00', 'Asia/Riyadh'));
        $this->assertSame('6 hours before', Readable::getDateTimeLength($date, '2020-04-25 05:30:00', true, ' ', 'Asia/Riyadh'));

        // 1.x: "Asia/Riyadh".
        $this->assertSame('UTC', $date->tzName);
    }

    public function test_prepare_date_time_returns_the_prepared_instance(): void
    {
        $input = '2020-04-24 23:30:00';

        $this->assertSame($input = Readable::prepareDateTime($input, 'Asia/Riyadh'), $input);
        $this->assertSame('2020-04-25 02:30:00', $input->toDateTimeString());
    }
}
