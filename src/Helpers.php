<?php

use Pharaonic\Laravel\Readable\Readable;

// NUMBERS

if (! function_exists('readable_number')) {
    /**
     * Get Readable Integer Number
     */
    function readable_number(int $input, string $delimiter = ','): string
    {
        return Readable::getNumber($input, $delimiter);
    }
}

if (! function_exists('readable_compact_number')) {
    /**
     * Get Readable Compact Number: 77700 → "77K"
     */
    function readable_compact_number(int $input, bool $showDecimal = false, int $decimals = 0): string
    {
        return Readable::getCompactNumber($input, $showDecimal, $decimals);
    }
}

if (! function_exists('readable_number_in_words')) {
    /**
     * Get Readable Number in Words: 21 → "twenty-one"
     *
     * @param  int|float  $input
     */
    function readable_number_in_words($input, string $locale = 'en'): string
    {
        return Readable::getNumberInWords($input, $locale);
    }
}

if (! function_exists('readable_decimal')) {
    /**
     * Get Readable Decimal Number
     *
     * @param  int|float  $input
     */
    function readable_decimal($input, int $decimals = 2, string $point = '.', string $delimiter = ','): ?string
    {
        return Readable::getDecimal($input, $decimals, $point, $delimiter);
    }
}

if (! function_exists('readable_decimal_or_integer')) {
    /**
     * Get Readable Decimal or Integer Number
     *
     * @param  int|float  $input
     */
    function readable_decimal_or_integer($input, int $decimals = 2, string $point = '.', string $delimiter = ','): string
    {
        return Readable::getDecimalOrInteger($input, $decimals, $point, $delimiter);
    }
}

// DATE & TIME

if (! function_exists('readable_date')) {
    /**
     * Get Readable Date
     *
     * @param  \DateTimeInterface|string|null  $input
     */
    function readable_date($input, ?string $timezone = null): ?string
    {
        return Readable::getDate($input, $timezone);
    }
}

if (! function_exists('readable_time')) {
    /**
     * Get Readable Time
     *
     * @param  \DateTimeInterface|string|null  $input
     */
    function readable_time($input, bool $is12 = false, bool $hasSeconds = false, ?string $timezone = null): ?string
    {
        return Readable::getTime($input, $is12, $hasSeconds, $timezone);
    }
}

if (! function_exists('readable_date_time')) {
    /**
     * Get Readable DateTime
     *
     * @param  \DateTimeInterface|string|null  $input
     */
    function readable_date_time($input, bool $is12 = false, bool $hasSeconds = false, ?string $timezone = null): ?string
    {
        return Readable::getDateTime($input, $is12, $hasSeconds, $timezone);
    }
}

if (! function_exists('readable_relative_date_time')) {
    /**
     * Get Readable Relative DateTime: "3 days ago"
     *
     * @param  \DateTimeInterface|string|null  $date
     * @param  \DateTimeInterface|string|null  $other
     */
    function readable_relative_date_time($date, $other = null, ?string $timezone = null): string
    {
        return Readable::getRelativeDateTime($date, $other, $timezone);
    }
}

if (! function_exists('readable_duration')) {
    /**
     * Get Readable Duration from Seconds: 3661 → "1 hour 1 minute 1 second"
     */
    function readable_duration(int $seconds, string $separator = ' ', bool $short = false): string
    {
        return Readable::getDuration($seconds, $separator, $short);
    }
}

if (! function_exists('readable_date_time_length')) {
    /**
     * Get Readable DateTime Length from DateTimes
     *
     * @param  \DateTimeInterface|string|null  $old
     * @param  \DateTimeInterface|string|null  $new
     */
    function readable_date_time_length($old, $new = null, bool $full = false, string $comma = ' ', ?string $timezone = null): ?string
    {
        return Readable::getDateTimeLength($old, $new, $full, $comma, $timezone);
    }
}

// FILE SIZES

if (! function_exists('readable_file_size')) {
    /**
     * Get Readable File Size
     */
    function readable_file_size(int $bytes, bool $decimal = true): ?string
    {
        return Readable::getFileSize($bytes, $decimal);
    }
}

// DEPRECATED ALIASES

if (! function_exists('ReadableNumber')) {
    /**
     * @deprecated Use readable_number(). Removed in the first line that supports PHP 8.6.
     */
    function ReadableNumber(int $input, string $delimiter = ','): string
    {
        return Readable::getNumber($input, $delimiter);
    }
}

if (! function_exists('ReadableNumberToString')) {
    /**
     * @deprecated Use readable_number_in_words(). Removed in the first line that supports PHP 8.6.
     *
     * @param  int|float  $input
     */
    function ReadableNumberToString($input, string $lang = 'en'): string
    {
        return Readable::getNumberInWords($input, $lang);
    }
}

if (! function_exists('ReadableHumanNumber')) {
    /**
     * @deprecated Use readable_compact_number(). Removed in the first line that supports PHP 8.6.
     */
    function ReadableHumanNumber(int $input, bool $showDecimal = false, int $decimals = 0): string
    {
        return Readable::getCompactNumber($input, $showDecimal, $decimals);
    }
}

if (! function_exists('ReadableDecimal')) {
    /**
     * @deprecated Use readable_decimal(). Removed in the first line that supports PHP 8.6.
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
     * @deprecated Use readable_decimal_or_integer(). Removed in the first line that supports PHP 8.6.
     *
     * @param  int|float  $input
     */
    function ReadableDecInt($input, int $decimals_length = 2, string $point = '.', string $delimiter = ','): string
    {
        return Readable::getDecimalOrInteger($input, $decimals_length, $point, $delimiter);
    }
}

if (! function_exists('ReadableDate')) {
    /**
     * @deprecated Use readable_date(). Removed in the first line that supports PHP 8.6.
     *
     * @param  \DateTimeInterface|string|null  $input
     */
    function ReadableDate($input, ?string $timezone = null): ?string
    {
        return Readable::getDate($input, $timezone);
    }
}

if (! function_exists('ReadableTime')) {
    /**
     * @deprecated Use readable_time(). Removed in the first line that supports PHP 8.6.
     *
     * @param  \DateTimeInterface|string|null  $input
     * @param  bool  $is12
     */
    function ReadableTime($input, $is12 = false, bool $hasSeconds = false, ?string $timezone = null): ?string
    {
        return Readable::getTime($input, $is12, $hasSeconds, $timezone);
    }
}

if (! function_exists('ReadableDateTime')) {
    /**
     * @deprecated Use readable_date_time(). Removed in the first line that supports PHP 8.6.
     *
     * @param  \DateTimeInterface|string|null  $input
     * @param  bool  $is12
     */
    function ReadableDateTime($input, $is12 = false, bool $hasSeconds = false, ?string $timezone = null): ?string
    {
        return Readable::getDateTime($input, $is12, $hasSeconds, $timezone);
    }
}

if (! function_exists('ReadableDiffDateTime')) {
    /**
     * @deprecated Use readable_relative_date_time(). Removed in the first line that supports PHP 8.6.
     *
     * @param  \DateTimeInterface|string|null  $old
     * @param  \DateTimeInterface|string|null  $new
     */
    function ReadableDiffDateTime($old, $new = null, ?string $timezone = null): string
    {
        return Readable::getRelativeDateTime($old, $new, $timezone);
    }
}

if (! function_exists('ReadableTimeLength')) {
    /**
     * @deprecated Use readable_duration(). Removed in the first line that supports PHP 8.6.
     */
    function ReadableTimeLength(int $input, string $comma = ' ', bool $short = false): string
    {
        return Readable::getDuration($input, $comma, $short);
    }
}

if (! function_exists('ReadableDateTimeLength')) {
    /**
     * @deprecated Use readable_date_time_length(). Removed in the first line that supports PHP 8.6.
     *
     * @param  \DateTimeInterface|string|null  $old
     * @param  \DateTimeInterface|string|null  $new
     */
    function ReadableDateTimeLength($old, $new = null, bool $full = false, string $comma = ' ', ?string $timezone = null): ?string
    {
        return Readable::getDateTimeLength($old, $new, $full, $comma, $timezone);
    }
}

if (! function_exists('ReadableSize')) {
    /**
     * @deprecated Use readable_file_size(). Removed in the first line that supports PHP 8.6.
     */
    function ReadableSize(int $bytes, bool $decimal = true): ?string
    {
        return Readable::getFileSize($bytes, $decimal);
    }
}
