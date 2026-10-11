<?php

namespace Pharaonic\Laravel\Readable;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use DateTimeInterface;
use Illuminate\Support\Carbon as IlluminateCarbon;
use Pharaonic\Readable\Bytes;
use Pharaonic\Readable\Number;
use TypeError;

class Readable
{
    /**
     * Compact number units, from the smallest.
     */
    private const COMPACT_NUMBER_UNITS = ['', 'K', 'M', 'B', 'T'];

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
     * Get Readable Compact Number: 77700 → "77K"
     *
     * Without $showDecimal the value is truncated to whole units (77700 → "77K").
     */
    public static function getCompactNumber(int $input, bool $showDecimal = false, int $decimals = 0): string
    {
        if ($input === 0) {
            return '0';
        }

        $decimals = $showDecimal && $decimals == 0 ? 1 : $decimals;
        $absolute = abs($input);
        $last = count(self::COMPACT_NUMBER_UNITS) - 1;
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

        return ($input < 0 ? '-' : '').number_format($value, $decimals).self::COMPACT_NUMBER_UNITS[$unit];
    }

    /**
     * Get Readable Number in Words: 21 → "twenty-one"
     *
     * English is spelled out natively. Any other locale requires the intl extension.
     *
     * @param  int|float  $input
     */
    public static function getNumberInWords($input, string $locale = 'en'): string
    {
        self::assertNumber($input);

        return Number::spell($input, $locale === 'en' ? null : $locale);
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
     * Get Readable Decimal or Integer Number
     *
     * Integers, and floats that round to a whole number, have no decimals (70.00 → "70").
     *
     * @param  int|float  $input
     */
    public static function getDecimalOrInteger($input, int $decimals = 2, string $point = '.', string $delimiter = ','): string
    {
        self::assertNumber($input);

        if (is_int($input) || fmod(round($input, $decimals), 1) == 0) {
            $decimals = 0;
        }

        return number_format($input, $decimals, $point, $delimiter);
    }

    // DATE & TIME

    /**
     * Prepare DateTime Variable => Object
     *
     * A Carbon instance is copied before its timezone changes, so the caller's instance is never modified.
     *
     * @param  \DateTimeInterface|string|null  $input
     *
     * @param-out \Carbon\Carbon  $input
     *
     * @return \Carbon\Carbon
     */
    public static function prepareDateTime(&$input, ?string $tz = null)
    {
        if ($input instanceof Carbon) {
            $input = $tz ? clone $input : $input;
        } elseif ($input instanceof DateTimeInterface) {
            $input = IlluminateCarbon::instance($input);
        } else {
            $input = IlluminateCarbon::parse($input);
        }

        if ($tz) {
            $input->setTimezone($tz);
        }

        return $input;
    }

    /**
     * Get Readable Date
     *
     * @param  \DateTimeInterface|string|null  $input
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
     * @param  \DateTimeInterface|string|null  $input
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
     * @param  \DateTimeInterface|string|null  $input
     * @param  bool  $is12
     * @return string
     */
    public static function getDateTime($input, $is12 = false, bool $hasSeconds = false, ?string $timezone = null): ?string
    {
        self::prepareDateTime($input, $timezone);

        return $input->isoFormat('dddd, MMMM DD, YYYY '.($is12 ? 'hh:mm'.($hasSeconds ? ':ss' : '').' A' : 'HH:mm'.($hasSeconds ? ':ss' : '')));
    }

    /**
     * Get Readable Relative DateTime: "3 days ago", or "29 years before" against $other
     *
     * @param  \DateTimeInterface|string|null  $date
     * @param  \DateTimeInterface|string|null  $other  Now when null.
     */
    public static function getRelativeDateTime($date, $other = null, ?string $timezone = null): string
    {
        self::prepareDateTime($date, $timezone);
        self::prepareDateTime($other, $timezone);

        return $date->diffForHumans($other);
    }

    /**
     * Get Readable Duration from Seconds: 3661 → "1 hour 1 minute 1 second"
     *
     * The sign is ignored and zero is "0 seconds".
     */
    public static function getDuration(int $seconds, string $separator = ' ', bool $short = false): string
    {
        $values = [];

        foreach (self::TIME_LENGTH_UNITS as $unit => $length) {
            // intdiv() and % keep the sign, so PHP_INT_MIN never needs abs().
            $values[$unit] = abs(intdiv($seconds, $length));
            $seconds %= $length;
        }

        $interval = new CarbonInterval(
            $values['years'], $values['months'], null, $values['days'],
            $values['hours'], $values['minutes'], $values['seconds']
        );

        return $interval->forHumans(['join' => $separator, 'short' => $short, 'options' => 0]);
    }

    /**
     * Get Readable DateTime Length from DateTimes
     *
     * @param  \DateTimeInterface|string|null  $old
     * @param  \DateTimeInterface|string|null  $new
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
    public static function getFileSize(int $bytes, bool $decimal = true): ?string
    {
        if ($bytes < 0) {
            return null;
        }

        return Bytes::format($bytes, 2, ! $decimal);
    }

    // DEPRECATED ALIASES

    /**
     * @deprecated Use {@see Readable::getCompactNumber()}. Removed in the first line that supports PHP 8.6.
     */
    public static function getHumanNumber(int $input, bool $showDecimal = false, int $decimals = 0): string
    {
        return self::getCompactNumber($input, $showDecimal, $decimals);
    }

    /**
     * @deprecated Use {@see Readable::getNumberInWords()}. Removed in the first line that supports PHP 8.6.
     *
     * @param  int|float  $input
     */
    public static function getNumberToString($input, string $lang = 'en'): string
    {
        return self::getNumberInWords($input, $lang);
    }

    /**
     * @deprecated Use {@see Readable::getDecimalOrInteger()}. Removed in the first line that supports PHP 8.6.
     *
     * @param  int|float  $input
     */
    public static function getDecInt($input, int $decimals_length = 2, string $point = '.', string $delimiter = ','): ?string
    {
        return self::getDecimalOrInteger($input, $decimals_length, $point, $delimiter);
    }

    /**
     * @deprecated Use {@see Readable::getRelativeDateTime()}. Removed in the first line that supports PHP 8.6.
     *
     * @param  \DateTimeInterface|string|null  $old
     * @param  \DateTimeInterface|string|null  $new
     */
    public static function getDiffDateTime($old, $new = null, ?string $timezone = null): ?string
    {
        return self::getRelativeDateTime($old, $new, $timezone);
    }

    /**
     * @deprecated Use {@see Readable::getDuration()}. Removed in the first line that supports PHP 8.6.
     */
    public static function getTimeLength(int $input, string $comma = ' ', bool $short = false): ?string
    {
        return self::getDuration($input, $comma, $short);
    }

    /**
     * @deprecated Use {@see Readable::getFileSize()}. Removed in the first line that supports PHP 8.6.
     */
    public static function getSize(int $bytes, bool $decimal = true): ?string
    {
        return self::getFileSize($bytes, $decimal);
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
