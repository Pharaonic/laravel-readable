<?php

namespace Pharaonic\Laravel\Readable;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Support\Carbon as IlluminateCarbon;
use Pharaonic\Readable\Bytes;
use Pharaonic\Readable\Number;
use TypeError;

class Readable
{
    /**
     * Human number units, from the smallest.
     */
    private const HUMAN_NUMBER_UNITS = ['', 'K', 'M', 'B', 'T'];

    /**
     * Seconds per time length unit. A year is 365 days and a month is 30 days.
     */
    private const TIME_LENGTH_UNITS = [
        'years' => 31536000,
        'months' => 2592000,
        'days' => 86400,
        'hours' => 3600,
        'minutes' => 60,
        'seconds' => 1,
    ];

    // NUMBERS

    /**
     * Get Readable Integer Number
     */
    public static function getNumber(int $input, string $delimiter = ','): string
    {
        return str_replace(',', $delimiter, Number::format($input));
    }

    /**
     * Get Readable Social Number
     *
     * Without $showDecimal the value is truncated to whole units (77700 → "77K").
     */
    public static function getHumanNumber(int $input, bool $showDecimal = false, int $decimals = 0): string
    {
        if ($input === 0) {
            return '0';
        }

        $decimals = $showDecimal && $decimals == 0 ? 1 : $decimals;
        $absolute = abs($input);
        $last = count(self::HUMAN_NUMBER_UNITS) - 1;
        $unit = 0;

        while ($unit < $last && $absolute >= 1000 ** ($unit + 1)) {
            $unit++;
        }

        $value = $absolute / 1000 ** $unit;

        if (! $showDecimal) {
            $value = floor($value);
        } elseif (round($value, $decimals) >= 1000 && $unit < $last) {
            // Rounding can reach the next unit: 999 999 is "1.0M", not "1,000.0K".
            $value = $absolute / 1000 ** ++$unit;
        }

        return ($input < 0 ? '-' : '').number_format($value, $decimals).self::HUMAN_NUMBER_UNITS[$unit];
    }

    /**
     * Get Readable String of Number
     *
     * English is spelled out natively. Any other language requires the intl extension.
     *
     * @param  int|float  $input
     */
    public static function getNumberToString($input, string $lang = 'en'): string
    {
        self::assertNumber($input);

        return Number::spell($input, $lang === 'en' ? null : $lang);
    }

    /**
     * Get Readable Decimal Number
     *
     * @param  int|float  $input
     * @return string
     */
    public static function getDecimal($input, int $decimals = 2, string $point = '.', string $delimiter = ','): ?string
    {
        self::assertNumber($input);

        return number_format($input, $decimals, $point, $delimiter);
    }

    /**
     * Get Readable ( Decimal Number => Decimal || Integer )
     *
     * Integers, and floats that round to a whole number, have no decimals (70.00 → "70").
     *
     * @param  int|float  $input
     * @return string
     */
    public static function getDecInt($input, int $decimals_length = 2, string $point = '.', string $delimiter = ','): ?string
    {
        self::assertNumber($input);

        if (is_int($input) || fmod(round($input, $decimals_length), 1) == 0) {
            $decimals_length = 0;
        }

        return number_format($input, $decimals_length, $point, $delimiter);
    }

    // DATE & TIME

    /**
     * Prepare DateTime Variable => Object
     *
     * A Carbon instance is copied before its timezone changes, so the caller's instance is never modified.
     *
     * @param  mixed  $input
     * @return \Carbon\Carbon
     */
    public static function prepareDateTime(&$input, ?string $tz = null)
    {
        if (! $input instanceof Carbon) {
            $input = IlluminateCarbon::parse($input);
        } elseif ($tz) {
            $input = $input->copy();
        }

        if ($tz) {
            $input->setTimezone($tz);
        }

        return $input;
    }

    /**
     * Get Readable Date
     *
     * @param  mixed  $input
     * @return string
     */
    public static function getDate($input, ?string $timezone = null): ?string
    {
        self::prepareDateTime($input, $timezone);

        return $input->day.' '.$input->monthName.' '.$input->year;
    }

    /**
     * Get Readable Time
     *
     * @param  mixed  $input
     * @param  bool  $is12
     * @return string
     */
    public static function getTime($input, $is12 = false, bool $hasSeconds = false, ?string $timezone = null): ?string
    {
        self::prepareDateTime($input, $timezone);

        if ($is12) {
            return $input->format('h:i'.($hasSeconds ? ':s' : '').' ').$input->meridiem();
        }

        return $input->format('H:i'.($hasSeconds ? ':s' : ''));
    }

    /**
     * Get Readable DateTime
     *
     * @param  mixed  $input
     * @param  bool  $is12
     * @return string
     */
    public static function getDateTime($input, $is12 = false, bool $hasSeconds = false, ?string $timezone = null): ?string
    {
        self::prepareDateTime($input, $timezone);

        return $input->isoFormat('dddd, MMMM DD, YYYY '.($is12 ? 'hh:mm'.($hasSeconds ? ':ss' : '').' A' : 'HH:mm'.($hasSeconds ? ':ss' : '')));
    }

    /**
     * Get Readable DateTime
     *
     * @param  mixed  $old
     * @param  mixed  $new
     * @return string
     */
    public static function getDiffDateTime($old, $new = null, ?string $timezone = null): ?string
    {
        self::prepareDateTime($old, $timezone);
        self::prepareDateTime($new, $timezone);

        return $old->diffForHumans($new);
    }

    /**
     * Get Readable DateTime Length from Seconds
     *
     * The sign is ignored and zero is "0 seconds".
     *
     * @return string
     */
    public static function getTimeLength(int $input, string $comma = ' ', bool $short = false): ?string
    {
        $values = [];

        foreach (self::TIME_LENGTH_UNITS as $unit => $seconds) {
            // intdiv() and % keep the sign, so PHP_INT_MIN never needs abs().
            $values[$unit] = abs(intdiv($input, $seconds));
            $input %= $seconds;
        }

        $interval = new CarbonInterval(
            $values['years'], $values['months'], null, $values['days'],
            $values['hours'], $values['minutes'], $values['seconds']
        );

        return $interval->forHumans(['join' => $comma, 'short' => $short, 'options' => 0]);
    }

    /**
     * Get Readable DateTime Length from DateTimes
     *
     * @param  mixed  $old
     * @param  mixed  $new
     * @return string
     */
    public static function getDateTimeLength($old, $new = null, bool $full = false, string $comma = ' ', ?string $timezone = null): ?string
    {
        self::prepareDateTime($old, $timezone);
        self::prepareDateTime($new, $timezone);

        return $old->diffForHumans($new, ['parts' => $full ? 7 : 0, 'join' => $comma]);
    }

    // FILE SIZES

    /**
     * Get Readable File Size
     *
     * Negative sizes return null.
     *
     * @param  bool  $decimal  1 KB = 1000 B when true, 1 KiB = 1024 B when false.
     */
    public static function getSize(int $bytes, bool $decimal = true): ?string
    {
        if ($bytes < 0) {
            return null;
        }

        return Bytes::format($bytes, 2, ! $decimal);
    }

    /**
     * Keep the 1.x type check: only real integers and floats are numbers.
     *
     * @param  mixed  $input
     *
     * @throws \TypeError
     */
    private static function assertNumber($input): void
    {
        if (! is_int($input) && ! is_float($input)) {
            throw new TypeError('Wrong Input Type.');
        }
    }
}
