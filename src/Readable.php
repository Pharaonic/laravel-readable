<?php

namespace Pharaonic\Laravel\Readable;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Support\Carbon as IlluminateCarbon;
use TypeError;

class Readable
{

    // NUMBERS

    /**
     * Get Readable Integer Number
     *
     * @param int $input
     * @return string
     **/
    public static function getNumber(int $input, string $delimiter = ','): string
    {
        return number_format($input, 0, '.', $delimiter);
    }

    /**
     * Get Readable Social Number
     *
     * @param int $input
     * @param bool $showDecimal
     * @param int $decimals
     * @return string
     **/
    public static function getHumanNumber(int $input, bool $showDecimal = false, int $decimals = 0): string
    {
        $decimals = $showDecimal && $decimals == 0 ? 1 : $decimals;
        $floorNumber = 0;

        if ($input >= 0 && $input < 1000) {
            // 1 - 999
            $getFloor = floor($input);
            $suffix = '';
        } elseif ($input >= 1000 && $input < 1000000) {
            // 1k-999k
            $getFloor = floor($input / 1000);
            $floorNumber = 1000;
            $suffix = 'K';
        } elseif ($input >= 1000000 && $input < 1000000000) {
            // 1m-999m
            $getFloor = floor($input / 1000000);
            $floorNumber = 1000000;
            $suffix = 'M';
        } elseif ($input >= 1000000000 && $input < 1000000000000) {
            // 1b-999b
            $getFloor = floor($input / 1000000000);
            $floorNumber = 1000000000;
            $suffix = 'B';
        } elseif ($input >= 1000000000000) {
            // 1t+
            $getFloor = floor($input / 1000000000000);
            $floorNumber = 1000000000000;
            $suffix = 'T';
        }

        // Decimals
        if ($showDecimal && $floorNumber > 0) {
            $input -= ($getFloor * $floorNumber);
            if ($input > 0) {
                $input /= $floorNumber;
                $getFloor += $input;
            }
        }

        return !empty($getFloor . $suffix) ? number_format($getFloor, $decimals) . $suffix : 0;
    }

    /**
     * Get Readable String of Number
     *
     * @param int|double|float $input
     * @param string $lang
     * @return string
     **/
    public static function getNumberToString($input, string $lang = 'en'): string
    {
        if (!in_array(gettype($input), ['integer', 'double', 'float'])) throw new TypeError("Wrong Input Type.");

        $digit = new \NumberFormatter($lang, \NumberFormatter::SPELLOUT);
        $input = $digit->format($input);
        return $lang == 'ar' ? str_replace('و ', 'و', $input) : $input;
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
    public static function getDecimal($input, int $decimals = 2, string $point = '.', string $delimiter = ','): ?string
    {
        if (!in_array(gettype($input), ['integer', 'double', 'float'])) throw new TypeError("Wrong Input Type.");

        return number_format($input, $decimals, $point, $delimiter);
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
    public static function getDecInt($input, int $decimals_length = 2, string $point = '.', string $delimiter = ','): ?string
    {
        if (!in_array(gettype($input), ['integer', 'double', 'float'])) throw new TypeError("Wrong Input Type.");

        // Convert Decimal to Integer if $decimals_length == 0 || use the limiter
        if (is_float($input)) {
            $decInt = $input - (int) $input;

            if ($decInt == 0) {
                $input = (int) $input;
                $decimals_length = 0;
            }
        } else if (is_int($input)) {
            $decimals_length = 0;
        }

        return number_format($input, $decimals_length, $point, $delimiter);
    }

    // DATE & TIME

    /**
     * Prepare DateTime Variable => Object
     *
     *
     * @param string|Carbon\Carbon $input
     * @param null|string $tz
     * @return Carbon\Carbon
     **/
    public static function prepareDateTime(&$input, string $tz = null)
    {
        if (!($input instanceof Carbon) && !($input instanceof IlluminateCarbon))
            $input = Carbon::parse($input);

        if ($tz) $input->setTimezone($tz);
    }

    /**
     * Get Readable Date
     *
     * @param int $input
     * @return string
     **/
    public static function getDate($input, string $timezone = null): ?string
    {
        self::prepareDateTime($input, $timezone);
        return $input->day . ' ' . $input->monthName . ' ' . $input->year;
    }

    /**
     * Get Readable Time
     *
     * @param int|Carbon\Carbon $input
     * @param bool $is12
     * @param null|string $timezone
     * @return string
     **/
    public static function getTime($input, $is12 = false, bool $hasSeconds = false, string $timezone = null): ?string
    {
        self::prepareDateTime($input, $timezone);

        if ($is12)
            return $input->format('h:i' . ($hasSeconds ? ':s' : '') . ' ') . $input->meridiem();

        return $input->format('H:i' . ($hasSeconds ? ':s' : ''));
    }

    /**
     * Get Readable DateTime
     *
     * @param int|Carbon\Carbon $input
     * @param bool $is12
     * @param null|string $timezone
     * @return string
     **/
    public static function getDateTime($input, $is12 = false, bool $hasSeconds = false,  string $timezone = null): ?string
    {
        self::prepareDateTime($input, $timezone);
        return $input->isoFormat('dddd, MMMM DD, YYYY ' . ($is12 ? 'hh:mm' . ($hasSeconds ? ':ss' : '') . ' A' : 'HH:mm' . ($hasSeconds ? ':ss' : '')));
    }

    /**
     * Get Readable DateTime
     *
     * @param int|Carbon\Carbon $old
     * @param null|int|Carbon\Carbon $new
     * @param null|string $timezone
     * @return string
     **/
    public static function getDiffDateTime($old, $new = null, string $timezone = null): ?string
    {
        self::prepareDateTime($old, $timezone);
        self::prepareDateTime($new, $timezone);

        return $old->diffForHumans($new);
    }

    /**
     * Get Readable DateTime Length from Seconds
     *
     * @param int $input
     * @param string $comma
     * @param boolean $short
     * @return string
     **/
    public static function getTimeLength(int $input, string $comma = ' ', bool $short = false): ?string
    {
        //years
        $years = floor($input / 31104000);
        $input -= $years * 31104000;

        //months
        $months = floor($input / 2592000);
        $input -= $months * 2592000;

        //days
        $days = floor($input / 86400);
        $input -= $days * 86400;

        //hours
        $hours = floor($input / 3600);
        $input -= $hours * 3600;

        //minutes
        $minutes = floor($input / 60);
        $input -= $minutes * 60;

        //seconds
        $seconds = $input % 60;

        $obj = new CarbonInterval($years, $months, null, $days, $hours, $minutes, $seconds);
        return $obj->forHumans(['join' => $comma, 'short' => $short]);
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
    public static function getDateTimeLength($old, $new = null, bool $full = false, string $comma = ' ', string $timezone = null): ?string
    {
        self::prepareDateTime($old, $timezone);
        self::prepareDateTime($new, $timezone);

        return $old->diffForHumans($new, ['parts' => $full ? 7 : 0, 'join' => $comma]);
    }

    // FILE SIZES

    /**
     * Get Readable File Size
     *
     * @param int $bytes
     * @param bool $decimal
     * @return string
     */
    public static function getSize(int $bytes, bool $decimal = true): ?string
    {
        if ($bytes <= 0) return null;
        $calcBase = $decimal ? 1000 : 1024;

        $bytes = (int) $bytes;
        $base = log($bytes) / log($calcBase);
        $suffixes = $decimal ? ['B', 'KB', 'MB', 'GB', 'TB'] : ['B', 'KiB', 'MiB', 'GiB', 'TiB'];

        return round(pow($calcBase, $base - floor($base)), 2) . ' ' . $suffixes[floor($base)];
    }
}
