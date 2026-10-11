## Upgrading from 1.x

Every 1.x method, helper, Blade directive and the `Readable` alias still work with the same signatures, and every correct 1.x output is unchanged. The upgrade fixes values that 1.x got wrong and introduces clearer names; the 1.x names stay as deprecated aliases.

### Requirements

6.x requires PHP 8.0 and Laravel 6.20+. The package now depends on `illuminate/support`, `illuminate/view` and `pharaonic/php-readable` instead of `laravel/framework`.

### Renamed APIs

Six methods have clearer names, helpers are now `snake_case`, and Blade directives are now camelCase. The 1.x names call the new ones and return the same values.

| 1.x method | 6.x method |
| --- | --- |
| `getHumanNumber()` | `getCompactNumber()` |
| `getNumberToString()` | `getNumberInWords()` |
| `getDecInt()` | `getDecimalOrInteger()` |
| `getDiffDateTime()` | `getRelativeDateTime()` |
| `getTimeLength()` | `getDuration()` |
| `getSize()` | `getFileSize()` |

Helpers and directives follow the method names:

| 1.x helper | 6.x helper | 1.x directive | 6.x directive |
| --- | --- | --- | --- |
| `ReadableNumber()` | `readable_number()` | `@ReadableNumber` | `@readableNumber` |
| `ReadableHumanNumber()` | `readable_compact_number()` | `@ReadableHumanNumber` | `@readableCompactNumber` |
| `ReadableNumberToString()` | `readable_number_in_words()` | `@ReadableNumberToString` | `@readableNumberInWords` |
| `ReadableDecimal()` | `readable_decimal()` | `@ReadableDecimal` | `@readableDecimal` |
| `ReadableDecInt()` | `readable_decimal_or_integer()` | `@ReadableDecInt` | `@readableDecimalOrInteger` |
| `ReadableDate()` | `readable_date()` | `@ReadableDate` | `@readableDate` |
| `ReadableTime()` | `readable_time()` | `@ReadableTime` | `@readableTime` |
| `ReadableDateTime()` | `readable_date_time()` | `@ReadableDateTime` | `@readableDateTime` |
| `ReadableDiffDateTime()` | `readable_relative_date_time()` | `@ReadableDiffDateTime` | `@readableRelativeDateTime` |
| `ReadableTimeLength()` | `readable_duration()` | `@ReadableTimeLength` | `@readableDuration` |
| `ReadableDateTimeLength()` | `readable_date_time_length()` | `@ReadableDateTimeLength` | `@readableDateTimeLength` |
| `ReadableSize()` | `readable_file_size()` | `@ReadableSize` | `@readableFileSize` |

The new methods also use clearer parameter names, which matters only with named arguments: `$locale` instead of `$lang`, `$decimals` instead of `$decimals_length`, `$separator` instead of `$comma`, and `$seconds` instead of `$input` in `getDuration()`. The deprecated names keep their 1.x parameter names.

:::warning Deprecated Names
The 1.x names are deprecated. They keep working on every current line and are removed in the first line that supports PHP 8.6. Move to the new names when you upgrade.
:::

### Fixed Values

The table uses the 1.x names; the new names return the same values.


| Call | 1.x | 6.x |
| --- | --- | --- |
| `getNumber(PHP_INT_MAX)` | `9,223,372,036,854,775,808` | `9,223,372,036,854,775,807` |
| `getHumanNumber(999999, true)` | `1,000.0K` | `1.0M` |
| `getHumanNumber(-1500)` | `ErrorException` | `-1K` |
| `getDecInt(69.999)` | `70.00` | `70` |
| `getNumberToString(21, 'ar_EG')` | `واحد و عشرون` | `واحد وعشرون` |
| `getTimeLength(0)` | `1 second` | `0 seconds` |
| `getTimeLength(31536000)` | `1 year 5 days` | `1 year` |
| `getTimeLength(-60)` | `11 months 4 weeks 1 day 23 hours 59 minutes` | `1 minute` |
| `getSize(0)` | `null` | `0 B` |
| `getSize(999999)` | `1000 KB` | `1 MB` |
| `getSize(4865)` | `4.86 KB` | `4.87 KB` |
| `getSize(10 ** 15)` | `ErrorException` | `1 PB` |

Passing a Carbon instance with a timezone no longer changes your instance:

```php
$date = Carbon::parse('2020-04-24 23:30:00', 'UTC');

Readable::getDate($date, 'Asia/Riyadh'); // "25 April 2020"
$date->tzName;                           // "UTC" (1.x: "Asia/Riyadh")
```

### Other Changes

- `getNumberInWords()` spells English without the intl extension. Other languages throw `MissingIntlExtension` when intl is missing.
- `getNumberInWords(INF)` and `getNumberInWords(NAN)` throw `InvalidArgumentException` (1.x printed `infinity` and `not a number`).
- `getDuration()` counts a year as 365 days (it was 360). A month is still 30 days.
- Binary sizes between 1000 and 1023 units are grouped: `1,000 KiB`.
- `Readable::prepareDateTime()` also returns the prepared instance.
- Global helpers are declared only when a function with the same name doesn't already exist.

:::info Unchanged on Purpose
`getCompactNumber()` still truncates without decimals (`77700` → `77K`), `getFileSize()` still returns `null` for negative sizes, and Blade directives still echo without escaping.
:::
