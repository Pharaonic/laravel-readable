<?php

use Pharaonic\Laravel\Readable\Readable;

/**
 * Get Readable Integer Number
 *
 * @param int $input
 * @return string
 **/
function ReadableNumber(int $input, string $delimiter = ','): string
{
    return Readable::getNumber($input, $delimiter);
}

/**
 * Get Readable Social Number
 *
 * @param int|double|float $input
 * @param string $lang
 * @return string
 **/
function ReadableNumberToString($input, string $lang = 'en'): string
{
    return Readable::getNumberToString($input, $lang);
}

/**
 * Get Readable Social Number
 *
 * @param int $input
 * @param bool $showDecimal
 * @param int $decimals
 * @return string
 **/
function ReadableHumanNumber(int $input, bool $showDecimal = false, int $decimals = 0): string
{
    return Readable::getHumanNumber($input, $showDecimal, $decimals);
}

/**
 * Get Readable Decimal Number
 *
 * @param int $input
 * @param int $decimals
 * @param string $point
 * @param string $delimiter
 * @return string
 **/
function ReadableDecimal($input, int $decimals = 2, string $point = '.', string $delimiter = ','): ?string
{
    return Readable::getDecimal($input, $decimals, $point, $delimiter);
}

/**
 * Get Readable ( Decimal Number => Decimal || Integer )
 *
 * @param int $input
 * @param int $decimals_length
 * @param string $point
 * @param string $delimiter
 * @return string
 **/
function ReadableDecInt($input, int $decimals_length = 2, string $point = '.', string $delimiter = ','): ?string
{
    return Readable::getDecInt($input, $decimals_length, $point, $delimiter);
}

// DATE & TIME

/**
 * Get Readable Date
 *
 * @param int $input
 * @return string
 **/
function ReadableDate($input, string $timezone = null): ?string
{
    return Readable::getDate($input, $timezone);
}

/**
 * Get Readable Time
 *
 * @param int|Carbon\Carbon $input
 * @param bool $is12
 * @param null|string $timezone
 * @return string
 **/
function ReadableTime($input, $is12 = false, bool $hasSeconds = false, string $timezone = null): ?string
{
    return Readable::getTime($input, $is12, $hasSeconds, $timezone);
}

/**
 * Get Readable DateTime
 *
 * @param int|Carbon\Carbon $input
 * @param bool $is12
 * @param null|string $timezone
 * @return string
 **/
function ReadableDateTime($input, $is12 = false, bool $hasSeconds = false,  string $timezone = null): ?string
{
    return Readable::getDateTime($input, $is12, $hasSeconds, $timezone);
}

/**
 * Get Readable DateTime
 *
 * @param int|Carbon\Carbon $old
 * @param null|int|Carbon\Carbon $new
 * @param null|string $timezone
 * @return string
 **/
function ReadableDiffDateTime($old, $new = null, string $timezone = null): ?string
{
    return Readable::getDiffDateTime($old, $new, $timezone);
}

/**
 * Get Readable DateTime Length from Seconds
 *
 * @param int $input
 * @param string $comma
 * @param boolean $short
 * @return string
 **/
function ReadableTimeLength(int $input, string $comma = ' ', bool $short = false): ?string
{
    return Readable::getTimeLength($input, $comma, $short);
}

/**
 * Get Readable DateTime Length from DateTimes
 *
 * @param int|Carbon\Carbon $old
 * @param null|int|Carbon\Carbon $new
 * @param string $comma
 * @param null|string $timezone
 * @return string
 **/
function ReadableDateTimeLength($old, $new = null, bool $full = false, string $comma = ' ', string $timezone = null): ?string
{
    return Readable::getDateTimeLength($old, $new, $full, $comma, $timezone);
}

// FILE SIZES

/**
 * Get Readable File Size
 *
 * @param int $bytes
 * @return string
 **/
function ReadableSize(int $bytes, bool $decimal = true): ?string
{
    return Readable::getSize($bytes, $decimal);
}
