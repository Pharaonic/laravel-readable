## API Reference

All methods are static on `Pharaonic\Laravel\Readable\Readable`, also available as the `Readable` alias.

### Numbers

| Method | Description | Returns |
| --- | --- | --- |
| `getNumber(int $input, string $delimiter = ',')` | Integer with grouped thousands. | `string` |
| `getCompactNumber(int $input, bool $showDecimal = false, int $decimals = 0)` | Number with a `K`, `M`, `B` or `T` suffix. Truncated without `$showDecimal`, rounded with it. | `string` |
| `getNumberInWords(int\|float $input, string $locale = 'en')` | Number in words. Non-English locales need intl. | `string` |
| `getDecimal(int\|float $input, int $decimals = 2, string $point = '.', string $delimiter = ',')` | Number with fixed decimals. | `string` |
| `getDecimalOrInteger(int\|float $input, int $decimals = 2, string $point = '.', string $delimiter = ',')` | Like `getDecimal()`, without decimals for whole values. | `string` |

### Dates & Durations

| Method | Description | Returns |
| --- | --- | --- |
| `getDate($input, ?string $timezone = null)` | `24 April 2020` | `string` |
| `getTime($input, $is12 = false, bool $hasSeconds = false, ?string $timezone = null)` | `15:20`, `03:20:22 PM` | `string` |
| `getDateTime($input, $is12 = false, bool $hasSeconds = false, ?string $timezone = null)` | `Friday, April 24, 2020 05:20 PM` | `string` |
| `getRelativeDateTime($date, $other = null, ?string $timezone = null)` | `29 years before`. `$other` defaults to now. | `string` |
| `getDateTimeLength($old, $new = null, bool $full = false, string $comma = ' ', ?string $timezone = null)` | Every unit between two dates when `$full`. | `string` |
| `getDuration(int $seconds, string $separator = ' ', bool $short = false)` | Seconds as a duration. | `string` |
| `prepareDateTime(&$input, ?string $tz = null)` | Parses `$input` into a Carbon instance in place, converted to `$tz`. Used by every date method. | `Carbon` |

### File Sizes

| Method | Description | Returns |
| --- | --- | --- |
| `getFileSize(int $bytes, bool $decimal = true)` | `1.5 KB` (1000-based) or `1.46 KiB` (1024-based). | `string`, or `null` for negative sizes |

### Exceptions

| Exception | Thrown by | When |
| --- | --- | --- |
| `TypeError('Wrong Input Type.')` | `getNumberInWords()`, `getDecimal()`, `getDecimalOrInteger()` | The input is not an `int` or a `float`. |
| `InvalidArgumentException` | `getNumberInWords()` | The input is `INF` or `NAN`, or (on newer ICU builds) `$locale` is not a valid locale. |
| `Pharaonic\Readable\Exceptions\MissingIntlExtension` | `getNumberInWords()` | A non-English locale without the intl extension. |
| `InvalidArgumentException` (Carbon's `InvalidFormatException` on recent Carbon 2 releases) | Date methods | Carbon can't parse the input. |
