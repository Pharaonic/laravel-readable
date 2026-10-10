<?php

use Pharaonic\Laravel\Readable\Readable;

// NUMBERS

if (! function_exists('ReadableNumber')) {
    /**
     * Get Readable Integer Number
     */
    function ReadableNumber(int $input, string $delimiter = ','): string
    {
        return Readable::getNumber($input, $delimiter);
    }
}

if (! function_exists('ReadableNumberToString')) {
    /**
     * Get Readable String of Number
     *
     * @param  int|float  $input
     */
    function ReadableNumberToString($input, string $lang = 'en'): string
    {
        return Readable::getNumberToString($input, $lang);
    }
}

if (! function_exists('ReadableHumanNumber')) {
    /**
     * Get Readable Social Number
     */
    function ReadableHumanNumber(int $input, bool $showDecimal = false, int $decimals = 0): string
    {
        return Readable::getHumanNumber($input, $showDecimal, $decimals);
    }
}

if (! function_exists('ReadableDecimal')) {
    /**
     * Get Readable Decimal Number
     *
     * @param  int|float  $input
     */
    function ReadableDecimal($input, int $decimals = 2, string $point = '.', string $delimiter = ','): ?string
    {
        return Readable::getDecimal($input, $decimals, $point, $delimiter);
    }
}

if (! function_exists('ReadableDecInt')) {
    /**
     * Get Readable ( Decimal Number => Decimal || Integer )
     *
     * @param  int|float  $input
     */
    function ReadableDecInt($input, int $decimals_length = 2, string $point = '.', string $delimiter = ','): ?string
    {
        return Readable::getDecInt($input, $decimals_length, $point, $delimiter);
    }
}

// DATE & TIME

if (! function_exists('ReadableDate')) {
    /**
     * Get Readable Date
     *
     * @param  mixed  $input
     */
    function ReadableDate($input, ?string $timezone = null): ?string
    {
        return Readable::getDate($input, $timezone);
    }
}

if (! function_exists('ReadableTime')) {
    /**
     * Get Readable Time
     *
     * @param  mixed  $input
     * @param  bool  $is12
     */
    function ReadableTime($input, $is12 = false, bool $hasSeconds = false, ?string $timezone = null): ?string
    {
        return Readable::getTime($input, $is12, $hasSeconds, $timezone);
    }
}

if (! function_exists('ReadableDateTime')) {
    /**
     * Get Readable DateTime
     *
     * @param  mixed  $input
     * @param  bool  $is12
     */
    function ReadableDateTime($input, $is12 = false, bool $hasSeconds = false, ?string $timezone = null): ?string
    {
        return Readable::getDateTime($input, $is12, $hasSeconds, $timezone);
    }
}

if (! function_exists('ReadableDiffDateTime')) {
    /**
     * Get Readable DateTime Difference
     *
     * @param  mixed  $old
     * @param  mixed  $new
     */
    function ReadableDiffDateTime($old, $new = null, ?string $timezone = null): ?string
    {
        return Readable::getDiffDateTime($old, $new, $timezone);
    }
}

if (! function_exists('ReadableTimeLength')) {
    /**
     * Get Readable DateTime Length from Seconds
     */
    function ReadableTimeLength(int $input, string $comma = ' ', bool $short = false): ?string
    {
        return Readable::getTimeLength($input, $comma, $short);
    }
}

if (! function_exists('ReadableDateTimeLength')) {
    /**
     * Get Readable DateTime Length from DateTimes
     *
     * @param  mixed  $old
     * @param  mixed  $new
     */
    function ReadableDateTimeLength($old, $new = null, bool $full = false, string $comma = ' ', ?string $timezone = null): ?string
    {
        return Readable::getDateTimeLength($old, $new, $full, $comma, $timezone);
    }
}

// FILE SIZES

if (! function_exists('ReadableSize')) {
    /**
     * Get Readable File Size
     */
    function ReadableSize(int $bytes, bool $decimal = true): ?string
    {
        return Readable::getSize($bytes, $decimal);
    }
}
